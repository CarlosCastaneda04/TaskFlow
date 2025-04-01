<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Tareas Asignadas</title>
    <style>
        body {
            background-color: #121212;
            color: #00dfc4;
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .task {
            border: 1px solid #00dfc4;
            margin: 10px auto;
            padding: 15px;
            width: 80%;
            background-color: #1e1e1e;
            border-radius: 10px;
        }
        .back-button {
            background-color: #00dfc4;
            color: #000;
            border: none;
            padding: 10px 20px;
            margin-bottom: 20px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="window.location.href='/empleado'">← Volver al Panel</button>
    <h1>📋 Tareas Asignadas</h1>
    <div id="tasks-container">Cargando tareas...</div>

    <script>
        fetch('/api/empleado/tareas/1')
            .then(response => {
                if (!response.ok) throw new Error("Error al cargar tareas");
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('tasks-container');
                container.innerHTML = '';
                if (data.length === 0) {
                    container.innerHTML = 'No hay tareas asignadas.';
                } else {
                    data.forEach(task => {
                        const taskDiv = document.createElement('div');
                        taskDiv.classList.add('task');
                        taskDiv.innerHTML = `
                          <strong>${task.Title}</strong><br>
                          Estado: ${task.Status}<br>
                         Prioridad: ${task.Priority}<br>
                          Fecha límite: ${task.Deadline}<br>
                             Proyecto: ${task.project?.Name ?? 'No asignado'}
                                `;
                        container.appendChild(taskDiv);
                    });
                }
            })
            .catch(error => {
                document.getElementById('tasks-container').innerHTML = "Error al cargar tareas.";
                console.error(error);
            });
    </script>
</body>
</html>
