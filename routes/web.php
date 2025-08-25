<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ScopeDocumentController as AdminScopeDocumentController;
use App\Http\Controllers\Admin\DocumentTemplateController;
use App\Models\DocumentTemplate;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

// --- Publicly Accessible Routes ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $viewData = [];

    if ($user->role === 'student') {
        $viewData['project'] = Project::where('user_id', $user->id)->first();
    }

    // SDM-4: expose templates on dashboard
    $viewData['templates'] = DocumentTemplate::all();

    return view('dashboard', $viewData);
})->middleware(['auth', 'verified'])->name('dashboard');

// --- General Authenticated Routes ---
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Supervisor Directory
    Route::get('/supervisors', [SupervisorController::class, 'directory'])->name('supervisors.directory');

    // Scope documents download (existing)
    Route::get('/scope-documents/{scope_document}/download', [ProjectController::class, 'downloadScopeDocument'])
        ->name('scope.document.download');

    // SDM-4: Document templates download for all authenticated users
    Route::get('/templates/{template}/download', [DocumentTemplateController::class, 'download'])
        ->name('templates.download');
});

// --- Student Specific Routes ---
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/scope/create', [ProjectController::class, 'createScopeDocument'])->name('projects.scope.create');
    Route::post('/projects/{project}/scope', [ProjectController::class, 'storeScopeDocument'])->name('projects.scope.store');
});

// --- Supervisor Specific Routes ---
Route::middleware(['auth', 'verified', 'role:supervisor'])->group(function () {
    Route::get('/supervisor/projects', [SupervisorController::class, 'index'])->name('supervisor.projects');
    Route::patch('/supervisor/projects/{project}/approve', [SupervisorController::class, 'approve'])->name('supervisor.projects.approve');
    Route::patch('/supervisor/projects/{project}/reject', [SupervisorController::class, 'reject'])->name('supervisor.projects.reject');
    Route::patch('/supervisor/projects/{project}/complete', [SupervisorController::class, 'complete'])->name('supervisor.projects.complete');
    Route::get('/supervisor/history', [SupervisorController::class, 'history'])->name('supervisor.history');
    Route::get('/supervisor/profile', [SupervisorController::class, 'editProfile'])->name('supervisor.profile.edit');
});

// --- Admin Routes ---
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update']);
    Route::get('users/toggle-status/{user}', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    Route::get('projects', [AdminProjectController::class, 'index'])->name('projects.index');

    // SDM-4: Correct resource path (avoid double /admin)
    Route::resource('templates', DocumentTemplateController::class)
        ->except(['show', 'edit', 'update'])
        ->names('templates');

    // Scope Document versioning mgmt (existing)
    Route::get('scope-documents', [AdminScopeDocumentController::class, 'index'])->name('scope-documents.index');
    Route::get('scope-documents/create', [AdminScopeDocumentController::class, 'create'])->name('scope-documents.create');
    Route::post('scope-documents', [AdminScopeDocumentController::class, 'store'])->name('scope-documents.store');
});

require __DIR__.'/auth.php';