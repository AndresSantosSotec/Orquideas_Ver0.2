<?php
 
// Asegúrate de tener la conexión establecida o autenticación activa

// Obtener el tipo de usuario desde la sesión
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
?>

<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>
    <ul>
        <!-- Opciones visibles para todos los usuarios -->
        <li><a href="Dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        <li><a href="neva_orquidea.php"><i class="fas fa-plus-circle"></i> <span>Registro de Orquídeas</span></a></li>
        <li><a href="Registro_usuario.php"><i class="fas fa-user"></i> <span>Perfiles de Usuario</span></a></li>
        <li><a href="estado.php"><i class="fas fa-search"></i> <span>Revisión de Estado de Orquídeas</span></a></li>

        <?php if ($user_type != 5) : ?>
            <!-- Opciones solo visibles para administradores -->
            <li><a href="Identificar.php"><i class="fas fa-leaf"></i> <span>Identificación de Orquídeas</span></a></li>
            <li><a href="juzgamiento"><i class="fas fa-gavel"></i> <span>Juzgamiento</span></a></li>
            <li><a href="Reportes.php"><i class="fas fa-chart-bar"></i> <span>Reporte de Orquídeas</span></a></li>
            <li><a href="Trofeos.php"><i class="fas fa-trophy"></i> <span>Premios</span></a></li>
        <?php endif; ?>

        <li><a href="../Backend/logout.php"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a></li>
    </ul>
</div>
