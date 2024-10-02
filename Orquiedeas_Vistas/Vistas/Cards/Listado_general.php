<div class="card">
    <div class="card-header">
        <h3>Listado General de Orquídeas</h3>
        <p>Genera un reporte de todas las orquídeas registradas en el período seleccionado.</p>
    </div>
    <div class="card-body">
        <label for="start-date">Fecha de inicio:</label>
        <input type="date" id="start-date-listado-general" class="form-control">
        
        <label for="end-date">Fecha de fin:</label>
        <input type="date" id="end-date-listado-general" class="form-control">
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" onclick="generateReport('Listado General de Orquídeas', 'start-date-listado-general', 'end-date-listado-general')">
            Generar Reporte
        </button>
    </div>
</div>
