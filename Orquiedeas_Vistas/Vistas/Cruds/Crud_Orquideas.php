<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

// Validar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consultar las orquídeas con INNER JOIN a grupo, clase y participante
$query = "
    SELECT 
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
    <div class="card" style="font-size: 0.9rem;"> <!-- Reduciendo tamaño del texto de la card -->
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Resultados</h2> <!-- Reduciendo el tamaño del encabezado -->
        </div>
        <div class="card-body" style="padding: 10px;"> <!-- Ajustando el padding de la card -->
            <a href="agregar_registro.php" class="btn btn-dark mb-3">+ Agregar Nuevo Registro</a>
            <table class="table table-bordered table-striped table-sm"> <!-- Usando la clase .table-sm para reducir tamaño de tabla -->
                <thead class="thead-dark">
                    <tr>
                        <th>Código Orquídea</th>
                        <th>Participante</th>
                        <th>Código Grupo</th>
                        <th>Nombre Grupo</th>
                        <th>Clase</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($orquideas && mysqli_num_rows($orquideas) > 0) {
                        while ($row = mysqli_fetch_assoc($orquideas)) { ?>
                            <tr>
                                <td><?php echo $row['codigo_orquidea']; ?></td>
                                <td><?php echo $row['nombre_participante']; ?></td>
                                <td><?php echo $row['Cod_Grupo']; ?></td>
                                <td><?php echo $row['nombre_grupo']; ?></td>
                                <td><?php echo $row['clase']; ?></td>
                                <td>
                                    <a href="editar.php?id=<?php echo $row['codigo_orquidea']; ?>" class="btn btn-warning btn-sm">✏️</a> <!-- Botón reducido -->
                                    <a href="eliminar.php?id=<?php echo $row['codigo_orquidea']; ?>" class="btn btn-danger btn-sm">🗑️</a> <!-- Botón reducido -->
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
