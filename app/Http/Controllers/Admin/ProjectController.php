<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\DefenceSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of all projects for the administrator. 
     */
    public function index(Request $request)
    {
        $query = Project::with(['student', 'supervisor']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by supervisor if provided
        if ($request->filled('supervisor')) {
            $query->where('supervisor_id', $request->supervisor);
        }

        // Search by title or student name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('student', function($sq) use ($search) {
                      $sq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $projects = $query->latest()->paginate(15)->withQueryString();

        // For filter dropdowns
        $supervisors = User::where('role', 'supervisor')->orderBy('name')->get();

        return view('admin.projects.index', compact('projects', 'supervisors'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $students = User::where('role', 'student')
            ->whereDoesntHave('projects')
            ->orderBy('name')
            ->get();

        $supervisors = User::where('role', 'supervisor')
            ->orderBy('name')
            ->get();

        return view('admin.projects.create', compact('students', 'supervisors'));
    }

    /**
     * Store a newly created project in storage. 
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'student_id' => ['required', 'exists: users,id'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        // Verify student role
        $student = User::findOrFail($validated['student_id']);
        if ($student->role !== 'student') {
            return back()->withErrors(['student_id' => 'Selected user must be a student.'])->withInput();
        }

        // Verify supervisor role if provided
        if ($validated['supervisor_id']) {
            $supervisor = User:: findOrFail($validated['supervisor_id']);
            if ($supervisor->role !== 'supervisor') {
                return back()->withErrors(['supervisor_id' => 'Selected user must be a supervisor.'])->withInput();
            }
        }

        // Check if student already has a project
        if ($student->projects()->exists()) {
            return back()->withErrors(['student_id' => 'Student already has a project assigned.'])->withInput();
        }

        Project::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'student_id' => $validated['student_id'],
            'supervisor_id' => $validated['supervisor_id'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $project->load(['student', 'supervisor', 'defenceSessions.committee']);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'student_id' => ['required', 'exists:users,id'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        // Verify student role
        $student = User::findOrFail($validated['student_id']);
        if ($student->role !== 'student') {
            return back()->withErrors(['student_id' => 'Selected user must be a student.'])->withInput();
        }

        // Verify supervisor role if provided
        if ($validated['supervisor_id']) {
            $supervisor = User::findOrFail($validated['supervisor_id']);
            if ($supervisor->role !== 'supervisor') {
                return back()->withErrors(['supervisor_id' => 'Selected user must be a supervisor.'])->withInput();
            }
        }

        // Check if student already has another project (excluding current)
        if ($student->projects()->where('id', '!=', $project->id)->exists()) {
            return back()->withErrors(['student_id' => 'Student already has another project assigned.'])->withInput();
        }

        $project->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'student_id' => $validated['student_id'],
            'supervisor_id' => $validated['supervisor_id'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        try {
            DB::beginTransaction();

            // Check if project has defence sessions
            $hasDefenceSessions = DefenceSession::where('project_id', $project->id)->exists();
            
            if ($hasDefenceSessions) {
                DB::rollBack();
                return back()->withErrors([
                    'error' => 'Cannot delete project with defence sessions.  Please remove sessions first.'
                ]);
            }

            $projectTitle = $project->title;
            $project->delete();

            DB::commit();

            return redirect()->route('admin.projects.index')
                ->with('success', "Project \"{$projectTitle}\" deleted successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Failed to delete project.  Please try again.'
            ]);
        }
    }

    /**
     * Update project status.
     */
    public function updateStatus(Request $request, Project $project)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $project->update(['status' => $validated['status']]);

        return redirect()->route('admin.projects.index')
            ->with('success', "Project status updated to {$validated['status']}.");
    }
}