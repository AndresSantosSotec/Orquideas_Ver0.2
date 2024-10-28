<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Trofeo al Ganador Absoluto</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
        <div class="card" style="font-size: 0.9rem;">
            <div class="card-header bg-primary text-white">
                <h2 style="font-size: 1.5rem;">Asignar Trofeo al Ganador Absoluto</h2>
            </div>
            <div class="card-body" style="padding: 10px;">
                <p><strong>Instrucciones:</strong> Escriba el nombre de la orquídea, participante, grupo (por ejemplo: <code>Grupo A</code>), o clase para filtrar las opciones disponibles.</p>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" id="search_planta" class="form-control" placeholder="Buscar Orquídea">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="search_participante" class="form-control" placeholder="Buscar Participante">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="search_grupo" class="form-control" placeholder="Buscar Grupo (Ej: Grupo A)">
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="search_clase" class="form-control" placeholder="Buscar Clase">
                    </div>
                </div>

                <form method="POST" action="../Backend/insert_trofeo.php">
                    <div class="mb-3">
                        <label for="id_orquidea" class="form-label">Orquídea</label>
                        <select name="id_orquidea" id="id_orquidea" class="form-select" required>
                            <option value="">Seleccione una Orquídea</option>
                            <?php
                            include '../../../Backend/Conexion_bd.php';
                            $query = "
                            SELECT o.id_orquidea, o.nombre_planta, c.nombre_clase, g.nombre_grupo, p.nombre AS nombre_participante
                            FROM tb_orquidea o
                            INNER JOIN clase c ON o.id_clase = c.id_clase
                            INNER JOIN grupo g ON o.id_grupo = g.id_grupo
                            INNER JOIN tb_participante p ON o.id_participante = p.id
                            LEFT JOIN tb_trofeo t ON o.id_orquidea = t.id_orquidea
                            WHERE t.id_orquidea IS NULL";

                            $orquideas = $conexion->query($query);
                            if ($orquideas) {
                                while ($row = $orquideas->fetch_assoc()) {
                                    echo "<option value='{$row['id_orquidea']}' 
                                      data-planta='{$row['nombre_planta']}'
                                      data-participante='{$row['nombre_participante']}'
                                      data-grupo='{$row['nombre_grupo']}'
                                      data-clase='{$row['nombre_clase']}'>
                                      {$row['nombre_planta']} ({$row['nombre_clase']}, Grupo: {$row['nombre_grupo']}, Participante: {$row['nombre_participante']})
                                      </option>";
                                }
                            } else {
                                echo "<option>Error en la consulta: " . $conexion->error . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <input type="hidden" name="id_orquidea" id="hidden_id_orquidea">
                    <button type="submit" class="btn btn-primary">Asignar Trofeo</button>
                </form>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            function filterOptions() {
                const searchPlanta = $('#search_planta').val()?.toLowerCase() || '';
                const searchParticipante = $('#search_participante').val()?.toLowerCase() || '';
                const searchGrupo = $('#search_grupo').val()?.toLowerCase() || '';
                const searchClase = $('#search_clase').val()?.toLowerCase() || '';

                $('#id_orquidea option').each(function() {
                    const planta = $(this).data('planta')?.toLowerCase() || '';
                    const participante = $(this).data('participante')?.toLowerCase() || '';
                    const grupo = $(this).data('grupo')?.toLowerCase() || '';
                    const clase = $(this).data('clase')?.toLowerCase() || '';

                    if (planta.includes(searchPlanta) &&
                        participante.includes(searchParticipante) &&
                        grupo.includes(searchGrupo) &&
                        clase.includes(searchClase)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }

            $('#search_planta, #search_participante, #search_grupo, #search_clase').on('input', filterOptions);

            $('#id_orquidea').change(function() {
                const selectedOption = $(this).find('option:selected');
                $('#hidden_id_orquidea').val(selectedOption.val());
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>