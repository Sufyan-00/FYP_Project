<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\User;
use App\Models\Evaluator;
use Illuminate\Http\Request;

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

        return view('admin.committees.show', compact('committee', 'availableEvaluators'));
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

    public function removeMember(Committee $committee, User $user)
    {
        $committee->members()->detach($user->id);

        $evaluator = $user->evaluator;
        if ($evaluator) {
            $evaluator->markAvailable();
        }

        return back()->with('success', 'Member removed.');
    }
}