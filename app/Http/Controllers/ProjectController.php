<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ScopeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $user = Auth::user();
        $projects = collect(); // Default to an empty collection

        // Eager load relationships for efficiency
        if ($user->role === 'student') {
            $projects = $user->projects()->with(['supervisor', 'latestScopeDocument'])->latest()->get();
        } elseif ($user->role === 'supervisor') {
            $projects = $user->supervisedProjects()->with(['student', 'latestScopeDocument'])->latest()->get();
        }

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        $supervisors = User::where('role', 'supervisor')
            ->whereHas('supervisorProfile', function ($query) {
                $query->where('available_slots', '>', 0);
            })
            ->orderBy('name')
            ->get();

        return view('projects.create', ['supervisors' => $supervisors]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'supervisor_id' => 'required|exists:users,id',
        ]);

        Auth::user()->projects()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'supervisor_id' => $validated['supervisor_id'],
            'status' => 'pending',
        ]);

        return redirect()->route('projects.index')->with('success', 'Project idea submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
     public function edit(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized Action');
        }

        if ($project->status !== 'rejected') {
            return redirect()->route('projects.index')->with('error', 'Only rejected projects can be edited.');
        }

        $availableSupervisors = User::where('role', 'supervisor')
            ->whereHas('supervisorProfile', function ($query) {
                $query->where('available_slots', '>', 0);
            })
            ->orderBy('name')
            ->get();

        $originalSupervisor = $project->supervisor;

        if ($originalSupervisor && !$availableSupervisors->contains('id', $originalSupervisor->id)) {
            $availableSupervisors->push($originalSupervisor);
        }

        return view('projects.edit', [
            'project' => $project,
            'supervisors' => $availableSupervisors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, Project $project): RedirectResponse
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'supervisor_id' => 'required|exists:users,id',
        ]);

        $project->fill($validated);

        if ($project->status === 'rejected') {
            $project->status = 'pending';
            $project->rejection_reason = null;
        }

        $project->save();

        return redirect()->route('projects.index')->with('success', 'Project updated successfully and is pending approval.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Fix: Use user_id instead of student_id (consistent with your other methods)
        if ($project->user_id !== auth()->id()) {
            return back()->withErrors(['error' => 'You can only delete your own projects.']);
        }

        // Check if project has a scope document uploaded
        if ($project->latestScopeDocument) {
            return back()->withErrors(['error' => 'Cannot delete project with uploaded scope document.']);
        }

        // Check if project has defence sessions
        if ($project->defenceSessions()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete project with scheduled defence sessions.']);
        }

        $projectTitle = $project->title;
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', "Project \"{$projectTitle}\" deleted successfully.");
    }
    // ... (create, store, edit, update methods remain the same as your last version) ...
    // To save space, I'm omitting the methods that are already correct.
    // The key changes are in the `storeScopeDocument` and `downloadScopeDocument` methods below.

    public function createScopeDocument(Project $project)
    {
        if (Auth::id() !== $project->user_id) { abort(403); }
        if ($project->status !== 'approved') {
            return redirect()->route('projects.index')->with('error', 'Scope document can only be uploaded for approved projects.');
        }
        return view('projects.scope.create', ['project' => $project]);
    }

    /**
     * Store a scope document uploaded BY A STUDENT.
     */
    public function storeScopeDocument(Request $request, Project $project): RedirectResponse
    {
        if (Auth::id() !== $project->user_id) { abort(403); }

        $request->validate(['document' => 'required|file|mimes:pdf,doc,docx|max:10240']);

        if ($request->hasFile('document')) {
            $path = $request->file('document')->store('scope_documents');

            // Use the correct `scopeDocuments()` relationship to create a new version
            $project->scopeDocuments()->create([
                'file_path' => $path,
                'user_id'   => Auth::id(), // The student's ID
                'version'   => 'Initial Version', // Default version for student upload
                'changelog' => 'First scope document uploaded by student.',
            ]);

            return redirect()->route('projects.index')->with('success', 'Scope document uploaded successfully!');
        }

        return redirect()->back()->with('error', 'File upload failed.');
    }

    /**
     * Download any version of a scope document.
     */
    public function downloadScopeDocument(ScopeDocument $scope_document)
    {
        $user = Auth::user();
        $project = $scope_document->project;

        // Authorization: Allow download for the project's student, supervisor, or any admin
        if ($user->role !== 'admin' && $user->id !== $project->user_id && $user->id !== $project->supervisor_id) {
            abort(403, 'Unauthorized access');
        }

        if (!Storage::exists($scope_document->file_path)) { abort(404, 'File not found.'); }

        return Storage::download($scope_document->file_path);
    }

    public function destroyScopeDocument(Project $project, ScopeDocument $scope_document)
    {
        // Check if project belongs to current student
        if ($project->user_id !== auth()->id()) {
            return back()->withErrors(['error' => 'You can only delete scope documents from your own projects.']);
        }

        // Check if scope document belongs to this project
        if ($scope_document->project_id !== $project->id) {
            return back()->withErrors(['error' => 'Scope document does not belong to this project. ']);
        }

        // Check if scope document was uploaded by current student
        if ($scope_document->user_id !== auth()->id()) {
            $uploader_name = $scope_document->user->name ?? 'Admin';
            return back()->withErrors(['error' => "Cannot delete scope document uploaded by {$uploader_name}."]);
        }

        // Check if project has defence sessions scheduled
        if ($project->defenceSessions()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete scope document when defence sessions are scheduled.']);
        }

        try {
            // Delete the file from storage
            if (Storage::exists($scope_document->file_path)) {
                Storage::delete($scope_document->file_path);
            }

            // Delete the database record
            $scope_document->delete();

            return redirect()->route('projects.index')
                ->with('success', 'Scope document deleted successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete scope document. Please try again.']);
        }
    }


}