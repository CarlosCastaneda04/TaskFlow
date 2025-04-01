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
    const userId = 1; // por ahora estático

    fetch(`/api/empleado/tareas/${userId}`)
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
                        Proyecto: ${task.Project?.Name ?? 'No asignado'}<br><br>

                        <textarea id="comentario-${task.Id}" rows="2" cols="40" placeholder="Escribe un comentario..."></textarea><br>
                        <button onclick="enviarComentario(${task.Id})">Agregar Comentario</button><br><br>

                        <select id="estado-${task.Id}">
                            <option value="Pendiente" ${task.Status === 'Pendiente' ? 'selected' : ''}>Pendiente</option>
                            <option value="En Progreso" ${task.Status === 'En Progreso' ? 'selected' : ''}>En Progreso</option>
                            <option value="Completado" ${task.Status === 'Completado' ? 'selected' : ''}>Completado</option>
                        </select>
                        <button onclick="actualizarEstado(${task.Id})">Actualizar Estado</button>
                    `;
                    container.appendChild(taskDiv);
                });
            }
        })
        .catch(error => {
            document.getElementById('tasks-container').innerHTML = "Error al cargar tareas.";
            console.error(error);
        });

    function enviarComentario(taskId) {
        const contenido = document.getElementById(`comentario-${taskId}`).value;
        if (contenido.trim() === "") {
            alert("El comentario no puede estar vacío");
            return;
        }

        fetch('/api/empleado/comentarios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                task_id: taskId,
                user_id: userId,
                content: contenido
            })
        })
        .then(res => res.json())
        .then(data => {
            alert("✅ Comentario agregado");
            document.getElementById(`comentario-${taskId}`).value = '';
        })
        .catch(err => {
            alert("❌ Error al enviar comentario");
            console.error(err);
        });
    }

    function actualizarEstado(taskId) {
        const nuevoEstado = document.getElementById(`estado-${taskId}`).value;

        fetch(`/api/empleado/tareas/${taskId}/estado`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: nuevoEstado
            })
        })
        .then(res => res.json())
        .then(data => {
            alert("✅ Estado actualizado");
            location.reload(); // refrescar para ver los cambios
        })
        .catch(err => {
            alert("❌ Error al actualizar estado");
            console.error(err);
        });
    }
</script>

</body>
</html>
