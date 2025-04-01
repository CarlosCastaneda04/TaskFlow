<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::prefix('/')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/projects/{project}', [TaskController::class, 'showByProject'])->name('admin.projects.tasks');
});


Route::get('/', function () {
    return view('home');
})->name('home');

// routes/web.php
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Agrega esto ANTES del grupo de middleware 'auth'
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

/*Route::middleware(['auth', 'verified'])->group(function () */

Route::middleware(['auth'])->group(function (){
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
