<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asociacion de Orquideologia Altaverapacense</title>

    <!-- Enlaces a Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">

    <!-- Enlace a FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Estilos CSS personalizados -->
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            top: 0;
            left: 0;
            padding: 20px;
        }

        .sidebar h2 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar ul {
            padding: 0;
            list-style-type: none;
        }

        .sidebar ul li {
            padding: 15px 10px;
            text-align: left;
            font-size: 18px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar ul li a:hover {
            background-color: #495057;
            border-radius: 5px;
        }

        .main-content {
            margin-left: 260px;
            padding: 20px;
            flex: 1;
        }

        .card {
            margin-bottom: 20px;
        }

        .btn-whatsapp {
            background-color: #25d366;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-calendar"></i> Horario</a></li>
            <li><a href="#"><i class="fas fa-user"></i> Perfiles de Usuarios</a></li>
            <li><a href="#" onclick="enviarMensajeWhatsApp();" class="btn-whatsapp"><i class="fab fa-whatsapp"></i> Enviar Mensaje</a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <div class="container">
            <h1>Bienvenido al Dashboard</h1>
            <p>Este es un ejemplo básico de un dashboard con sidebar utilizando Bootstrap.</p>

            <!-- Tarjeta de ejemplo -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Desembolsos</h5>
                            <p class="card-text">Control de los desembolsos recientes.</p>
                            <a href="#" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Usuarios</h5>
                            <p class="card-text">Gestiona los perfiles de los usuarios.</p>
                            <a href="#" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Estadísticas</h5>
                            <p class="card-text">Revisa el rendimiento del sistema.</p>
                            <a href="#" class="btn btn-primary">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enlaces a Bootstrap JS, jQuery y tus scripts personalizados -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        // Función para enviar mensajes de WhatsApp al grupo
        function enviarMensajeWhatsApp() {
            let mensaje = "Mensaje de prueba enviado desde el Dashboard.";
            let urlWhatsapp = "https://wa.me/?text=" + encodeURIComponent(mensaje);
            window.open(urlWhatsapp, '_blank');
        }
    </script>
</body>

</html>
