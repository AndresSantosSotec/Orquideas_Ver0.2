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

if (!$participantes) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Año actual
$year = date('Y');

// Consulta para contar participantes registrados en el año actual
$sql_participantes = "SELECT COUNT(*) AS total_participantes 
                      FROM tb_participante 
                      WHERE YEAR(fecha_creacion) = ?";
$stmt1 = $conexion->prepare($sql_participantes);
$stmt1->bind_param("i", $year);
$stmt1->execute();
$result1 = $stmt1->get_result();
$total_participantes = $result1->fetch_assoc()['total_participantes'];
$stmt1->close();
?>

<!-- Tarjeta de Participantes Registrados -->
<div class="col-md-4" style="position: relative; left: 35%; width: 50%;">
    <div class="card text-white bg-info mb-3">
        <div class="card-header">Participantes Registrados (<?php echo $year; ?>)</div>
        <div class="card-body">
            <h5 class="card-title"><?php echo $total_participantes; ?> Participantes</h5>
        </div>
    </div>
</div>

<!-- Contenedor Principal -->
<div class="container mt-5" style="max-width: 60%; margin: 0 auto;">
    <!-- Filtro de Búsqueda -->
    <div class="form-group mb-3">
        <label for="search_nombre">Buscar por Nombre:</label>
        <input type="text" id="search_nombre" class="form-control" placeholder="Buscar por nombre de participante...">
    </div>

    <!-- Tabla de Participantes -->
    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Participantes Registrados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <a href="Registro_usuario.php" class="btn btn-dark mb-3">+ Agregar Nuevo Participante</a>
            <table class="table table-bordered table-striped table-sm" id="participantes_table">
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
                    if (mysqli_num_rows($participantes) > 0) {
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
                                    <button type="button" class="btn btn-warning btn-sm btn-editar" data-id="<?php echo $row['id']; ?>" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
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
    // Filtro en tiempo real por nombre de participante
    document.getElementById('search_nombre').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#participantes_table tbody tr');

        rows.forEach(row => {
            const nombre = row.cells[1].textContent.toLowerCase(); // Columna de nombre
            row.style.display = nombre.includes(searchValue) ? '' : 'none';
        });
    });

    // Manejo de la eliminación de participantes
    $(document).on('click', '.btn-eliminar', function() {
        var idParticipante = $(this).data('id');

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
                $.ajax({
                    url: '../Backend/eliminar_participante.php',
                    type: 'POST',
                    data: { id: idParticipante },
                    success: function(response) {
                        var jsonResponse = JSON.parse(response);
                        if (jsonResponse.status === 'success') {
                            Swal.fire('Eliminado!', 'El participante ha sido eliminado.', 'success');
                            $('#participante_' + idParticipante).remove();
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
        var idParticipante = $(this).data('id');
        $.ajax({
            url: '../Vistas/Cards/Edit_participante.php',
            type: 'GET',
            data: { id: idParticipante },
            success: function(response) {
                $('#contenido-principal').html(response);
            },
            error: function(err) {
                console.error('Error al cargar la página de edición:', err);
            }
        });
    });
</script>
