<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="Dashboard.php" data-target="Dashboard.php"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
        <li><a href="#" data-target="../Vistas/Cards/Card_Trofeo/desig_trofeo.php"><i class="fas fa-plus-circle"></i> <span>dar Trofeo a orquidea</span></a></li>
        <li><a href="#" data-target="../Vistas/Cards/Card_Trofeo/Crud_trofeos.php"><i class="fas fa-tasks"></i> <span>Gestionar Trofeos</span></a></li>
    </ul>
</div>


<script>
    document.getElementById('reload-button').addEventListener('click', function(e) {
        e.preventDefault(); // Prevenir la acción por defecto del enlace
        location.reload(); // Recargar la página actual
    });
</script>