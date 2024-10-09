<div class="card">
    <div class="card-header bg-info text-white">
        <h3><i class="fas fa-file-alt"></i> Formatos de Inscripción</h3>
        <p>Descarga los formatos de inscripción para orquídeas y participantes.</p>
    </div>
    <div class="card-body">
        <p>No es necesario seleccionar fechas ni ingresar datos para generar estos reportes.</p>
    </div>
    <div class="card-footer">
        <div class="d-grid gap-2 d-md-block">
            <!-- Botón para descargar el formato de inscripción de orquídeas -->
            <button class="btn btn-primary" onclick="openPdfOrq()">
                Descargar Formato Orquideas
            </button>

            <!-- Botón para descargar el formato de inscripción de participantes -->
            <button class="btn btn-primary" onclick="openPdfpar()">
                Descargar Formato Paricipantes
            </button>

        </div>
    </div>
</div>


<script>
    function openPdfOrq() {
        // Abrir el PDF en una nueva pestaña
        window.open('../Vistas/Documentos/pdf/Inscri_orquidea.php', '_blank');
    }

    function openPdfpar() {
        // Abrir el PDF en una nueva pestaña
        window.open('../Vistas/Documentos/pdf/incri_participante.php', '_blank');
    }
</script>