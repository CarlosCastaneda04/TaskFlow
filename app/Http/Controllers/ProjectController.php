<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Mostrar todos los proyectos
    public function index()
    {
        return Project::all();
    }

    // Crear un nuevo proyecto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $project = Project::create($request->all());

        return response()->json($project, 201);
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
}
