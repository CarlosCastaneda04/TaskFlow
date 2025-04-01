<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProjectController;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\TaskController;



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


Route::get('/tasks/create', function () {
    $projects = Project::where('user_id', Auth::id())->get(['id', 'name']);

    return Inertia::render('CreateTask', [
        'projects' => $projects
    ]);
})->middleware('auth');


Route::post('/tasks', [TaskController::class, 'store'])->middleware('auth');


// Por esto:
Route::middleware('auth')->get('/projects/create', function () {
    return inertia('CreateProject'); // Nombre correcto del componente
});


Route::middleware('auth')->post('/api/projects', [ProjectController::class, 'store']);



Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        $user = Auth::user();
        $projects = Project::with('tasks')->where('user_id', $user->id)->get();

        return Inertia::render('Dashboard', [
            'projects' => $projects
        ]);
    })->name('dashboard');
});


Route::get('/ver-proyectos-tareas', function () {
    $projects = \App\Models\Project::with('tasks')
        ->where('user_id', Auth::id())
        ->get();

    return Inertia::render('VerProjectsAndTask', [
        'projects' => $projects
    ]);
})->middleware('auth');


/*Route::middleware(['auth', 'verified'])->group(function () */

Route::middleware(['auth'])->group(function (){
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
