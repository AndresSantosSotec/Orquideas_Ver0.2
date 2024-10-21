<?php
if (isset($_GET['mensaje'])) {
    if ($_GET['mensaje'] == 'eliminado') {
        echo '<div class="alert alert-success">Ganador eliminado exitosamente.</div>';
    } elseif ($_GET['mensaje'] == 'error') {
        echo '<div class="alert alert-danger">Error al intentar eliminar el ganador.</div>';
    }
}



// Validar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Consultar los ganadores

$query = "
    SELECT 
        g.id_ganador, 
        o.nombre_planta AS nombre_orquidea, 
        gr.nombre_grupo AS nombre_grupo, 
        c.nombre_clase AS nombre_clase, 
        g.posicion, 
        g.empate, 
        g.fecha_ganador
    FROM tb_ganadores g
    INNER JOIN tb_orquidea o ON g.id_orquidea = o.id_orquidea
    INNER JOIN grupo gr ON g.id_grupo = gr.id_grupo
    INNER JOIN clase c ON g.id_clase = c.id_clase";


$ganadores = mysqli_query($conexion, $query);

// Verificar si la consulta tiene errores
if (!$ganadores) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
    <!-- Resultados -->
    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Ganadores Registrados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <a href="Add_ganador.php" class="btn btn-dark mb-3">+ Agregar Nuevo Ganador</a>
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Ganador</th>
                        <th>Nombre Orquídea</th>
                        <th>Grupo</th>
                        <th>Clase</th>
                        <th>Posición</th>
                        <th>Empate</th>
                        <th>Fecha de Ganador</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($ganadores && mysqli_num_rows($ganadores) > 0) {
                        while ($row = mysqli_fetch_assoc($ganadores)) { ?>
                            <tr id="ganador_<?php echo $row['id_ganador']; ?>">
                                <td><?php echo $row['id_ganador']; ?></td>
                                <td><?php echo $row['nombre_orquidea']; ?></td>
                                <td><?php echo $row['nombre_grupo']; ?></td>
                                <td><?php echo $row['nombre_clase']; ?></td>
                                <td><?php echo $row['posicion']; ?></td>
                                <td><?php echo $row['empate']; ?></td>
                                <td><?php echo $row['fecha_ganador']; ?></td>
                                <td>
                                    <!-- Botón de Editar -->
                                    <button type="button" class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $row['id_ganador']; ?>" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="#" class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $row['id_ganador']; ?>">🗑️</a>
                                </td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">No se encontraron registros.</td>
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
    // Manejo de la eliminación de ganadores
    $(document).on('click', '.btn-eliminar', function() {
        var idGanador = $(this).data('id'); // Obtener el ID del ganador

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
                    url: '../Backend/eliminar_ganador.php',
                    type: 'POST',
                    data: { id: idGanador },
                    success: function(response) {
                        var jsonResponse = JSON.parse(response); // Convertir la respuesta JSON
                        if (jsonResponse.status === 'success') {
                            Swal.fire(
                                'Eliminado!',
                                'El ganador ha sido eliminado.',
                                'success'
                            );
                            $('#ganador_' + idGanador).remove(); // Eliminar la fila de la tabla
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

    // Manejo de la edición
    $(document).on('click', '.btn-editar', function() {
        var idGanador = $(this).data('id'); // Obtener el ID del ganador

        // Cargar la vista de edición en el div "contenido-principal"
        $.ajax({
            url: '../Vistas/Cards/Edit_ganador.php', // Ruta de la vista de edición
            type: 'GET',
            data: { id: idGanador }, // Pasar el ID del ganador
            success: function(response) {
                // Cargar el contenido en el div principal
                $('#contenido-principal').html(response);
            },
            error: function(err) {
                console.error('Error al cargar la página de edición:', err);
            }
        });
    });
</script>
