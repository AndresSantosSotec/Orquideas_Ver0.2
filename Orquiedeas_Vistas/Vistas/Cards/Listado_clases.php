<div class="card">
    <div class="card-header">
        <h3>Listado de Orquídeas por Clases</h3>
        <p>Genera un reporte de orquídeas clasificadas por categorías en el período seleccionado.</p>
    </div>
    <div class="card-body">
        <label for="start-date">Fecha de inicio:</label>
        <input type="date" id="start-date-clases" class="form-control">
        
        <label for="end-date">Fecha de fin:</label>
        <input type="date" id="end-date-clases" class="form-control">
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" onclick="generateReport('Listado de Orquídeas por Clases', 'start-date-clases', 'end-date-clases')">
            Generar Reporte
        </button>
    </div>
</div>
