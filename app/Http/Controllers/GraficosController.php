<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GraficosController extends Controller
{
    public function index()
    {
        $tareas = Task::with('project', 'user')->get();

        // Tareas totales por empleado
        $tareasPorEmpleado = $tareas->groupBy('user.name')->map(function ($group) {
            return [
                'user' => $group->first()->user?->name ?? 'No asignado',
                'count' => $group->count(),
            ];
        })->values();

        // Tareas por proyecto y por empleado
        $tareasPorProyectoYEmpleado = $tareas->groupBy('project_id')->map(function ($group) {
            return $group->groupBy('user.name')->map(function ($tareas) {
                return $tareas->count();
            });
        });

        return Inertia::render('admin/graficas', [
            'tareasPorEmpleado' => $tareasPorEmpleado,
            'tareasPorProyectoYEmpleado' => $tareasPorProyectoYEmpleado,
        ]);
    }
}
