<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\DatabankController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\WopiController;
use App\Http\Controllers\GoogleDocsController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $projects = auth()->user()->isAdmin()
            ? \App\Models\Project::with(['owner', 'marketing'])->latest()->paginate(10)
            : \App\Models\Project::viewableBy(auth()->user())->latest()->paginate(10);
            
        return view('dashboard', compact('projects'));
    })->name('dashboard');

    // Databank Routes
    Route::prefix('databank')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('databank');
        Route::get('/upload', [DocumentController::class, 'showUploadForm'])->name('databank.upload');
        Route::post('/upload', [DocumentController::class, 'upload'])->name('databank.upload.post');
        Route::get('/file/{filename}', [DocumentController::class, 'getFile'])->name('databank.getFile');
        Route::get('/{document}/edit', [DocumentController::class, 'edit'])->name('databank.edit');
        Route::put('/{document}', [DocumentController::class, 'update'])->name('databank.update');
        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('databank.destroy');
        Route::get('/{document}/history', [DocumentController::class, 'history'])->name('databank.history');
        
        // Access management routes
        Route::get('/access-requests', [DocumentController::class, 'showAccessRequests'])->name('databank.access-requests');
        Route::post('/{document}/request-access', [DocumentController::class, 'requestAccess'])->name('databank.request-access');
        Route::post('/access-requests/{request}/grant', [DocumentController::class, 'grantAccess'])->name('databank.grant-access');
        Route::get('/access-requests/{request}/reject', [DocumentController::class, 'rejectAccess'])->name('databank.reject-access');
    });

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Project Routes
    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/create', [ProjectController::class, 'create'])->name('project.create');
        Route::get('/calendar', [ProjectController::class, 'calendar'])->name('project.calendar');
        Route::post('/', [ProjectController::class, 'store'])->name('project.store');
        Route::get('/{project}', [ProjectController::class, 'show'])->name('project.show');
        Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');
    });

    // Schedule Routes
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('schedules.index');
        Route::get('/create', [ScheduleController::class, 'create'])->name('schedules.create');
        Route::post('/', [ScheduleController::class, 'store'])->name('schedules.store');
        Route::get('/{schedule}', [ScheduleController::class, 'show'])->name('schedules.show');
        Route::get('/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit');
        Route::put('/{schedule}', [ScheduleController::class, 'update'])->name('schedules.update');
        Route::delete('/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    });

    // Insights Routes
    Route::prefix('insights')->group(function () {
        Route::get('/', [InsightController::class, 'index'])->name('insights.index');
        Route::get('/fetch', [InsightController::class, 'fetchFromApis'])
            ->name('insights.fetch')
            ->middleware('can:fetch-data');

        // Export Routes
        Route::get('/export', [ExportController::class, 'showExportForm'])->name('insights.export.form');
        Route::get('/export/data', [ExportController::class, 'export'])->name('insights.export');
    });

    // Audit Log Routes
    Route::prefix('audit-logs')->group(function () {
        Route::get('/', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/project/{project}/history', [AuditLogController::class, 'projectHistory'])->name('projects.history');
        Route::get('/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    });

    // WOPI routes for Collabora integration
    Route::get('/wopi/files/{filename}', [WopiController::class, 'show'])->name('wopi.show');

    // Google Docs Routes
    Route::prefix('google')->group(function () {
        Route::get('auth', [GoogleDocsController::class, 'redirect'])->name('google.docs.redirect');
        Route::get('callback', [GoogleDocsController::class, 'callback'])->name('google.docs.callback');
        Route::post('docs', [GoogleDocsController::class, 'createDocument'])->name('google.docs.create');
        Route::get('docs/{documentId}', [GoogleDocsController::class, 'getDocument'])->name('google.docs.get');
        Route::put('docs/{documentId}', [GoogleDocsController::class, 'updateDocument'])->name('google.docs.update');
    });
});

require __DIR__.'/auth.php';
