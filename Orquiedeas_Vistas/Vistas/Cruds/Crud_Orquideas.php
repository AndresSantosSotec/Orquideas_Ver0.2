<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

// Validar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consultar todas las orquídeas (sin las columnas de imágenes ni QR)
$orquideas = mysqli_query($conexion, "SELECT `id_orquidea`, `nombre_planta`, `origen`, `id_grupo`, `id_clase`, `codigo_orquidea`, `id_participante`, `fecha_creacion`, `fecha_actualizacion` FROM `tb_orquidea`");
?>

<div class="container mt-4">
    <h2>Listado de Orquídeas</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Planta</th>
                <th>Origen</th>
                <th>Grupo</th>
                <th>Clase</th>
                <th>Código Orquídea</th>
                <th>Participante</th>
                <th>Fecha Creación</th>
                <th>Fecha Actualización</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($orquideas && mysqli_num_rows($orquideas) > 0) {
                while ($row = mysqli_fetch_assoc($orquideas)) { ?>
                    <tr>
                        <td><?php echo $row['id_orquidea']; ?></td>
                        <td><?php echo $row['nombre_planta']; ?></td>
                        <td><?php echo $row['origen']; ?></td>
                        <td><?php echo $row['id_grupo']; ?></td>
                        <td><?php echo $row['id_clase']; ?></td>
                        <td><?php echo $row['codigo_orquidea']; ?></td>
                        <td><?php echo $row['id_participante']; ?></td>
                        <td><?php echo $row['fecha_creacion']; ?></td>
                        <td><?php echo $row['fecha_actualizacion']; ?></td>
                    </tr>
            <?php }
            } else { ?>
                <tr>
                    <td colspan="9">No se encontraron orquídeas registradas.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
