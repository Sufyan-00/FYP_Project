<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\DefenceSession;
use App\Models\Project;
use App\Models\SessionAssignment;
use App\Models\User;
use Illuminate\Http\Request;

class DefenceSessionController extends Controller
{
    public function index()
    {
        $sessions = DefenceSession::with(['committee:id,name', 'project:id,title', 'scheduledBy:id,name'])
            ->latest('scheduled_at')->paginate(10);

        return view('admin.defence-sessions.index', compact('sessions'));
    }

    public function create()
    {
        $committees = Committee::orderBy('name')->get(['id','name']);
        $projects   = Project::orderBy('created_at', 'desc')->get(['id','title']);
        return view('admin.defence-sessions.create', compact('committees', 'projects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'committee_id'  => ['required', 'exists:committees,id'],
            'project_id'    => ['required', 'exists:projects,id'],
            'scheduled_at'  => ['required', 'date', 'after:now'],
            'venue'         => ['nullable', 'string', 'max:255'],
        ]);

        $session = DefenceSession::create($data + [
            'status' => 'scheduled',
            'scheduled_by_id' => $request->user()->id,
        ]);

        // By default, assign all committee members as evaluators for this session
        $memberIds = Committee::find($data['committee_id'])->members()->pluck('users.id')->all();
        foreach ($memberIds as $uid) {
            SessionAssignment::firstOrCreate([
                'defence_session_id' => $session->id,
                'user_id' => $uid,
            ]);
        }

        return redirect()->route('admin.defence-sessions.index')->with('success', 'Defence session scheduled.');
    }

    // public function show(DefenceSession $defenceSession)
    // {
    //     $defenceSession->load([
    //         'committee.members:id,name,email',
    //         'project:id,title,student_id',
    //         'project.student:id,name,email',
    //         'assignments.evaluator:id,name,email',
    //     ]);

    //     return view('admin.defence-sessions.show', ['session' => $defenceSession]);
    // }

    public function show(DefenceSession $defenceSession)
    {
        $defenceSession->load([
            'committee.members:id,name,email',
            'project.student:id,name,email',
            'assignments.evaluator:id,name,email',
        ]);

        return view('admin.defence-sessions.show', ['session' => $defenceSession]);
    }

    public function assignEvaluators(Request $request, DefenceSession $defenceSession)
    {
        $data = $request->validate([
            'evaluator_ids' => ['array'],
            'evaluator_ids.*' => ['exists:users,id'],
        ]);

        // Only allow evaluators who are members of the session's committee
        $allowed = $defenceSession->committee->members()->pluck('users.id')->all();
        $ids = array_values(array_intersect($data['evaluator_ids'] ?? [], $allowed));

        // Sync assignments
        $defenceSession->assignments()->whereNotIn('user_id', $ids)->delete();
        foreach ($ids as $uid) {
            SessionAssignment::firstOrCreate([
                'defence_session_id' => $defenceSession->id,
                'user_id' => $uid,
            ]);
        }

        return back()->with('success', 'Evaluators updated.');
    }

    public function updateStatus(Request $request, DefenceSession $defenceSession)
    {
        $data = $request->validate([
            'status' => ['required', 'in:scheduled,completed,cancelled'],
        ]);

        $defenceSession->update($data);

        return back()->with('success', 'Session status updated.');
    }

    public function destroy(DefenceSession $defenceSession)
    {
        $defenceSession->delete();
        return redirect()->route('admin.defence-sessions.index')->with('success', 'Session deleted.');
    }
}