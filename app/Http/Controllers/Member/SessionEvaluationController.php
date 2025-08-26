<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\DefenceSession;
use App\Models\SessionAssignment;
use Illuminate\Http\Request;

class SessionEvaluationController extends Controller
{
    // List sessions assigned to the logged-in user (evaluator)
    public function index(Request $request)
    {
        $assignments = SessionAssignment::with(['session.project:id,title', 'session.committee:id,name'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('member.sessions.index', compact('assignments'));
    }

    // Show evaluation form
    public function evaluate(SessionAssignment $assignment)
    {
        $this->authorizeView($assignment);

        // Simple default rubric: 3 criteria, 10 marks each
        $rubric = [
            ['key' => 'novelty', 'label' => 'Novelty', 'max' => 10],
            ['key' => 'methodology', 'label' => 'Methodology', 'max' => 10],
            ['key' => 'presentation', 'label' => 'Presentation & Communication', 'max' => 10],
        ];

        return view('member.sessions.evaluate', compact('assignment', 'rubric'));
    }

    // Store/submit evaluation
    public function submit(Request $request, SessionAssignment $assignment)
    {
        $this->authorizeView($assignment);

        $session = $assignment->session()->firstOrFail();
        if (now()->greaterThan($session->scheduled_at->copy()->addDay())) {
            return back()->withErrors([
                'scores.novelty' => 'Submission window has closed (24 hours after the session).',
            ])->withInput();
        }

        $validated = $request->validate([
            'scores.novelty' => ['required', 'integer', 'min:0', 'max:10'],
            'scores.methodology' => ['required', 'integer', 'min:0', 'max:10'],
            'scores.presentation' => ['required', 'integer', 'min:0', 'max:10'],
            'remarks' => ['nullable', 'string', 'max:5000'],
        ]);

        $scores = $validated['scores'];

        $total = ($scores['novelty'] ?? 0) + ($scores['methodology'] ?? 0) + ($scores['presentation'] ?? 0);

        $assignment->update([
            'scores_json'  => $scores,
            'total_score'  => $total,
            'remarks'      => $validated['remarks'] ?? null,
            'submitted_at' => now(),
        ]);

        return redirect()->route('member.sessions.index')->with('success', 'Evaluation submitted.');
    }

    protected function authorizeView(SessionAssignment $assignment): void
    {
        abort_unless($assignment->user_id === auth()->id(), 403);
    }
}