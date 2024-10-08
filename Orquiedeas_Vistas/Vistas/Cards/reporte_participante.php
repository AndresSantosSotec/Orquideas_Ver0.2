<div class="card" style="margin: 20px auto; max-width: 60%;">
    <div class="card-header text-center" style="background-color: #f8f9fa;">
        <h3>Reporte Orquídeas Asignadas y Registradas a cada participante</h3>
        <p style="font-size: 1rem;">Descarga el formato para el juzgamiento de orquídeas.</p>
    </div>
    <div class="card-body text-center" style="padding: 20px;">
        <!-- Aquí puedes añadir cualquier contenido adicional que necesites mostrar -->
    </div>
    <div class="card-footer text-center" style="padding: 20px;">
        <button class="btn btn-primary" style="font-size: 1.2rem; padding: 10px 20px;" onclick="openPdf()">
            Descargar Formato
        </button>
    </div>
</div>

<script>
    function openPdf() {
        // Abrir el PDF en una nueva pestaña
        window.open('../Vistas/Documentos/pdf/participates_Orquideas.php', '_blank');
    }
</script>
