<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="dashboard.php" data-target="#"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
        <li><a href="Neva_orquidea.php" data-target="Neva_orquidea.php"><i class="fas fa-seedling"></i> <span>Registro de Orquídeas</span></a></li>
        <li><a href="#" data-target="../Vistas/Cruds/Crud_Orquideas.php"><i class="fas fa-users"></i> <span>Ver Orquídeas</span></a></li>
        <li><a href="#" data-target="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a></li>
    </ul>
</div>



<script>

    //COMENTARIO PARA INDICAR QUE ESTE CODIGO SE PUEDE QUITAR PARA QUITAR EL ERROR DE MENSAJE DE LOS FORMULARIOS------------------

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
