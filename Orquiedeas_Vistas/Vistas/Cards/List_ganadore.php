<div class="card">
    <div class="card-header">
        <h3>Listado de Ganadores</h3>
        <p>Genera un reporte de los ganadores en diferentes categorías en el período seleccionado.</p>
    </div>
    <div class="card-body">
        <label for="start-date">Fecha de inicio:</label>
        <input type="date" id="start-date-ganadores" class="form-control">
        
        <label for="end-date">Fecha de fin:</label>
        <input type="date" id="end-date-ganadores" class="form-control">
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" onclick="generateReport('Listado de Ganadores', 'start-date-ganadores', 'end-date-ganadores')">
            Generar Reporte
        </button>
    </div>
</div>
