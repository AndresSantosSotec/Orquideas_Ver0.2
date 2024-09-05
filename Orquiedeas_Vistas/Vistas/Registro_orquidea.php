<?php
include '../backend/Conexion_bd.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Participante y Orquídeas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>
<body>
    <div class="container mt-5">

        <!-- Card 1: Registro del Participante -->
        <div class="card shadow-sm" id="cardParticipante">
            <div class="card-body">
                <h1 class="card-title text-center">Registro de Participante</h1>

                <form id="participanteForm" action="registrar_participante.php" method="POST">
                    <div class="mb-2">
                        <label for="nombre_completo" class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="numero_telefonico" class="form-label">Número de Teléfono</label>
                        <input type="text" name="numero_telefonico" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="tipo_participante" class="form-label">Tipo de Participante</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_participante" value="Regional" id="regional" required>
                                <label class="form-check-label" for="regional">Regional</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_participante" value="Extranjero" id="extranjero" required>
                                <label class="form-check-label" for="extranjero">Extranjero</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2" id="regionalFields">
                        <label for="departamento_id" class="form-label">Departamento</label>
                        <select name="departamento_id" id="departamento_id" class="form-select">
                            <option value="">Seleccione un Departamento</option>
                            <!-- Aquí puedes hacer la carga dinámica de departamentos -->
                        </select>
                    </div>

                    <div class="mb-2" id="municipioFields">
                        <label for="municipio_id" class="form-label">Municipio</label>
                        <select name="municipio_id" id="municipio_id" class="form-select">
                            <option value="">Seleccione un Municipio</option>
                            <!-- Los municipios se cargarán dinámicamente -->
                        </select>
                    </div>

                    <div class="mb-2" id="extranjeroFields" style="display:none;">
                        <label for="pais" class="form-label">País</label>
                        <input type="text" name="pais" class="form-control">
                    </div>

                    <button type="button" class="btn btn-primary w-100 btn-sm" onclick="nextStep()">Siguiente</button>
                </form>
            </div>
        </div>

        <!-- Card 2: Registro de Orquídeas -->
        <div class="card shadow-sm" id="cardOrquidea" style="display:none;">
            <div class="card-body">
                <h1 class="card-title text-center">Registro de Orquídeas</h1>

                <form id="orquideaForm" action="registrar_orquidea.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="cantidad_orquideas" class="form-label">¿Cuántas orquídeas desea registrar?</label>
                        <input type="number" id="cantidad_orquideas" class="form-control" required>
                    </div>

                    <div id="orquideasContainer"></div>

                    <button type="submit" class="btn btn-primary w-100 btn-sm">Registrar Orquídea(s)</button>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Ocultar campos de departamento y municipio si el participante es extranjero
        document.querySelectorAll('input[name="tipo_participante"]').forEach((elem) => {
            elem.addEventListener('change', function(event) {
                if (event.target.value === 'Extranjero') {
                    document.getElementById('regionalFields').style.display = 'none';
                    document.getElementById('municipioFields').style.display = 'none';
                    document.getElementById('extranjeroFields').style.display = 'block';
                } else {
                    document.getElementById('regionalFields').style.display = 'block';
                    document.getElementById('municipioFields').style.display = 'block';
                    document.getElementById('extranjeroFields').style.display = 'none';
                }
            });
        });

        // Función para cambiar de paso (de participante a orquídea)
        function nextStep() {
            document.getElementById('cardParticipante').style.display = 'none';
            document.getElementById('cardOrquidea').style.display = 'block';
            const cantidadOrquideas = parseInt(document.getElementById('cantidad_orquideas').value) || 1;

            // Generar campos dinámicos para orquídeas
            const orquideasContainer = document.getElementById('orquideasContainer');
            orquideasContainer.innerHTML = '';  // Limpiar cualquier contenido anterior

            for (let i = 1; i <= cantidadOrquideas; i++) {
                orquideasContainer.innerHTML += `
                    <div class="mb-2">
                        <label for="nombre_orquidea_${i}" class="form-label">Nombre de la Orquídea ${i}</label>
                        <input type="text" name="nombre_orquidea_${i}" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="especie_${i}" class="form-label">Especie ${i}</label>
                        <input type="text" name="especie_${i}" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label for="origen_${i}" class="form-label">Origen ${i}</label>
                        <select name="origen_${i}" class="form-select" required>
                            <option value="Natural">Natural</option>
                            <option value="Laboratorio">Laboratorio</option>
                            <option value="Híbrida">Híbrida</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto_${i}" class="form-label">Fotografía de la Orquídea ${i}</label>
                        <input type="file" name="foto_${i}" class="form-control">
                    </div>
                `;
            }
        }

        // Función para cargar municipios dinámicamente según el departamento
        document.getElementById('departamento_id').addEventListener('change', function() {
            let departamentoId = this.value;
            let municipioSelect = document.getElementById('municipio_id');

            municipioSelect.innerHTML = '<option value="">Cargando...</option>';

            fetch(`municipios.php?departamento_id=${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    municipioSelect.innerHTML = '<option value="">Seleccione un Municipio</option>';
                    data.forEach(municipio => {
                        municipioSelect.innerHTML += `<option value="${municipio.id}">${municipio.nombre}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching municipios:', error));
        });
    </script>
</body>
</html>
