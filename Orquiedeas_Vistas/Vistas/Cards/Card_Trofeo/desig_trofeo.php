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
                <form method="POST" action="../Backend/insert_trofeo.php"> <!-- Ruta corregida -->
                    <div class="mb-3">
                        <label for="id_orquidea" class="form-label">Orquídea</label>
                        <select name="id_orquidea" id="id_orquidea" class="form-select" required>
                            <option value="">Seleccione una Orquídea</option>
                            <?php
                            include '../../../Backend/Conexion_bd.php'; // Cambia esta ruta según tu estructura de archivos
                            
                            // Intentar ejecutar la consulta SQL y manejar errores
                            $orquideas = $conexion->query("
                                SELECT o.id_orquidea, o.codigo_orquidea, o.nombre_planta, c.id_clase, c.nombre_clase, g.id_grupo, g.nombre_grupo, p.nombre AS nombre_participante
                                FROM tb_orquidea o
                                INNER JOIN clase c ON o.id_clase = c.id_clase
                                INNER JOIN grupo g ON o.id_grupo = g.id_grupo
                                INNER JOIN tb_participante p ON o.id_participante = p.id
                            ");

                            if ($orquideas === false) {
                                // Si hay un error en la consulta, mostrarlo
                                echo '<option>Error en la consulta: ' . $conexion->error . '</option>';
                            } else {
                                // Iterar sobre los resultados de la consulta
                                while ($row = $orquideas->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row['id_orquidea']; ?>" 
                                            data-id_clase="<?php echo $row['id_clase']; ?>" 
                                            data-id_grupo="<?php echo $row['id_grupo']; ?>">
                                        <?php echo $row['id_orquidea'] . " - " . $row['nombre_planta'] . " (" . $row['nombre_clase'] . ", Grupo: " . $row['nombre_grupo'] . ", Participante: " . $row['nombre_participante'] . ")"; ?>
                                    </option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Aquí se mostrarán los detalles dinámicamente -->
                   

                    <input type="hidden" name="id_orquidea" id="hidden_id_orquidea">
                    
                    <button type="submit" class="btn btn-primary">Asignar Trofeo</button>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery para manejar el cambio en la selección de orquídea y llenar los selects de clase, grupo y participante -->
    <script>
        $(document).ready(function() {
            $('#id_orquidea').change(function() {
                var selectedOption = $(this).find('option:selected');
                var id_orquidea = selectedOption.val();
                var id_clase = selectedOption.data('id_clase');
                var id_grupo = selectedOption.data('id_grupo');

                // Llenar el select de clase
                $('#id_clase').html('<option value="' + id_clase + '">Clase correspondiente</option>');

                // Llenar el select de grupo
                $('#id_grupo').html('<option value="' + id_grupo + '">Grupo correspondiente</option>');

                // Llenar el select de participante
                $.ajax({
                    url: '../Backend/fetch_orquidea_details.php',  // Ruta correcta para cargar los participantes
                    method: 'POST',
                    data: { id_orquidea: id_orquidea },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            var participanteOptions = '<option value="">Seleccione un participante</option>';
                            $.each(response.participantes, function(index, participante) {
                                participanteOptions += '<option value="' + participante.id + '">' + participante.nombre + '</option>';
                            });
                            $('#id_participante').html(participanteOptions);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Error al cargar los participantes.");
                    }
                });

                // Asignar los valores a los campos ocultos
                $('#hidden_id_orquidea').val(id_orquidea);
            });
        });
    </script>

    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
