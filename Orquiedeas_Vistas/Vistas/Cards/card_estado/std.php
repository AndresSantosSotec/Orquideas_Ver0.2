<?php
include 'conexion.php'; // Ajusta la ruta de conexión

// Consultar las orquídeas con INNER JOIN a grupo, clase y participante, y LEFT JOIN con tb_almacenadas
$query = "
    SELECT 
        o.id_orquidea, 
        o.codigo_orquidea,
        p.nombre AS nombre_participante,
        g.Cod_Grupo,
        g.nombre_grupo,
        c.id_clase,
        CONCAT('Clase: ', c.id_clase) AS clase,
        a.estado -- Incluimos el estado de la orquídea
    FROM tb_orquidea o
    INNER JOIN grupo g ON o.id_grupo = g.id_grupo
    INNER JOIN clase c ON o.id_clase = c.id_clase
    INNER JOIN tb_participante p ON o.id_participante = p.id
    LEFT JOIN tb_almacenadas a ON o.id_orquidea = a.id_orquidea"; // Unimos con la tabla tb_almacenadas

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
                        <th>Estado</th> <!-- Nueva columna para el estado -->
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($orquideas && mysqli_num_rows($orquideas) > 0) {
                        while ($row = mysqli_fetch_assoc($orquideas)) { 
                            // Asignamos color según el estado
                            $estadoColor = ($row['estado'] == 'participando') ? 'green' : 'red'; 
                        ?>
                            <tr id="orquidea_<?php echo $row['id_orquidea']; ?>">
                                <td><?php echo $row['id_orquidea']; ?></td>
                                <td><?php echo $row['nombre_participante']; ?></td>
                                <td><?php echo $row['Cod_Grupo']; ?></td>
                                <td><?php echo $row['clase']; ?></td>
                                <td><?php echo $row['nombre_grupo']; ?></td>
                                <td style="color: <?php echo $estadoColor; ?>;">
                                    <?php echo ucfirst($row['estado']); ?> <!-- Estado con primera letra mayúscula -->
                                </td>
                                <td>
                                    <!-- Botón Ver para mostrar detalles en un card -->
                                    <a href="javascript:void(0)" class="btn btn-info btn-sm btn-ver" data-id="<?php echo $row['id_orquidea']; ?>" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- Botón de Editar -->
                                    <button type="button" class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $row['id_orquidea']; ?>" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Botón de Eliminar -->
                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $row['id_orquidea']; ?>" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7" class="text-center">No se encontraron registros.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Contenedor donde se mostrará la vista de "Ver Orquídea" -->


<!-- Agregar el script para manejar la eliminación, edición y ver -->

