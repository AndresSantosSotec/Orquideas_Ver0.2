<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['user_id'])) {
    // Redirigir al login si no hay sesión
    header("Location: login.php");
    exit;
}
?>
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
    <link rel="stylesheet" href="../../Recursos/css/icons.css">
</head>

<body>
    <!-- Sidebar -->
    <?php include '../Vistas/modales/side.php'; ?>

    <!-- Contenido principal -->
    <div class="main-content" id="main-content">

        <h1>Bienvenido al Dashboard</h1>
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
                        <h5 class="card-title">Perfiles de Participantes</h5>
                        <p class="card-text">Gestiona los perfiles de los usuarios.</p>
                        <a href="Registro_usuario.php" class="btn btn-primary">Ver más</a>
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
                        <a href="Identificar.php" class="btn btn-primary">Ver más</a>
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
                        <a href="Reportes.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <!-- Revisión de Estado de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-search card-icon revision"></i>
                        <h5 class="card-title">Estado de Orquídeas</h5>
                        <p class="card-text">Revisa el estado actual de las orquídeas.</p>
                        <a href="#" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>

            <!-- Premios -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <i class="fas fa-trophy card-icon premios"></i>
                        <h5 class="card-title">Premios</h5>
                        <p class="card-text">Gestiona los premios de las orquídeas.</p>
                        <a href="Premios.php" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
        </div> <!-- Cierre del div.row -->
    </div> <!-- Cierre del div.main-content -->

    <!-- Enlaces a Bootstrap JS, jQuery y tus scripts personalizados -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="../../Recursos/js/side.js"></script>
</body>

</html>
