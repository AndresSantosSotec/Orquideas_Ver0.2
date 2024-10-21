<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <h2>Admin Panel</h2>

    <ul>
        <li><a href="dashboard.php" data-target="#"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
        <li class="admin-only">
            <a href="#" data-target="../Vistas/Cruds/Crud_participantes.php">
                <i class="fas fa-users"></i> <span>Ver Participantes</span>
            </a>
        </li>
        <li class="admin-only"><a href="#"><i class="fas fa-seedling"></i> <span>Registro de Participantes</span></a></li>
        <li class="admin-only">
            <a href="#" data-target="../Vistas/Cards/reporte_participante.php">
                <i class="fas fa-file-alt"></i> <span>Reporte de Participantes</span>
            </a>
        </li>
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Capturar el tipo de usuario desde PHP y pasarlo a JavaScript
        const userType = <?php echo json_encode($user_type); ?>;

        // Enviar a la consola del navegador para verificar
        console.log("Tipo de Usuario:", userType);

        // Ocultar elementos del sidebar si el usuario es de tipo 5
        if (userType === 5) {
            document.querySelectorAll('.admin-only').forEach((element) => {
                element.style.display = 'none'; // Ocultar los elementos del sidebar
            });
        }
    });

    // Control de navegación con confirmación si hay cambios sin guardar
    $('ul li a').on('click', function(e) {
        const link = $(this).attr('href'); // Obtener el enlace

        if (!link) {
            console.error('No se encontró un enlace válido');
            return;
        }

        if (isFormDirty && !isFormSubmitted) {
            e.preventDefault(); // Prevenir la navegación

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
                    isFormDirty = false; // Resetear cambios
                    window.location.assign(link); // Redirigir al enlace
                }
            });
        } else {
            e.preventDefault(); 
            window.location.assign(link); // Redirigir si no hay cambios
        }
    });
</script>
