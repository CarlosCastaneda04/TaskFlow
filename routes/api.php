<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;

// Ruta base de prueba
Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando correctamente ✅']);
});

// Rutas de recursos
Route::apiResource('projects', ProjectController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('notifications', NotificationController::class);
