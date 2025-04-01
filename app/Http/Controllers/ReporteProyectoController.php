<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class ReporteProyectoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = Project::with('tasks')->where('user_id', $user->id)->get();

        return Inertia::render('Reportes', [
            'user' => $user,
            'projects' => $projects,
        ]);
    }

    public function exportPdf()
    {
        $user = Auth::user();
        $projects = Project::with('tasks')->where('user_id', $user->id)->get();

        return Pdf::loadView('reporte', compact('user', 'projects'))

            ->download('reporte-proyectos.pdf');
    }


    /*
    public function exportExcel(): BinaryFileResponse
    {
        $user = Auth::user();
        $projects = Project::with('tasks')->where('user_id', $user->id)->get();

        $data = collect($projects)->map(function ($project) {
            return [
                'Proyecto' => $project->name,
                'Tareas' => count($project->tasks),
                'Pendientes' => $project->tasks->where('status', 'Pendiente')->count(),
                'En Progreso' => $project->tasks->where('status', 'En Progreso')->count(),
                'Completadas' => $project->tasks->where('status', 'Completado')->count(),
            ];
        });

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function collection() { return $this->data; }
            public function headings(): array {
                return ['Proyecto', 'Tareas', 'Pendientes', 'En Progreso', 'Completadas'];
            }
        }, 'reporte-proyectos.xlsx');
    }

    */
}
