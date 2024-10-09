<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>

    <ul>
        <li><a href="Dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        <li><a href="agregar_estado.php" data-target="#"><i class="fas fa-plus-circle"></i> <span>Agregar estado de la orquídea</span></a></li>
        <li><a href="gestionar_estado.php" data-target="#"><i class="fas fa-tasks"></i> <span>Gestionar estado</span></a></li>
        <li><a href="reporte_estado.php" data-target="#"><i class="fas fa-file-alt"></i> <span>Reporte de estado</span></a></li>
    </ul>
</div>

<script>
    // Inicializamos las variables
    var isFormDirty = false; // Si hay cambios no guardados en el formulario
    var isFormSubmitted = false; // Si el formulario ha sido enviado

    // Detectar cambios en los campos del formulario y marcar isFormDirty como true
    $('form input, form select, form textarea').on('change input', function() {
        isFormDirty = true; // Se ha modificado el formulario
    });

    $('ul li a').on('click', function(e) {
        const link = $(this).attr('href'); // Obtener el enlace

        // Validar si el enlace es válido antes de proceder
        if (!link) {
            console.error('No se encontró un enlace válido');
            return;
        }

        // Si el enlace es al Dashboard, simplemente redirige sin validación
        if (link === "Dashboard.php") {
            return; // Deja que el navegador redirija normalmente
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
            });
        } else {
            // Si no hay cambios en el formulario, prevenimos la acción predeterminada
            e.preventDefault();
            window.location.assign(link); // Procedemos a redirigir normalmente
        }
    });
</script>
