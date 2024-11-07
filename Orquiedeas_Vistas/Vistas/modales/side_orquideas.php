<div class="sidebar" id="sidebar">
    <button class="toggle-button" id="toggle-button">☰</button>
    <ul>
        <li><a href="Dashboard.php" class="no-ajax"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
        <li><a href="Neva_orquidea.php" data-target="Neva_orquidea.php"><i class="fas fa-seedling"></i> <span>Registro de Orquídeas</span></a></li>
        <li><a href="#" data-target="../Vistas/Cruds/Crud_Orquideas.php"><i class="fas fa-users"></i> <span>Ver Orquídeas</span></a></li>
        <!-- Opción de descarga del PDF desde el sidebar -->
        <li>
            <a id="download-pdf-sidebar" href="#" download><i class="fas fa-file-download"></i> <span>Descargar PDF</span></a>
        </li>
    </ul>
</div>

<script>
    // Evento para descargar el PDF cuando se hace clic en el enlace del sidebar
    document.getElementById('download-pdf-sidebar').addEventListener('click', function(e) {
        e.preventDefault(); // Prevenir la acción predeterminada del enlace
        const pdfUrl = './Class.pdf'; // Ruta del PDF
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = 'Class.pdf'; // Nombre del archivo descargado
        link.click(); // Simular el clic para iniciar la descarga
    });

    // Código para manejar la navegación en el sidebar
    $('ul li a').on('click', function(e) {
        const link = $(this).attr('href');
        if (!link) {
            console.error('No se encontró un enlace válido');
            return;
        }

        if (isFormDirty && !isFormSubmitted) {
            e.preventDefault();
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
                    isFormDirty = false;
                    window.location.assign(link);
                }
            });
        } else {
            e.preventDefault();
            window.location.assign(link);
        }
    });
</script>
