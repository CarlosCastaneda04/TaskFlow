<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comentarios de Tareas</title>
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
        .comment {
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
    <h1>💬 Comentarios</h1>
    <div id="comments-container">Cargando comentarios...</div>

    <script>
        fetch('/api/comments')
            .then(response => {
                if (!response.ok) throw new Error("Error al cargar comentarios");
                return response.json();
            })
            .then(data => {
                const container = document.getElementById('comments-container');
                container.innerHTML = '';
                if (data.length === 0) {
                    container.innerHTML = 'No hay comentarios registrados.';
                } else {
                    data.forEach(comment => {
                        const commentDiv = document.createElement('div');
                        commentDiv.classList.add('comment');
                        commentDiv.innerHTML = `
                            <strong>Comentario:</strong> ${comment.content}<br>
                            <small>📝 Tarea ID: ${comment.task_id} | Usuario ID: ${comment.user_id}</small><br>
                            <small>🕒 Fecha: ${new Date(comment.created_at).toLocaleString()}</small>
                        `;
                        container.appendChild(commentDiv);
                    });
                }
            })
            .catch(error => {
                document.getElementById('comments-container').innerHTML = "Error al cargar comentarios.";
                console.error(error);
            });
    </script>
</body>
</html>
