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
    <link rel="stylesheet" href="../../Recursos/css/dashboard.css">

    <!-- Estilos CSS personalizados -->
    <style>
        .card-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .card-icon.orquidea {
            color: #28a745;
        }

        .card-icon.perfiles {
            color: #17a2b8;
        }

        .card-icon.identificacion {
            color: #ffc107;
        }

        .card-icon.juzgamiento {
            color: #6c757d;
        }

        .card-icon.reporte {
            color: #007bff;
        }

        .card-icon.revision {
            color: #dc3545;
        }

        .card {
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .main-content.collapsed {
            margin-left: 60px;
        }

        .main-content {
            margin-left: 250px;
            transition: margin-left 0.3s;
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
            <li><a href="#"><i class="fas fa-plus-circle"></i> <span>Registro de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-user"></i> <span>Perfiles de Usuario</span></a></li>
            <li><a href="Identificaion.php"><i class="fas fa-leaf"></i> <span>Identificación de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-gavel"></i> <span>Juzgamiento</span></a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> <span>Reporte de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-search"></i> <span>Revisión de Estado de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content" id="main-content">
        <h1>Bienvenido al Dashboard</h1>
        <p>Este es un ejemplo básico de un dashboard con sidebar utilizando Bootstrap.</p>

        <!-- Tarjetas que representan los módulos -->
        <div class="row">
            <!-- Registro de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-plus-circle card-icon orquidea"></i>
                        <h5 class="card-title">Registro de Orquídeas</h5>
                        <p class="card-text">Gestiona el registro de nuevas orquídeas.</p>
                        <a href="Neva_orquidea.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <!-- Perfiles de Usuario -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-user card-icon perfiles"></i>
                        <h5 class="card-title">Perfiles de Usuario</h5>
                        <p class="card-text">Gestiona los perfiles de los usuarios.</p>
                        <a href="" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <!-- Identificación de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-leaf card-icon identificacion"></i>
                        <h5 class="card-title">Identificación de Orquídeas</h5>
                        <p class="card-text">Sistema para identificar orquídeas.</p>
                        <a href="Identificaion.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <!-- Juzgamiento -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-gavel card-icon juzgamiento"></i>
                        <h5 class="card-title">Juzgamiento</h5>
                        <p class="card-text">Sistema de juzgamiento de orquídeas.</p>
                        <a href="#" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <!-- Reporte de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-chart-bar card-icon reporte"></i>
                        <h5 class="card-title">Reporte de Orquídeas</h5>
                        <p class="card-text">Genera reportes sobre las orquídeas.</p>
                        <a href="#" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <!-- Revisión de Estado de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-search card-icon revision"></i>
                        <h5 class="card-title"> Estado de Orquídeas</h5>
                        <p class="card-text">Revisa el estado actual de las orquídeas.</p>
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
