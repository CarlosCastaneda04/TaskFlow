<h2>Lista de Proyectos</h2>
<ul>
@foreach ($projects as $project)
    <li>
        <a href="{{ route('admin.projects.tasks', $project->id) }}">
            {{ $project->name }}
        </a>
    </li>
@endforeach
</ul>
