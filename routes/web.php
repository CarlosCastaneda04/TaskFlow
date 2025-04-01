<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\ProjectController;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use App\Models\Task;

use App\Http\Controllers\ReporteProyectoController;





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


Route::get('/proyectos/{project}/editar', function (Project $project) {
    if ($project->user_id !== Auth::id()) {
        abort(403);
    }

    return Inertia::render('EditarProyecto', [
        'project' => $project
    ]);
})->middleware('auth');


Route::put('/proyectos/{project}', function (Request $request, Project $project) {
    if ($project->user_id !== Auth::id()) {
        abort(403);
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'fecha_cierre' => 'nullable|date',
    ]);

    $project->update($validated);

    return redirect()->route('dashboard')->with('success', 'Proyecto actualizado');
})->middleware('auth');




Route::delete('/proyectos/{project}', function (Project $project) {
    if ($project->user_id !== Auth::id()) {
        abort(403);
    }

    $project->delete();

    return redirect()->route('dashboard')->with('success', 'Proyecto eliminado correctamente');
})->middleware('auth');



Route::delete('/tareas/{task}', function (Task $task) {
    $task->delete();
    return response()->json(['message' => 'Tarea eliminada']);
})->middleware('auth');


Route::get('/tareas/{task}/editar', function (Task $task) {
    return Inertia::render('EditarTarea', [
        'task' => $task
    ]);
})->middleware('auth');

Route::put('/tareas/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->middleware('auth');


Route::get('/graficas', function () {
    $projects = \App\Models\Project::with('tasks')->where('user_id', Auth::id())->get();
    return Inertia::render('Graficas', ['projects' => $projects]);
})->middleware('auth');



Route::get('/reportes', [ReporteProyectoController::class, 'index'])
    ->middleware('auth')
    ->name('reportes.index');

    Route::get('/reportes/pdf', [ReporteProyectoController::class, 'exportPdf'])
    ->middleware('auth')
    ->name('reportes.pdf');

Route::get('/reportes/excel', [ReporteProyectoController::class, 'exportExcel'])
    ->middleware('auth')
    ->name('reportes.excel');

    Route::get('/reportes', [ReporteProyectoController::class, 'index'])->middleware('auth')->name('reportes.index');
    Route::get('/reportes/pdf', [ReporteProyectoController::class, 'exportPdf'])->middleware('auth')->name('reportes.pdf');
    Route::get('/reportes/excel', [ReporteProyectoController::class, 'exportExcel'])->middleware('auth')->name('reportes.excel');



/*Route::middleware(['auth', 'verified'])->group(function () */

Route::middleware(['auth'])->group(function (){
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
