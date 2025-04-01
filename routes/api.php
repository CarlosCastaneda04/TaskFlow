<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EmpleadoController;

// Ruta base de prueba
Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando correctamente ✅']);
});

// Rutas de recursos
Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('notifications', NotificationController::class);

// Rutas especiales para el modo empleado
Route::prefix('empleado')->group(function () {
    Route::get('tareas/{userId}', [EmpleadoController::class, 'misTareas']);
    Route::patch('tareas/{id}/estado', [EmpleadoController::class, 'actualizarEstado']);
    Route::post('comentarios', [EmpleadoController::class, 'comentar']);
    Route::get('notificaciones/{userId}', [EmpleadoController::class, 'misNotificaciones']);
    Route::post('notifications', [EmpleadoController::class, 'crearNotificacion']);
    Route::patch('notificaciones/{id}/leida', [EmpleadoController::class, 'marcarComoLeida']);
    Route::get('tareas-filtro/{userId}', [EmpleadoController::class, 'filtrarTareas']);
});
