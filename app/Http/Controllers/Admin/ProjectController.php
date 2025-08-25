<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of all projects for the administrator.
     */
    public function index()
    {
        // Fetch all projects and eager load relationships to avoid N+1 problems
        $projects = Project::with(['student', 'supervisor'])->latest()->get();

        return view('admin.projects.index', ['projects' => $projects]);
    }
}