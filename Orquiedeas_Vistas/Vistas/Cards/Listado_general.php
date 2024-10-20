<div class="card">
    <div class="card-header">
        <h3>Listado General</h3>
        <p>Selecciona un rango de fechas para el reporte.</p>
    </div>
    <div class="card-body">
        <form method="GET" action="../Vistas/Documentos/pdf/Listado_general_Plantas.php" target="_blank">
            <label for="start_date">Fecha de inicio:</label>
            <input type="date" id="start_date" name="start_date" required>
            <br>
            <label for="end_date">Fecha de fin:</label>
            <input type="date" id="end_date" name="end_date" required>
            <br><br>
            <button type="submit" class="btn btn-primary">Generar Reporte</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener el elemento de la fecha de inicio y fin
        const startDate = document.getElementById("start_date");
        const endDate = document.getElementById("end_date");

        // Limitar la fecha de fin a la fecha actual
        const today = new Date().toISOString().split("T")[0];
        endDate.setAttribute("max", today);

        // Limitar la fecha de inicio a la primera fecha obtenida desde PHP
        const primeraFecha = "<?php echo $primeraFecha; ?>";  // Será generada desde el servidor PHP
        startDate.setAttribute("min", primeraFecha);

        // También limitar la fecha de inicio y fin a la fecha de hoy
        startDate.setAttribute("max", today);
    });
</script>
