<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SupervisorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ScopeDocumentController as AdminScopeDocumentController;
use App\Http\Controllers\Admin\DocumentTemplateController;
use App\Models\DocumentTemplate;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController as MainDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;

// --- Publicly Accessible Routes ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [MainDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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

    Route::get('/templates/{template}/view', [DocumentTemplateController::class, 'view'])
        ->name('templates.view');
});

// --- Student Specific Routes ---
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/scope/create', [ProjectController::class, 'createScopeDocument'])->name('projects.scope.create');
    Route::post('/projects/{project}/scope', [ProjectController::class, 'storeScopeDocument'])->name('projects.scope.store');
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
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
    Route::get('/supervisor/dashboard', [SupervisorDashboardController::class, 'index'])->name('supervisor.dashboard');
});

// --- Admin Routes ---
Route::prefix('admin')->middleware(['auth', 'verified', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update']);
    Route::patch('/users/{user}/status', [AdminUserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::get('/users/upload', [AdminUserController::class, 'showUploadForm'])->name('users.upload.form');
    Route::post('/users/upload', [AdminUserController::class, 'processUpload'])->name('users.upload.process');
    Route::get('/users/upload/template', [AdminUserController::class, 'downloadTemplate'])->name('users.template.download');

    Route::get('projects', [AdminProjectController::class, 'index'])->name('projects.index');

    // SDM-4: Authoritative Templates UI (explicit routes; no resource to avoid duplicates)
    Route::get('/templates', [DocumentTemplateController::class, 'index'])->name('templates.index');
    Route::post('/templates', [DocumentTemplateController::class, 'store'])->name('templates.store');
    Route::delete('/templates/{template}', [DocumentTemplateController::class, 'destroy'])->name('templates.destroy');

    // Recycle Bin (soft-deletes)
    Route::get('/templates/trash', [DocumentTemplateController::class, 'trash'])->name('templates.trash');
    Route::patch('/templates/{template}/restore', [DocumentTemplateController::class, 'restore'])->name('templates.restore');
    Route::delete('/templates/{template}/force', [DocumentTemplateController::class, 'forceDelete'])->name('templates.force-delete');
    Route::get('/templates/cleartrash', [DocumentTemplateController::class, 'clearTrash'])->name('templates.trash.clear');
    Route::delete('/templates/cleartrash', [DocumentTemplateController::class, 'clearTrash'])->name('templates.trash.clear');

    // Scope Document versioning mgmt (existing)
    Route::get('/projects/{project}/scope-documents', [AdminScopeDocumentController::class, 'index'])->name('projects.scope-documents.index');
    Route::get('/projects/{project}/scope-documents/create', [AdminScopeDocumentController::class, 'create'])->name('projects.scope-documents.create');
    Route::post('/projects/{project}/scope-documents', [AdminScopeDocumentController::class, 'store'])->name('projects.scope-documents.store');
});

require __DIR__.'/auth.php';