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



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
