<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TaskFlow API - Inicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #f0f0f0;
            padding: 40px;
            text-align: center;
        }
        h1 {
            color: #00dfc4;
        }
        a {
            display: block;
            margin: 15px 0;
            color: #61dafb;
            text-decoration: none;
            font-size: 1.2em;
        }
        a:hover {
            text-decoration: underline;
        }
        .note {
            margin-top: 40px;
            font-size: 0.9em;
            color: #bbb;
        }
    </style>
</head>
<body>
    <h1>Bienvenido a TaskFlow API</h1>
    <p>Haz clic en los siguientes enlaces para acceder a cada recurso:</p>
    <a href="/api/projects" target="_blank">📁 Proyectos</a>
    <a href="/api/tasks" target="_blank">📝 Tareas</a>
    <a href="/api/comments" target="_blank">💬 Comentarios</a>
    <a href="/api/notifications" target="_blank">🔔 Notificaciones</a>
    <a href="/api/ping" target="_blank">📡 Verificar conexión</a>
    <div class="note">
       Usen Postman para hacer peticiones POST, PUT o DELETE a estos endpoints.
    </div>
</body>
</html>
