<div class="card">
    <div class="card-header">
        <h3>Listado de Orquídeas por Clases</h3>
        <p>Genera un reporte de orquídeas clasificadas por categorías en el período seleccionado.</p>
    </div>
    <div class="card-body">
        <form method="GET" action="../Vistas/Documentos/pdf/Listado_por_clases.php" target="_blank">
            <label for="start-date">Fecha de inicio:</label>
            <input type="date" id="start-date-clases" name="start_date" class="form-control" required>
            <br>
            <label for="end-date">Fecha de fin:</label>
            <input type="date" id="end-date-clases" name="end_date" class="form-control" required>
            <br><br>
            <button type="submit" class="btn btn-primary">Generar Reporte</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Limitar la fecha de fin a la fecha actual
        const endDate = document.getElementById("end-date-clases");
        const today = new Date().toISOString().split("T")[0];
        endDate.setAttribute("max", today);
    });
</script>
