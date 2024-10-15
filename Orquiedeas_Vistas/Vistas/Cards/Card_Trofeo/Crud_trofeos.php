<?php
include '../../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

// Consultar los trofeos con INNER JOIN a grupo y clase para obtener los nombres
$query = "
    SELECT 
        t.id_trofeo, 
        t.id_orquidea, 
        o.nombre_planta, 
        t.id_clase, 
        t.id_grupo, 
        g.nombre_grupo, 
        c.nombre_clase, 
        t.categoria, 
        t.fecha_ganador
    FROM tb_trofeo t
    INNER JOIN tb_orquidea o ON t.id_orquidea = o.id_orquidea
    LEFT JOIN grupo g ON t.id_grupo = g.id_grupo
    LEFT JOIN clase c ON t.id_clase = c.id_clase";

$trofeos = mysqli_query($conexion, $query);
?>

<div class="container mt-3" style="max-width: 80%; margin: 0 auto;">
    <!-- Resultados -->
    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Trofeos Asignados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <a href="#" data-target="desig_trofeo.php" class="btn btn-dark mb-3">+ Asignar Nuevo Trofeo</a>
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID Trofeo</th>
                        <th>Orquídea</th>
                        <th>Clase</th>
                        <th>Grupo</th>
                        <th>Categoría</th>
                        <th>Fecha de Asignación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($trofeos && mysqli_num_rows($trofeos) > 0) {
                        while ($row = mysqli_fetch_assoc($trofeos)) { ?>
                            <tr id="trofeo_<?php echo $row['id_trofeo']; ?>">
                                <td><?php echo $row['id_trofeo']; ?></td>
                                <td><?php echo $row['nombre_planta']; ?></td>
                                <td><?php echo $row['nombre_clase']; ?></td>
                                <td><?php echo $row['nombre_grupo']; ?></td>
                                <td><?php echo $row['categoria']; ?></td>
                                <td><?php echo $row['fecha_ganador']; ?></td>
                                <td>
                                    
                                    <!-- Botón de Eliminar -->
                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $row['id_trofeo']; ?>" title="Eliminar">
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

<!-- Contenedor donde se mostrará la vista de "Ver Trofeo" -->
<div id="contenido-principal" class="container mt-3" style="max-width: 80%; margin: 0 auto;">
    <!-- Aquí se cargarán los detalles del trofeo -->
</div>

<!-- Agregar el script para manejar la eliminación, edición y ver -->
<script>
    // Manejo de la eliminación
    $(document).on('click', '.btn-eliminar', function() {
        var idTrofeo = $(this).data('id'); // Obtener el ID del trofeo

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
                        url: '../../Orquiedeas_Vistas/Backend/eliminar_trofeo.php',  // Ruta relativa
                        type: 'POST',
                        data: {
                            id: idTrofeo
                        },
                        success: function(response) {
                            Swal.fire('Eliminado!', 'El trofeo ha sido eliminado.', 'success');
                            $('#trofeo_' + idTrofeo).remove(); // Eliminar la fila de la tabla
                        },
                        error: function(err) {
                            Swal.fire('Error!', 'No se pudo eliminar el trofeo.', 'error');
                        }
                    });
            }
        });
    });

    // Manejo de la edición
    $(document).on('click', '.btn-editar', function() {
        var idTrofeo = $(this).data('id'); // Obtener el ID del trofeo

        // Cargar la vista de edición en el div "contenido-principal"
        $.ajax({
            url: '../Vistas/Cards/Edit_trofeo.php', // Ruta de la vista de edición
            type: 'GET',
            data: { id_trofeo: idTrofeo }, // Pasar el ID del trofeo
            success: function(response) {
                // Cargar el contenido en el div principal
                $('#contenido-principal').html(response);
            },
            error: function(err) {
                console.error('Error al cargar la página de edición:', err);
            }
        });
    });

    // Manejo de ver trofeo en un card
    $(document).on('click', '.btn-ver', function() {
        var idTrofeo = $(this).data('id'); // Obtener el ID del trofeo

        // Realizar la solicitud AJAX para obtener los datos
        $.ajax({
            url: '../Vistas/Cards/ver_trofeo.php', // Ruta del archivo PHP para obtener los datos
            type: 'GET',
            data: { id_trofeo: idTrofeo }, // Enviar el ID del trofeo
            success: function(response) {
                // Insertar la respuesta en el div "contenido-principal"
                $('#contenido-principal').html(response);
            },
            error: function(err) {
                console.error('Error al obtener los datos del trofeo:', err);
            }
        });
    });
</script>
