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

        .notification button {
    background-color: #00dfc4;
    color: #000;
    border: none;
    padding: 8px 18px;
    margin-top: 10px;
    border-radius: 20px;
    font-weight: bold;
    cursor: pointer;
    font-size: 0.95em;
    box-shadow: 0 0 8px #00dfc4;
    transition: all 0.3s ease;
}

.notification button:hover {
    background-color: #00bfa6;
    box-shadow: 0 0 12px #00dfc4, 0 0 20px #00dfc4;
    transform: scale(1.03);
}

.notification button:active {
    transform: scale(0.97);
}


    </style>
</head>
<body>
    <button class="back-button" onclick="window.location.href='/empleado'">← Volver al Panel</button>
    <h1>🔔 Mis Notificaciones</h1>
    <div id="notifications-container">Cargando notificaciones...</div>

    <script>
    const userId = 1; // Cambiar dinámicamente si tienes login real

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
                const notifId = notif.id || notif.Id || notif.ID; // Asegurar ID

                const div = document.createElement('div');
                div.classList.add('notification');
                if (!notif.ReadAt) div.classList.add('unread');

                div.innerHTML = `
                    <strong>${notif.Message}</strong>
                    <div class="fecha">🕓 ${new Date(notif.CreatedAt).toLocaleString()}</div>
                    ${
                        !notif.ReadAt
                        ? `<button class="btn-leer" onclick="marcarLeida(${notifId}, this)">✅ Marcar como leída</button>`
                        : `<div class="leida-ok">✔️ Ya leída</div>`
                    }
                `;

                container.appendChild(div);
            });
        })
        .catch(err => {
            document.getElementById('notifications-container').innerText = "Error al cargar notificaciones.";
            console.error(err);
        });

    function marcarLeida(notificacionId, button) {
        if (!notificacionId) {
            alert("❌ ID de notificación no válido.");
            return;
        }

        fetch(`/api/empleado/notificaciones/${notificacionId}/leida`, {
            method: 'PATCH'
        })
        .then(res => {
            if (!res.ok) throw new Error("Error al marcar");
            return res.json();
        })
        .then(data => {
            console.log("✅ Notificación marcada como leída");

            const div = button.parentElement;
            div.classList.remove('unread');
            button.remove();

            const confirmacion = document.createElement('div');
            confirmacion.className = 'leida-ok';
            confirmacion.innerText = '✔️ Ya leída';
            div.appendChild(confirmacion);
        })
        .catch(err => {
            alert("❌ Error al marcar como leída");
            console.error(err);
        });
    }
</script>


</body>
</html>
