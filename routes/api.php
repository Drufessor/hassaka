<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeleteController;

// ... existing code ...

// Delete route for projects
Route::delete('/projects/{id}', [DeleteController::class, 'destroy'])->name('projects.destroy');

// ... existing code ... 