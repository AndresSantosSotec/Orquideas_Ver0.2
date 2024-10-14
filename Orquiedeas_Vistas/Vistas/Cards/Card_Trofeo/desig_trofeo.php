<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Trofeo al Ganador Absoluto</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Incluye jQuery -->
</head>
<body>
    <div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
        <!-- Card para asignar el trofeo -->
        <div class="card" style="font-size: 0.9rem;">
            <div class="card-header bg-primary text-white">
                <h2 style="font-size: 1.5rem;">Asignar Trofeo al Ganador Absoluto</h2>
            </div>
            <div class="card-body" style="padding: 10px;">
                <!-- Formulario para seleccionar la orquídea -->
                <form method="POST" action="/Proyecto_Orquidea/Backend/insert_trofeo.php"> <!-- Ruta corregida -->
                    <div class="mb-3">
                        <label for="id_orquidea" class="form-label">Orquídea</label>
                        <select name="id_orquidea" id="id_orquidea" class="form-select" required>
                            <option value="">Seleccione una Orquídea</option>
                            <?php
                            include '../../../Backend/Conexion_bd.php'; // Cambia esta ruta según tu estructura de archivos
                            
                            // Ajuste de la consulta SQL para traer el código, nombre, clase y participante
                            $orquideas = $conexion->query("
                                SELECT o.id_orquidea, o.codigo_orquidea, o.nombre_planta, c.nombre_clase, p.nombre AS nombre_participante
                                FROM tb_orquidea o
                                INNER JOIN clase c ON o.id_clase = c.id_clase
                                INNER JOIN tb_participante p ON o.id_participante = p.id
                            ");

                            while ($row = $orquideas->fetch_assoc()) { ?>
                                <option value="<?php echo $row['id_orquidea']; ?>">
                                    <?php echo $row['codigo_orquidea'] . " - " . $row['nombre_planta'] . " (" . $row['nombre_clase'] . ", Participante: " . $row['nombre_participante'] . ")"; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Aquí se mostrarán los detalles dinámicamente -->
                    <div class="mb-3">
                        <label for="nombre_clase" class="form-label">Clase</label>
                        <input type="text" id="nombre_clase" class="form-control" readonly>
                        <input type="hidden" name="id_clase" id="hidden_id_clase">
                    </div>

                    <div class="mb-3">
                        <label for="nombre_grupo" class="form-label">Grupo</label>
                        <input type="text" id="nombre_grupo" class="form-control" readonly>
                        <input type="hidden" name="id_grupo" id="hidden_id_grupo">
                    </div>

                    <div class="mb-3">
                        <label for="nombre_participante" class="form-label">Participante</label>
                        <input type="text" id="nombre_participante" class="form-control" readonly>
                    </div>

                    <input type="hidden" name="id_orquidea" id="hidden_id_orquidea">
                    <button type="submit" class="btn btn-primary">Asignar Trofeo</button>
                </form>
            </div>
        </div>
    </div>

    <!-- AJAX para cargar los detalles de la orquídea -->
    <script>
        $(document).ready(function() {
            $('#id_orquidea').change(function() {
                var id_orquidea = $(this).val();
                
                if (id_orquidea !== "") {
                    $.ajax({
                        url: '/Proyecto_Orquidea/Backend/fetch_orquidea_details.php',  // Ruta corregida
                        method: 'POST',
                        data: { id_orquidea: id_orquidea },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Llenar los campos de clase, grupo y participante automáticamente
                                $('#nombre_clase').val(response.nombre_clase);
                                $('#nombre_grupo').val(response.nombre_grupo);
                                $('#nombre_participante').val(response.nombre_participante);

                                // Asignar los campos ocultos que se usarán en el formulario para enviar
                                $('#hidden_id_orquidea').val(response.id_orquidea);
                                $('#hidden_id_clase').val(response.id_clase);
                                $('#hidden_id_grupo').val(response.id_grupo);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function() {
                            alert("Error al cargar los datos.");
                        }
                    });
                }
            });
        });
    </script>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
