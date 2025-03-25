<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Obtener todas las notificaciones
    public function index()
    {
        return Notification::with('user')->get();
    }

    // Crear una nueva notificación
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'read_at' => 'nullable|date',
        ]);

        $notification = Notification::create($request->all());
        return response()->json($notification, 201);
    }

    // Ver una notificación específica
    public function show(Notification $notification)
    {
        return $notification->load('user');
    }

    // Actualizar (por ejemplo marcar como leída)
    public function update(Request $request, Notification $notification)
    {
        $request->validate([
            'read_at' => 'nullable|date',
        ]);

        $notification->update($request->only('read_at'));
        return response()->json($notification);
    }

    // Eliminar una notificación
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(null, 204);
    }
}
