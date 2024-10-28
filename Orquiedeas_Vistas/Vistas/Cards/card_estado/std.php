<?php
include 'conexion.php'; // Ajusta la ruta de conexión

// Capturar el tipo y ID del usuario desde la sesión
$user_type = $_SESSION['user_type'];
$user_id = $_SESSION['user_id'];

// Construir la consulta dependiendo del tipo de usuario
if ($user_type == 5) {
    $query = "
        SELECT 
            o.id_orquidea, 
            o.codigo_orquidea,
            p.nombre AS nombre_participante,
            g.Cod_Grupo,
            g.nombre_grupo,
            c.id_clase,
            CONCAT('Clase: ', c.id_clase) AS clase,
            a.estado 
        FROM tb_orquidea o
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN tb_participante p ON o.id_participante = p.id
        LEFT JOIN tb_almacenadas a ON o.id_orquidea = a.id_orquidea
        WHERE p.id_usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $user_id);
} else {
    $query = "
        SELECT 
            o.id_orquidea, 
            o.codigo_orquidea,
            p.nombre AS nombre_participante,
            g.Cod_Grupo,
            g.nombre_grupo,
            c.id_clase,
            CONCAT('Clase: ', c.id_clase) AS clase,
            a.estado 
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
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="search_participante">Buscar Participante:</label>
            <input type="text" id="search_participante" class="form-control" placeholder="Buscar por participante...">
        </div>
        <div class="col-md-4">
            <label for="search_grupo">Buscar Grupo:</label>
            <input type="text" id="search_grupo" class="form-control" placeholder="Ingresar letra del grupo (Ejemplo: A, B, C...)">
        </div>
        <div class="col-md-4">
            <label for="search_clase">Buscar Clase:</label>
            <input type="text" id="search_clase" class="form-control" placeholder="Buscar por clase...">
        </div>
    </div>

    <div class="card" style="font-size: 0.9rem;">
        <div class="card-header bg-primary text-white">
            <h2 style="font-size: 1.5rem;">Resultados</h2>
        </div>
        <div class="card-body" style="padding: 10px;">
            <table class="table table-bordered table-striped table-sm" id="orquideas_table">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Participante</th>
                        <th>Código Grupo</th>
                        <th>Clase</th>
                        <th>Nombre Grupo</th>
                        <th>Estado</th>
                        <?php if ($user_type != 5) { ?>
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
                            <td class="nombre-participante"><?php echo $row['nombre_participante']; ?></td>
                            <td class="codigo-grupo"><?php echo $row['Cod_Grupo']; ?></td>
                            <td class="clase"><?php echo $row['clase']; ?></td>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchParticipante = document.getElementById('search_participante');
        const searchGrupo = document.getElementById('search_grupo');
        const searchClase = document.getElementById('search_clase');
        const rows = document.querySelectorAll('#orquideas_table tbody tr');

        function filterTable() {
            const participanteValue = searchParticipante.value.toLowerCase();
            const grupoValue = searchGrupo.value.toLowerCase();
            const claseValue = searchClase.value.toLowerCase();

            rows.forEach(row => {
                const participanteText = row.querySelector('.nombre-participante').textContent.toLowerCase();
                const grupoText = row.querySelector('.codigo-grupo').textContent.toLowerCase();
                const claseText = row.querySelector('.clase').textContent.toLowerCase();

                const matchesParticipante = participanteText.includes(participanteValue);
                const matchesGrupo = grupoText.includes(grupoValue);
                const matchesClase = claseText.includes(claseValue);

                row.style.display = matchesParticipante && matchesGrupo && matchesClase ? '' : 'none';
            });
        }

        searchParticipante.addEventListener('input', filterTable);
        searchGrupo.addEventListener('input', filterTable);
        searchClase.addEventListener('input', filterTable);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
