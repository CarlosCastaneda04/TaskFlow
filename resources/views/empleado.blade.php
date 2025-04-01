<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TaskFlow - Modo Empleado</title>
    <style>
        body {
            background: #121212;
            color: #f0f0f0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 2rem;
        }

        h1 {
            text-align: center;
            color: #00dfc4;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 40px;
            color: #ccc;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .card {
            background-color: #1e1e1e;
            border: 2px solid #00dfc4;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 0 12px #00dfc4;
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #61dafb;
        }

        .card a {
            text-decoration: none;
            color: #f0f0f0;
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #00dfc4;
            border-radius: 6px;
            font-weight: bold;
        }

        .card a:hover {
            background-color: #00bba7;
        }

        .note {
            text-align: center;
            margin-top: 50px;
            font-size: 0.9rem;
            color: #bbb;
        }
    </style>
</head>
<body>

<h1>👨 Panel del Empleado - TaskFlow</h1>
<div class="subtitle">Gestiona tus tareas, comentarios y notificaciones fácilmente</div>

<div class="container">
    <div class="card">
        <div class="card-icon">📁</div>
        <div class="card-title">Tareas Asignadas</div>
        <a href="{{ route('empleado.tareas') }}">Ver Tareas</a>
    </div>
    <div class="card">
        <div class="card-icon">💬</div>
        <div class="card-title">Comentarios</div>
        <a href="{{ route('empleado.comentarios') }}">Ver Comentarios</a>
        </div>
    <div class="card">
        <div class="card-icon">🔔</div>
        <div class="card-title">Notificaciones</div>
        <a href="{{ route('empleado.notificaciones') }}">Ver Notificaciones</a>
    </div>
</div>
</body>
</html>
