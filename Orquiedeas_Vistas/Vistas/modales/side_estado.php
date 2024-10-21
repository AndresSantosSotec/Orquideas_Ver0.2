<?php
// Asegurar que la sesión está iniciada
$user_type = $_SESSION['user_type']; // Obtener el tipo de usuario desde la sesión
?>

<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>
    <ul>
        <li>
            <a href="Dashboard.php" class="no-ajax">
                <i class="fas fa-home"></i> <span>Inicio</span>
            </a>
        </li>

        <?php if ($user_type != 5) { ?> <!-- Mostrar solo para administradores -->
            <li>
                <a href="#" data-target="../Vistas/Cards/card_estado/add_std.php">
                    <i class="fas fa-plus-circle"></i> <span>Agregar estado de la orquídea</span>
                </a>
            </li>
            <li>
                <a href="estado.php" data-target="estado.php" id="reload-button">
                    <i class="fas fa-tasks"></i> <span>Gestionar estado</span>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>

<script>
    // Lógica para recargar la página al hacer clic en "Gestionar estado"
    const reloadButton = document.getElementById('reload-button');
    if (reloadButton) {
        reloadButton.addEventListener('click', function(e) {
            e.preventDefault(); // Prevenir la acción por defecto del enlace
            location.reload(); // Recargar la página actual
        });
    }

    // Función para alternar el sidebar
    document.getElementById('toggle-button').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('collapsed');
    });
</script>