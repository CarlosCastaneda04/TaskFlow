<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    // Ver solo las tareas asignadas al usuario
    public function misTareas($userId)
{
    try {
        $tareas = Task::with('project')
            ->where('assigned_to', $userId)
            ->get();

        return response()->json($tareas);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error al obtener tareas',
            'mensaje' => $e->getMessage()
        ], 500);
    }
}


    // Actualizar el estado de una tarea
    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pendiente,En Progreso,Completado',
        ]);

        $task = Task::findOrFail($id);
        $task->status = $request->status;
        $task->save();

        return response()->json(['message' => 'Estado actualizado', 'task' => $task]);
    }

    // Comentar una tarea
    public function comentar(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $comment = Comment::create($request->all());
        return response()->json(['message' => 'Comentario agregado', 'comment' => $comment]);
    }

    // Ver notificaciones personales
    public function misNotificaciones($userId)
    {
        return Notification::where('user_id', $userId)->get();
    }

    // Filtrar tareas por estado o prioridad
    public function filtrarTareas(Request $request, $userId)
    {
        $query = Task::where('assigned_to', $userId);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        return $query->get();
    }
}
