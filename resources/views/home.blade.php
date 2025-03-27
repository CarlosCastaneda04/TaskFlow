<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>TaskFlow API - Inicio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #121212;
            color: #f0f0f0;
            padding-top: 70px;
            /* Para separar del navbar fijo */
            text-align: center;
        }

        .custom-navbar {
            background-color: #1a1a1a !important;
            border-bottom: 2px solid #00dfc4;
        }

        .navbar-brand,
        .nav-link {
            color: #61dafb !important;
        }

        .navbar-brand:hover,
        .nav-link:hover {
            color: #00dfc4 !important;
        }

        .nav-link.active {
            color: #00dfc4 !important;
            font-weight: bold;
        }

        .note {
            margin-top: 40px;
            font-size: 0.9em;
            color: #bbb;
        }
    </style>
</head>

<body>

    <!-- Navbar Bootstrap -->
    <nav class="navbar navbar-expand-lg fixed-top custom-navbar" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TaskFlow</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/api/projects" target="_blank">Proyectos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/api/tasks" target="_blank">Tareas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/api/comments" target="_blank">Comentarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/api/notifications" target="_blank">Notificaciones</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-outline-info">
                    Login
                </a>
                <a style="margin: auto" href="/api/ping" class="btn btn-outline-info" target="_blank">signup</a>
                <a style="margin: auto" href="/api/ping" class="btn btn-outline-info" target="_blank">📡 Verificar
                    conexión</a>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container">
        <h1 class="mb-4" style="color: #00dfc4">Bienvenido a TaskFlow API</h1>
        <p class="lead">Selecciona un recurso para ver los endpoints disponibles:</p>

        <div class="d-grid gap-3 col-md-6 mx-auto">
            <a href="/api/projects" class="btn btn-dark btn-lg" target="_blank"
                style="border: 1px solid #61dafb; color: #61dafb">
                📁 Proyectos
            </a>
            <a href="/api/tasks" class="btn btn-dark btn-lg" target="_blank"
                style="border: 1px solid #61dafb; color: #61dafb">
                📝 Tareas
            </a>
            <a href="/api/comments" class="btn btn-dark btn-lg" target="_blank"
                style="border: 1px solid #61dafb; color: #61dafb">
                💬 Comentarios
            </a>
            <a href="/api/notifications" class="btn btn-dark btn-lg" target="_blank"
                style="border: 1px solid #61dafb; color: #61dafb">
                🔔 Notificaciones
            </a>
        </div>

        <div class="note mt-5">
            Usa Postman para realizar peticiones POST, PUT o DELETE a estos endpoints.
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
