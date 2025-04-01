<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Notificaciones</title>
    <style>
        body {
            background-color: #121212;
            color: #00dfc4;
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }

        .notification {
            background-color: #1e1e1e;
            border: 1px solid #00dfc4;
            border-radius: 10px;
            margin: 10px auto;
            padding: 15px;
            width: 80%;
            text-align: left;
            position: relative;
        }

        .unread {
            border-left: 6px solid #ff4081;
        }

        .fecha {
            font-size: 0.9em;
            color: #aaa;
            margin-top: 5px;
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
    <h1>🔔 Mis Notificaciones</h1>
    <div id="notifications-container">Cargando notificaciones...</div>

    <script>
        const userId = 1; // ID fijo temporal

        fetch(`/api/empleado/notificaciones/${userId}`)
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('notifications-container');
                container.innerHTML = '';

                if (data.length === 0) {
                    container.innerHTML = 'No tienes notificaciones aún.';
                    return;
                }

                data.forEach(notif => {
                    const div = document.createElement('div');
                    div.classList.add('notification');
                    if (!notif.ReadAt) div.classList.add('unread');

                    div.innerHTML = `
                        <strong>${notif.Message}</strong>
                        <div class="fecha">🕓 ${new Date(notif.CreatedAt).toLocaleString()}</div>
                    `;

                    container.appendChild(div);
                });
            })
            .catch(err => {
                document.getElementById('notifications-container').innerText = "Error al cargar notificaciones.";
                console.error(err);
            });
    </script>
</body>
</html>
