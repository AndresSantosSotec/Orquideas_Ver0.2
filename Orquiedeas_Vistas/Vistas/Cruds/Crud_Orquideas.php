<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión
session_start();

// Capturar el ID y tipo del usuario desde la sesión
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Crear la consulta dependiendo del tipo de usuario
if ($user_type == 5) {
    // Si es usuario tipo 5, mostrar solo las orquídeas registradas por él
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
        INNER JOIN tb_participante p ON o.id_participante = p.id
        WHERE p.id_usuario = ?"; // Filtrar por ID del usuario

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $orquideas = $stmt->get_result();
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
            CONCAT('Clase: ', c.id_clase) AS clase
        FROM tb_orquidea o
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN tb_participante p ON o.id_participante = p.id";

    $orquideas = mysqli_query($conexion, $query);
}
$year = date('Y'); // Año actual

// Lógica para el conteo de orquídeas y la consulta según el tipo de usuario
if ($user_type == 5) {
    // Usuario tipo 5: contar solo sus orquídeas
    $sql_orquideas = "
        SELECT COUNT(*) AS total_orquideas 
        FROM tb_orquidea 
        INNER JOIN tb_participante p ON tb_orquidea.id_participante = p.id
        WHERE YEAR(tb_orquidea.fecha_creacion) = ? AND p.id_usuario = ?";

    $stmt2 = $conexion->prepare($sql_orquideas);
    $stmt2->bind_param("ii", $year, $user_id);
} else {
    // Administrador: contar todas las orquídeas
    $sql_orquideas = "
        SELECT COUNT(*) AS total_orquideas 
        FROM tb_orquidea 
        WHERE YEAR(fecha_creacion) = ?";

    $stmt2 = $conexion->prepare($sql_orquideas);
    $stmt2->bind_param("i", $year);
}

$stmt2->execute();
$result2 = $stmt2->get_result();
$total_orquideas = $result2->fetch_assoc()['total_orquideas'];
$stmt2->close();
?>



<div class="col-md-4" style="position: relative; left: 35%; width: 50%;">
    <div class="card text-white bg-success mb-3">
        <div class="card-header">Orquídeas Registradas (<?php echo $year; ?>)</div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $total_orquideas; ?> Orquídeas</h5>
        </div>
    </div>
</div>
<div class="container mt-3" style="max-width: 60%; margin: 0 auto;">
    <div class="input-group mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
        <select id="searchColumn" class="form-select" style="max-width: 150px;">
            <option value="all">Todos</option>
            <option value="1">Participante</option>
            <option value="2">Código Grupo</option>
            <option value="3">Clase</option>
        </select>
    </div>
</div>


<div class="container mt-5" style="max-width: 60%; margin: 0 auto;">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Resultados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <a href="Nueva_orquidea.php" class="btn btn-dark mb-3">+ Agregar Nuevo Registro</a>
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
                                    <!-- Botón Ver -->
                                    <a href="javascript:void(0)" class="btn btn-info btn-sm btn-ver" data-id="<?php echo $row['id_orquidea']; ?>" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php if ($user_type != 5) { ?>
                                        <!-- Mostrar solo para usuarios que no sean tipo 5 -->
                                        <button type="button" class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $row['id_orquidea']; ?>" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="<?php echo $row['id_orquidea']; ?>" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    <?php } ?>
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
                    url: '../../Orquiedeas_Vistas/Backend/OrquideaController.php?action=delete',
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
            data: {
                id_orquidea: idOrquidea
            }, // Pasar el ID de la orquídea
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
            data: {
                id_orquidea: idOrquidea
            }, // Enviar el ID de la orquídea
            success: function(response) {
                // Insertar la respuesta en el div "contenido-principal"
                $('#contenido-principal').html(response);
            },
            error: function(err) {
                console.error('Error al obtener los datos de la orquídea:', err);
            }
        });
    });
    //intento de manejo de la busqueda por tabla
    document.getElementById('searchInput').addEventListener('input', function() {
        let filter = this.value.toUpperCase();
        let column = document.getElementById('searchColumn').value;
        let rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            let cells = row.querySelectorAll('td');
            let match = false;

            if (column === "all") {
                // Filtrar por toda la fila
                match = Array.from(cells).some(cell =>
                    (cell.textContent || cell.innerText).toUpperCase().indexOf(filter) > -1
                );
            } else {
                // Filtrar por una columna específica
                let cell = cells[column - 1]; // Ajustar índice
                if (cell && (cell.textContent || cell.innerText).toUpperCase().indexOf(filter) > -1) {
                    match = true;
                }
            }

            row.style.display = match ? '' : 'none';
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userType = <?php echo json_encode($_SESSION['user_type']); ?>;
        console.log("Tipo de Usuario:", userType);

        if (userType === 5) {
            console.log("Usuario tipo 5: Mostrando solo sus orquídeas registradas.");
        } else {
            console.log("Administrador: Mostrando todas las orquídeas.");
        }
    });
</script>