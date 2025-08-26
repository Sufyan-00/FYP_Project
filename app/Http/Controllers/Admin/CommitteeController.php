<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\User;
use App\Models\Evaluator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Support\ConsecutiveSessions;
use Carbon\Carbon;

class CommitteeController extends Controller
{
    public function index()
    {
        $committees = Committee::withCount('members')->latest()->paginate(10);
        return view('admin.committees.index', compact('committees'));
    }

    public function create()
    {
        return view('admin.committees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:190', 'unique:committees,name'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $committee = Committee::create($data + ['created_by_id' => $request->user()->id]);

        $scheduledAt = Carbon::parse($data['scheduled_at']);
        $offenders = [];

        $memberIds = $committee->members()->pluck('users.id')->all();
        foreach ($memberIds as $uid) {
            if (ConsecutiveSessions::wouldExceedLimit($uid, $scheduledAt)) {
                $offenders[] = $uid;
            }
        }

        if (!empty($offenders)) {
            // Optionally resolve names for a friendly message
            $names = \App\Models\User::whereIn('id', $offenders)->pluck('name')->implode(', ');
            return back()->withErrors([
                'committee_id' => "Consecutive sessions limit exceeded for: {$names}. Adjust time or members."
            ])->withInput();
        }

        return redirect()->route('admin.committees.show', $committee)->with('success', 'Committee created.');
    }

    public function show(Committee $committee)
    {
        $committee->load(['members:id,name,email,role']);

        // Only evaluators (supervisors) who are available
        $availableEvaluators = Evaluator::available()
            ->with('user:id,name,email,role')
            ->whereHas('user', fn($q) => $q->where('role', 'supervisor'))
            ->orderByRaw('1') // no specific sort needed
            ->get();
        $approvedProjects = Project::where('status', 'approved')
        ->orderBy('created_at', 'desc')
        ->get(['id','title']);

        return view('admin.committees.show', compact('committee', 'availableEvaluators','approvedProjects'));
    }

    public function edit(Committee $committee)
    {
        return view('admin.committees.create', compact('committee'));
    }

    public function update(Request $request, Committee $committee)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:190', 'unique:committees,name,' . $committee->id],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $committee->update($data);

        return redirect()->route('admin.committees.show', $committee)->with('success', 'Committee updated.');
    }

    public function destroy(Committee $committee)
    {
        $committee->delete();
        return redirect()->route('admin.committees.index')->with('success', 'Committee deleted.');
    }

    // Only evaluator (supervisor) can be added
    public function addMember(Request $request, Committee $committee)
    {
        $data = $request->validate([
            'evaluator_id' => ['required', 'exists:evaluators,id'],
            'role'         => ['required', 'in:chair,member'],
        ]);

        $evaluator = Evaluator::with('user')->findOrFail($data['evaluator_id']);

        if ($evaluator->status !== 'available') {
            return back()->withErrors(['evaluator_id' => 'Selected evaluator is not available.'])->withInput();
        }

        if ($evaluator->user->role !== 'supervisor') {
            return back()->withErrors(['evaluator_id' => 'Only supervisors can be added as evaluators.'])->withInput();
        }

        $committee->members()->syncWithoutDetaching([$evaluator->user_id => ['role' => $data['role']]]);

        $evaluator->markAssigned();

        return back()->with('success', 'Evaluator (supervisor) added to committee.');
    }

    public function removeMember(Committee $committee, \App\Models\User $user)
    {
        // detach relationship
        $committee->members()->detach($user->id);

        // if the user has an evaluator record, mark available
        if ($user->evaluator) {
            $stillOnOtherCommittees = DB::table('committee_members')
                ->where('user_id', $user->id)->exists();
            if (!$stillOnOtherCommittees) {
                $user->evaluator->markAvailable();
            }
        }

        return back()->with('success', 'Member removed from committee.');
    }
}