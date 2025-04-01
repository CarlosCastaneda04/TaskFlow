<h2>Tareas del Proyecto</h2>
<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Estado</th>
            <th>Prioridad</th>
            <th>Asignado a</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->status }}</td>
            <td>{{ $task->priority }}</td>
            <td>{{ $task->user->name ?? 'No asignado' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
