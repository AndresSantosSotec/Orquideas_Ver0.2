<?php
include 'conexion.php'; // Ajusta la ruta de conexión



// Capturar el tipo y ID del usuario desde la sesión
$user_type = $_SESSION['user_type'];
$user_id = $_SESSION['user_id'];

// Construir la consulta dependiendo del tipo de usuario
if ($user_type == 5) {
    // Si es usuario tipo 5, mostrar solo sus orquídeas
    $query = "
        SELECT 
            o.id_orquidea, 
            o.codigo_orquidea,
            p.nombre AS nombre_participante,
            g.Cod_Grupo,
            g.nombre_grupo,
            c.id_clase,
            CONCAT('Clase: ', c.id_clase) AS clase,
            a.estado -- Estado de la orquídea
        FROM tb_orquidea o
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN tb_participante p ON o.id_participante = p.id
        LEFT JOIN tb_almacenadas a ON o.id_orquidea = a.id_orquidea
        WHERE p.id_usuario = ?";
    
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $user_id);
} else {
    // Si es administrador, mostrar todas las orquídeas
    $query = "
        SELECT 
            o.id_orquidea, 
            o.codigo_orquidea,
            p.nombre AS nombre_participante,
            g.Cod_Grupo,
            g.nombre_grupo,
            c.id_clase,
            CONCAT('Clase: ', c.id_clase) AS clase,
            a.estado -- Estado de la orquídea
        FROM tb_orquidea o
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN tb_participante p ON o.id_participante = p.id
        LEFT JOIN tb_almacenadas a ON o.id_orquidea = a.id_orquidea";
    
    $stmt = $conexion->prepare($query);
}

$stmt->execute();
$orquideas = $stmt->get_result();
?>


<div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Resultados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Participante</th>
                        <th>Código Grupo</th>
                        <th>Clase</th>
                        <th>Nombre Grupo</th>
                        <th>Estado</th>
                        <?php if ($user_type != 5) { ?> <!-- Ocultar acciones si es usuario tipo 5 -->
                            <th>Acciones</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($orquideas && mysqli_num_rows($orquideas) > 0) {
                        while ($row = mysqli_fetch_assoc($orquideas)) {
                            $estadoColor = ($row['estado'] == 'participando') ? 'green' : 'red';
                    ?>
                            <tr id="orquidea_<?php echo $row['id_orquidea']; ?>">
                                <td><?php echo $row['id_orquidea']; ?></td>
                                <td><?php echo $row['nombre_participante']; ?></td>
                                <td><?php echo $row['Cod_Grupo']; ?></td>
                                <td><?php echo $row['clase']; ?></td>
                                <td><?php echo $row['nombre_grupo']; ?></td>
                                <td style="color: <?php echo $estadoColor; ?>;">
                                    <?php echo ucfirst($row['estado']); ?>
                                </td>
                                <?php if ($user_type != 5) { ?>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-info btn-sm btn-ver" data-id="<?php echo $row['id_orquidea']; ?>" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $row['id_orquidea']; ?>" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } 
                    } else { ?>
                        <tr>
                            <td colspan="<?php echo ($user_type != 5) ? '7' : '6'; ?>" class="text-center">No se encontraron registros.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Aquí va el script justo antes de cerrar el body -->

