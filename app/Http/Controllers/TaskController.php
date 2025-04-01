<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Obtener todas las tareas
    public function index()
    {
        return Task::with(['project', 'user', 'comments'])->get();
    }

    // Crear una nueva tarea
    public function store(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'in:Pendiente,En Progreso,Completado',
        'priority' => 'in:Alta,Media,Baja',
        'deadline' => 'required|date',
    ]);

    Task::create($request->all());

    return redirect('/dashboard')->with('success', 'Tarea creada con éxito.');
}


    // Ver una tarea específica
    public function show(Task $task)
    {
        return $task->load(['project', 'user', 'comments']);
    }

    // Actualizar una tarea
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'in:Pendiente,En Progreso,Completado',
            'priority' => 'in:Alta,Media,Baja',
            'deadline' => 'nullable|date',
        ]);

        $task->update($request->all());
        return response()->json($task);
    }

    // Eliminar una tarea
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    // Obtener todas las tareas de un proyecto específico
    public function showByProject($projectId)
    {
        $tasks = Task::with(['project', 'user', 'comments'])
                 ->where('project_id', $projectId)
                 ->get();

        return view('admin.detalletask', compact('tasks'));
    }

}
