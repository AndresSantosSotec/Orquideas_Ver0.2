<?php
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'eliminado') {
        echo '<div class="alert alert-success">Participante eliminado exitosamente.</div>';
    } elseif ($_GET['mensaje'] == 'error') {
        echo '<div class="alert alert-danger">Error al intentar eliminar el participante.</div>';
    }
}

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
            <a href="Registro_usuario.php" class="btn btn-dark mb-3">+ Agregar Nuevo Participante</a>
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
                            <tr id="participante_<?php echo $row['id']; ?>">
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['numero_telefonico']; ?></td>
                                <td><?php echo $row['direccion']; ?></td>
                                <td><?php echo $row['nombre_departamento']; ?></td>
                                <td><?php echo $row['nombre_municipio']; ?></td>
                                <td><?php echo $row['pais']; ?></td>
                                <td><?php echo $row['nombre_asociacion']; ?></td>
                                <td>
                                    <a href="editar_participante.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">✏️</a>
                                    <a href="#" class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $row['id']; ?>">🗑️</a>
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

<!-- Incluir la librería de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Manejo de la eliminación de participantes
    $(document).on('click', '.btn-eliminar', function() {
        var idParticipante = $(this).data('id'); // Obtener el ID del participante

        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, realizar la eliminación con AJAX
                $.ajax({
                    url: '../Backend/eliminar_participante.php',
                    type: 'POST',
                    data: { id: idParticipante },
                    success: function(response) {
                        var jsonResponse = JSON.parse(response); // Convertir la respuesta JSON
                        if (jsonResponse.status === 'success') {
                            Swal.fire(
                                'Eliminado!',
                                'El participante ha sido eliminado.',
                                'success'
                            );
                            $('#participante_' + idParticipante).remove(); // Eliminar la fila de la tabla
                        } else {
                            Swal.fire('Error!', jsonResponse.message, 'error');
                        }
                    },
                    error: function(err) {
                        Swal.fire('Error!', 'No se pudo eliminar el registro.', 'error');
                    }
                });
            }
        });
    });
</script>
