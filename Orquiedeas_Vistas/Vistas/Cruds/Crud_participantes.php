<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

// Validar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consultar los participantes
$query = "
    SELECT 
        p.id, 
        p.nombre, 
        p.numero_telefonico, 
        p.direccion, 
        d.nombre_departamento, 
        m.nombre_municipio, 
        p.pais, 
        a.Clase AS nombre_asociacion
    FROM tb_participante p
    INNER JOIN tb_departamento d ON p.id_departamento = d.id_departamento
    INNER JOIN tb_municipio m ON p.id_municipio = m.id_municipio
    INNER JOIN tb_aso a ON p.id_aso = a.id_aso";

$participantes = mysqli_query($conexion, $query);

// Verificar si la consulta tiene errores
if (!$participantes) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
    <!-- Resultados -->
    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Participantes Registrados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <a href="nuevo_participante.php" class="btn btn-dark mb-3">+ Agregar Nuevo Participante</a>
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Departamento</th>
                        <th>Municipio</th>
                        <th>País</th>
                        <th>Asociación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($participantes && mysqli_num_rows($participantes) > 0) {
                        while ($row = mysqli_fetch_assoc($participantes)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['numero_telefonico']; ?></td>
                                <td><?php echo $row['direccion']; ?></td>
                                <td><?php echo $row['nombre_departamento']; ?></td>
                                <td><?php echo $row['nombre_municipio']; ?></td>
                                <td><?php echo $row['pais']; ?></td>
                                <td><?php echo $row['nombre_asociacion']; ?></td> <!-- Alias para 'Clase' -->
                                <td>
                                    <a href="editar_participante.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">✏️</a>
                                    <a href="eliminar_participante.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">🗑️</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="9" class="text-center">No se encontraron registros.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

