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
        try {
            // Solo para debug: veamos qué llega
            \Log::info("Intentando actualizar tarea", [
                'id_recibido' => $id,
                'status_recibido' => $request->status
            ]);
    
            $request->validate([
                'status' => 'required|in:Pendiente,En Progreso,Completado',
            ]);
    
            $task = Task::findOrFail($id);
            $task->status = $request->status;
            $task->save();
    
            return response()->json([
                'message' => 'Estado actualizado',
                'task' => $task
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar estado',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }
    
// Comentar una tarea
public function comentar(Request $request)
{
    $request->validate([
        'task_id' => 'required|exists:tasks,id',
        'user_id' => 'required|exists:users,id',
        'content' => 'required|string',
    ]);

    // Crear el comentario
    $comment = Comment::create($request->all());

    // Obtener la tarea asociada
    $task = Task::find($request->task_id);

    // Crear notificación para el usuario asignado a la tarea
    Notification::create([
        'UserId' => $task->assigned_to,
        'Message' => "💬 Nuevo comentario en la tarea '{$task->title}'",
        'CreatedAt' => now()
    ]);

    return response()->json(['message' => 'Comentario agregado', 'comment' => $comment]);
}


    // Ver notificaciones personales
    public function misNotificaciones($userId)
    {
        return Notification::where('UserId', $userId)
            ->orderBy('CreatedAt', 'desc')
            ->get();
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

    public function crearNotificacion(Request $request)
{
    $request->validate([
        'UserId' => 'required|exists:users,id',
        'Message' => 'required|string',
        'CreatedAt' => 'nullable|date',
    ]);

    $notificacion = Notification::create([
        'UserId' => $request->UserId,
        'Message' => $request->Message,
        'CreatedAt' => $request->CreatedAt ?? now(),
    ]);

    return response()->json([
        'message' => 'Notificación creada correctamente',
        'notificacion' => $notificacion
    ]);
}

public function marcarComoLeida($id)
{
    $notificacion = Notification::findOrFail($id);
    $notificacion->ReadAt = now(); // guarda la fecha actual
    $notificacion->UpdatedAt = now(); // actualiza también el campo UpdatedAt manualmente
    $notificacion->save();

    return response()->json(['message' => 'Notificación marcada como leída']);
}


}
