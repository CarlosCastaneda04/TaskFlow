<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Proyectos</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f3f3f3; }
    </style>
</head>
<body>
    <h2>Reporte de {{ $user->name }}</h2>
    <p>Total de proyectos: {{ count($projects) }}</p>
    <p>Total de tareas: {{ $projects->sum(fn($p) => count($p->tasks)) }}</p>

    <table>
        <thead>
            <tr>
                <th>Proyecto</th>
                <th>Total Tareas</th>
                <th>Pendientes</th>
                <th>En Progreso</th>
                <th>Completadas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ count($project->tasks) }}</td>
                    <td>{{ $project->tasks->where('status', 'Pendiente')->count() }}</td>
                    <td>{{ $project->tasks->where('status', 'En Progreso')->count() }}</td>
                    <td>{{ $project->tasks->where('status', 'Completado')->count() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
