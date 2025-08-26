<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evaluator;
use App\Models\User;
use Illuminate\Http\Request;

class EvaluatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Evaluator::with(['user:id,name,email,role'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->string('status')))
            ->orderBy('status');

        $evaluators = $query->paginate(15)->withQueryString();

        return view('admin.evaluators.index', compact('evaluators'));
    }

    public function create()
    {
        $eligibleUsers = User::where('role', 'supervisor')
            ->whereDoesntHave('evaluator')
            ->orderBy('name')
            ->get(['id','name','email','role']);

        return view('admin.evaluators.create', compact('eligibleUsers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $user = User::findOrFail($data['user_id']);

        if ($user->role !== 'supervisor') {
            return back()->withErrors(['user_id' => 'Only supervisors can be evaluators.'])->withInput();
        }

        if ($user->evaluator) {
            return back()->withErrors(['user_id' => 'This supervisor is already an evaluator.'])->withInput();
        }

        Evaluator::create([
            'user_id' => $user->id,
            'status'  => 'available',
        ]);

        return redirect()->route('admin.evaluators.index')->with('success', 'Evaluator added successfully.');
    }
}