<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

// Consultar las orquídeas con INNER JOIN a grupo, clase y participante
$query = "
    SELECT 
        o.id_orquidea, 
        o.codigo_orquidea,
        p.nombre AS nombre_participante,
        g.Cod_Grupo,
        g.nombre_grupo,
        c.id_clase,
        CONCAT('Clase: ', c.id_clase) AS clase
    FROM tb_orquidea o
    INNER JOIN grupo g ON o.id_grupo = g.id_grupo
    INNER JOIN clase c ON o.id_clase = c.id_clase
    INNER JOIN tb_participante p ON o.id_participante = p.id";

$orquideas = mysqli_query($conexion, $query);
?>

<div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
    <!-- Resultados -->
    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Resultados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <a href="Neva_orquidea.php" class="btn btn-dark mb-3">+ Agregar Nuevo Registro</a>
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Participante</th>
                        <th>Código Grupo</th>
                        <th>Clase</th>
                        <th>Nombre Grupo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($orquideas && mysqli_num_rows($orquideas) > 0) {
                        while ($row = mysqli_fetch_assoc($orquideas)) { ?>
                            <tr>
                                <td><?php echo $row['id_orquidea']; ?></td>
                                <td><?php echo $row['nombre_participante']; ?></td>
                                <td><?php echo $row['Cod_Grupo']; ?></td>
                                <td><?php echo $row['clase']; ?></td>
                                <td><?php echo $row['nombre_grupo']; ?></td>
                                <td>
                                    <a href="ver.php?id=<?php echo $row['codigo_orquidea']; ?>" class="btn btn-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Botón de Editar -->
                                    <button type="button" class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $row['id_orquidea']; ?>" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <!-- Botón de Eliminar -->
                                    <a href="eliminar.php?id=<?php echo $row['codigo_orquidea']; ?>" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="6" class="text-center">No se encontraron registros.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Incluir el modal de edición -->
<?php include '../modales/modales_orquideas/editar.php'; ?>


<!-- Agregar el script para abrir el modal y cargar los datos -->
<script>
    // Script para abrir el modal con los datos de la orquídea
    $(document).on('click', '.btn-editar', function() {
        var idOrquidea = $(this).data('id'); // Obtener el ID de la orquídea

        // Hacer una petición AJAX para obtener los datos de la orquídea
        $.ajax({
            url: '../../Backend/get_orquidea.php', // Archivo PHP que obtiene los datos de la orquídea
            type: 'GET',
            data: { id: idOrquidea },
            success: function(data) {
                var orquidea = JSON.parse(data);

                // Rellenar los campos del modal con los datos obtenidos
                $('#id_orquidea').val(orquidea.id_orquidea);
                $('#edit_nombre_planta').val(orquidea.nombre_planta);
                $('#edit_origen').val(orquidea.origen);
                $('#edit_id_grupo').val(orquidea.id_grupo);
                $('#edit_id_clase').val(orquidea.id_clase);
                $('#edit_id_participante').val(orquidea.id_participante);
                $('#edit_codigo_qr').val(orquidea.codigo_qr); // No editable

                // Abrir el modal
                $('#editOrquideaModal').modal('show');
            }
        });
    });
</script>
