<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DocumentTemplate;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $project = Project::where('user_id', $user->id)->first();
        $templates = DocumentTemplate::all();

        return view('student.dashboard', compact('project', 'templates'));
    }
}