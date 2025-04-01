<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskflow - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .taskflow-logo {
            width: 80px;
            margin-bottom: 1.5rem;
        }

        .btn-taskflow {
            background: #00dfc4;
            border: none;
            padding: 0.75rem 1.5rem;
        }

        .btn-taskflow:hover {
            background: #00c2ab;
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <div class="main-content">
        <div class="container">
            <div class="login-card mx-auto p-4">
                <div class="text-center mb-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/1067/1067555.png" class="taskflow-logo"
                        alt="Taskflow Logo">
                    <h2 class="h4 mb-3">Iniciar Sesión en Taskflow</h2>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-taskflow w-100 text-white">
                        Ingresar
                    </button>


                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
