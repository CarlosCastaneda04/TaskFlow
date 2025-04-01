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

                </ul>
                <a href="{{ route('login') }}" class="btn btn-outline-info">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-info">Signup</a>

            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="container">
        <h1 class="mb-4" style="color: #00dfc4">Bienvenido a TaskFlow </h1>
        <p class="lead">Inicia sesion para acceder a las funcionalidades</p>

        <div class="d-grid gap-3 col-md-6 mx-auto">

        </div>


    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
