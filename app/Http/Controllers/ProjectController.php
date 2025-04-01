<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia; 
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    // Mostrar todos los proyectos
    public function index()
    {
        return Project::all();
    }

    // Crear un nuevo proyecto
    // Crear un nuevo proyecto
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    Project::create([
        'name' => $request->name,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'user_id' => Auth::id(), // ✅ limpio y reconocido por Intelephense
    ]);

    return redirect('/dashboard')->with('success', 'Proyecto creado con éxito.');
}


    // Mostrar un solo proyecto
    public function show(Project $project)
    {
        return $project;
    }

    // Actualizar un proyecto existente
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project->update($request->all());

        return response()->json($project);
    }

    // Eliminar un proyecto
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(null, 204);
    }

 


public function verProyectosYTareas()
{
    $user = Auth::user();

    $projects = Project::with('tasks')->get(); // Todos los proyectos con tareas
    $users = User::where('rol', 'trabajador')->get(); // Para asignar tareas

    return Inertia::render('admin/VerProjectsAndTask', [
        'auth' => ['user' => $user],
        'projects' => $projects,
        'users' => $user->rol === 'admin' ? $users : [],
    ]);
}
}
