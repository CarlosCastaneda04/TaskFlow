<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/empleado', function () {
    return view('empleado');
})->name('empleado');

Route::get('/empleado/tareas', function () {
    return view('mis_tareas');
})->name('empleado.tareas');

Route::get('/empleado/comentarios', function () {
    return view('comentarios');
})->name('empleado.comentarios');

Route::get('/empleado/notificaciones', function () {
    return view('notificaciones');
})->name('empleado.notificaciones');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
