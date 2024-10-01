<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="dashboard.php" data-target="dashboard.php"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
        <li><a href="#"><i class="fas fa-seedling"></i> <span>Registro de Participantes</span></a></li>
        <li><a href="#" data-target="../Vistas/Cruds/Crud_participantes.php"><i class="fas fa-users"></i> <span>Ver Participantes</span></a></li>
        <li><a href="#"><i class="fas fa-file-alt"></i> <span>Reporte de Participantes</span></a></li>
    </ul>
</div>

<script>

    //COMENTARIO PARA INDICAR QUE ESTE CODIGO SE PUEDE QUITAR PARA QUITAR EL ERROR DE MENSAJE DE LOS FORMULARIOS------------------

// Interceptar clicks en los botones del menú lateral
$('ul li a').on('click', function(e) {
    const link = $(this).attr('href'); // Obtener el enlace
    if (isFormDirty && !isFormSubmitted) {
        e.preventDefault(); // Prevenir la acción predeterminada
        const proceed = confirm('Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?');
        if (proceed) {
            isFormDirty = false; // Restablecer la variable para evitar otros mensajes
            window.location.href = link; // Redirigir solo si confirma
        }
    } else {
        window.location.href = link; // Si no hay cambios, proceder con la navegación
    }
});

</script>

