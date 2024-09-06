<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

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
            font-family: 'Roboto', sans-serif;
        }

        .sidebar {
            background-color: #343a40;
            color: white;
            height: 100vh;
            position: fixed;
            width: 220px;
            top: 0;
            left: 0;
            padding: 20px;
            transition: width 0.3s;
            box-shadow: 2px 0px 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar h2 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 30px;
            transition: opacity 0.3s;
        }

        .sidebar.collapsed h2 {
            opacity: 0;
        }

        .sidebar ul {
            padding: 0;
            list-style-type: none;
        }

        .sidebar ul li {
            padding: 15px 10px;
            text-align: left;
            font-size: 16px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .sidebar ul li a:hover {
            background-color: #495057;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar.collapsed ul li a i {
            margin-right: 0;
        }

        .sidebar.collapsed ul li a span {
            display: none;
        }

        .main-content {
            margin-left: 240px;
            padding: 40px;
            flex: 1;
            transition: margin-left 0.3s;
        }

        .main-content.collapsed {
            margin-left: 100px;
        }

        .toggle-button {
            background-color: #495057;
            color: white;
            border: none;
            padding: 8px;
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 20px;
            border-radius: 5px;
            display: inline-block;
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

        .card {
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h5 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 1rem;
            color: #6c757d;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            font-size: 0.9rem;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <button class="toggle-button" id="toggle-button">☰</button>
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
            <li><a href="#"><i class="fas fa-calendar"></i> <span>Horario</span></a></li>
            <li><a href="#"><i class="fas fa-user"></i> <span>Perfiles de Usuarios</span></a></li>
            <li><a href="#" onclick="enviarMensajeWhatsApp();" class="btn-whatsapp"><i class="fab fa-whatsapp"></i> <span>Enviar Mensaje</span></a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content" id="main-content">
        <h1>Bienvenido al Dashboard</h1>
        <p>Este es un ejemplo básico de un dashboard con sidebar utilizando Bootstrap.</p>

        <!-- Tarjetas con mejor estética -->
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

        // Funcionalidad de colapsar y expandir el sidebar
        document.getElementById('toggle-button').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });
    </script>
</body>

</html>
