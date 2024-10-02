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
                            <tr id="orquidea_<?php echo $row['id_orquidea']; ?>">
                                <td><?php echo $row['id_orquidea']; ?></td>
                                <td><?php echo $row['nombre_participante']; ?></td>
                                <td><?php echo $row['Cod_Grupo']; ?></td>
                                <td><?php echo $row['clase']; ?></td>
                                <td><?php echo $row['nombre_grupo']; ?></td>
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
                            <td colspan="6" class="text-center">No se encontraron registros.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Contenedor donde se mostrará la vista de "Ver Orquídea" -->
<div id="contenido-principal" class="container mt-3" style="max-width: 60%; margin: 0 auto;">
    <!-- Aquí se cargarán los detalles de la orquídea -->
</div>

<!-- Agregar el script para manejar la eliminación, edición y ver -->
<script>
    // Manejo de la eliminación
    $(document).on('click', '.btn-eliminar', function() {
        var idOrquidea = $(this).data('id'); // Obtener el ID de la orquídea

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
                    url: '../../Backend/eliminar_orquidea.php',
                    type: 'POST',
                    data: {
                        id: idOrquidea
                    },
                    success: function(response) {
                        Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
                        $('#orquidea_' + idOrquidea).remove(); // Eliminar la fila de la tabla
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
        var idOrquidea = $(this).data('id'); // Obtener el ID de la orquídea

        // Cargar la vista de edición en el div "contenido-principal"
        $.ajax({
            url: '../Vistas/Cards/Edit_orquidea.php', // Ruta de la vista de edición
            type: 'GET',
            data: { id_orquidea: idOrquidea }, // Pasar el ID de la orquídea
            success: function(response) {
                // Cargar el contenido en el div principal
                $('#contenido-principal').html(response);
            },
            error: function(err) {
                console.error('Error al cargar la página de edición:', err);
            }
        });
    });

    // Manejo de ver orquídea en un card
    $(document).on('click', '.btn-ver', function() {
        var idOrquidea = $(this).data('id'); // Obtener el ID de la orquídea

        // Realizar la solicitud AJAX para obtener los datos
        $.ajax({
            url: '../Vistas/Cards/ver_orquidea.php', // Ruta del archivo PHP para obtener los datos
            type: 'GET',
            data: { id_orquidea: idOrquidea }, // Enviar el ID de la orquídea
            success: function(response) {
                // Insertar la respuesta en el div "contenido-principal"
                $('#contenido-principal').html(response);
            },
            error: function(err) {
                console.error('Error al obtener los datos de la orquídea:', err);
            }
        });
    });
</script>
