<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="Dashboard.php" data-target="Dashboard.php"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
        <li><a href="#" id="forceRedirect" data-target="../Vistas/Cards/card_estado/add_std.php"><i class="fas fa-plus-circle"></i> <span>Agregar estado de la orquídea</span></a></li>
        <li><a href="estado.php" data-target="estado.php"><i class="fas fa-tasks"></i> <span>Gestionar estado</span></a></li>
    </ul>
</div>

<script>
    document.getElementById('forceRedirect').addEventListener('click', function(event) {
        event.preventDefault();  // Evita el comportamiento predeterminado del enlace
        window.location.href = 'estado.php';  // Fuerza la redirección a estado.php
    });
</script>
