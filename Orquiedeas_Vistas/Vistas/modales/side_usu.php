<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>
    
    <ul>
        <li><a href="dashboard.php" data-target="#"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
        <li><a href="#" data-target="../Vistas/Cruds/Crud_participantes.php"><i class="fas fa-users"></i> <span>Ver Participantes</span></a></li>
        <li><a href="#"><i class="fas fa-seedling"></i> <span>Registro de Participantes</span></a></li>
        <li><a href="#" data-target="../Vistas/Cards/reporte_participante.php"><i class="fas fa-file-alt"></i> <span>Reporte de Participantes</span></a></li>
    </ul>
</div>

<script>

    //COMENTARIO PARA INDICAR QUE ESTE CODIGO SE PUEDE QUITAR PARA QUITAR EL ERROR DE MENSAJE DE LOS FORMULARIOS------------------

    $('ul li a').on('click', function(e) {
    const link = $(this).attr('href'); // Obtener el enlace

    // Validar si el enlace es válido antes de proceder
    if (!link) {
        console.error('No se encontró un enlace válido');
        return;
    }

    // Si hay cambios en el formulario y no se ha enviado
    if (isFormDirty && !isFormSubmitted) {
        e.preventDefault(); // Prevenir la acción predeterminada de navegación

        Swal.fire({
            title: 'Tienes cambios sin guardar',
            text: '¿Estás seguro de que quieres salir sin guardar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'No, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, reseteamos el indicador de cambios y redirigimos
                isFormDirty = false; // Evita futuros mensajes de cambios
                window.location.assign(link); // Redirige al enlace
            }
            // Si el usuario cancela, simplemente no hacemos nada y los datos se mantienen
        });
    } else {
        // Si no hay cambios en el formulario, prevenimos la acción predeterminada
        e.preventDefault(); 
        window.location.assign(link); // Procedemos a redirigir normalmente
    }
});
</script>

