<div class="card">
    <div class="card-header">
        <h3>Formato Juzgamiento</h3>
        <p>Descarga el formato para el juzgamiento de orquídeas.</p>
    </div>
    <div class="card-body">
        <p>No es necesario seleccionar fechas para este reporte.</p>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" onclick="openPdf()">
            Descargar Formato
        </button>
    </div>
</div>

<script>
    function openPdf() {
        // Abrir el PDF en una nueva pestaña
        window.open('../Vistas/Documentos/pdf/Listado_general_Plantas.php', '_blank');
    }
</script>
