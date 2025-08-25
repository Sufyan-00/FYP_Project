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

    // Data for the student's project (from SDM-2)
    if ($user->role === 'student') {
        $viewData['project'] = Project::where('user_id', $user->id)->first();
    }

    // Data for templates (for SDM-4)
    $viewData['templates'] = DocumentTemplate::all();

    return view('dashboard', $viewData);

})->middleware(['auth', 'verified'])->name('dashboard');
// --- General Authenticated Routes ---
Route::middleware(['auth', 'verified'])->group(function () {
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Supervisor Directory (accessible to all authenticated users)
    Route::get('/supervisors', [SupervisorController::class, 'directory'])->name('supervisors.directory');
    
    // ** UNIFIED DOWNLOAD ROUTE **
    // A single, consistent route for downloading any document, handled by the main ProjectController.
    Route::get('/scope-documents/{scope_document}/download', [ProjectController::class, 'downloadScopeDocument'])->name('scope.document.download');
});


// --- Student Specific Routes ---
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/scope/create', [ProjectController::class, 'createScopeDocument'])->name('projects.scope.create');
    Route::post('/projects/{project}/scope', [ProjectController::class, 'storeScopeDocument'])->name('projects.scope.store');
    // Note: The student download route is now the unified one above.
});


// --- Supervisor Specific Routes ---
Route::middleware(['auth', 'verified', 'role:supervisor'])->group(function () {
    Route::get('/supervisor/projects', [SupervisorController::class, 'index'])->name('supervisor.projects');
    Route::patch('/supervisor/projects/{project}/approve', [SupervisorController::class, 'approve'])->name('supervisor.projects.approve');
    Route::patch('/supervisor/projects/{project}/reject', [SupervisorController::class, 'reject'])->name('supervisor.projects.reject');

    Route::patch('/supervisor/projects/{project}/complete', [SupervisorController::class, 'complete'])->name('supervisor.projects.complete');
    Route::get('/supervisor/history', [SupervisorController::class, 'history'])->name('supervisor.history');

    Route::get('/supervisor/profile', [SupervisorController::class, 'editProfile'])->name('supervisor.profile.edit');
    Route::patch('/supervisor/profile', [SupervisorController::class, 'updateProfile'])->name('supervisor.profile.update');
    // Note: The supervisor download route is now the unified one above.
});


// --- Administrator Panel Routes ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('/users/upload', [UserController::class, 'showUploadForm'])->name('users.upload.form');
    Route::post('/users/upload', [UserController::class, 'processUpload'])->name('users.upload.process');
    Route::get('/users/upload/template', [UserController::class, 'downloadTemplate'])->name('users.template.download');
    
    // ** CORRECTED ADMIN PROJECT ROUTE **
    // This now correctly points to the AdminProjectController.
    Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
    
    // Admin Scope Document Version Management
    Route::get('/projects/{project}/scope-documents', [AdminScopeDocumentController::class, 'index'])->name('projects.scope-documents.index');
    Route::get('/projects/{project}/scope-documents/create', [AdminScopeDocumentController::class, 'create'])->name('projects.scope-documents.create');
    Route::post('/projects/{project}/scope-documents', [AdminScopeDocumentController::class, 'store'])->name('projects.scope-documents.store');
    

    Route::resource('/admin/templates', DocumentTemplateController::class)->except(['show', 'edit', 'update'])->names('admin.templates');

    // Note: The admin download route uses the unified one defined outside this group.
    // The AdminScopeDocumentController's download link should point to `scope.document.download`.
});

require __DIR__.'/auth.php';