<?php
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

if (isset($_GET['id_orquidea'])) {
    $id_orquidea = $_GET['id_orquidea'];

    // Consultar la orquídea específica por su ID
    $query = "
        SELECT 
            o.nombre_planta,
            o.origen,
            o.id_grupo,
            o.id_clase,
            o.id_participante,
            o.foto,
            o.qr_code
        FROM tb_orquidea o
        WHERE o.id_orquidea = '$id_orquidea'";

    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $orquidea = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontraron datos para esta orquídea.";
        exit;
    }
} else {
    echo "ID de orquídea no proporcionado.";
    exit;
}

// Obtener los grupos
$grupos = mysqli_query($conexion, "SELECT id_grupo, nombre_grupo FROM grupo");

// Obtener las clases
$clases = mysqli_query($conexion, "SELECT id_clase, nombre_clase FROM clase");

// Obtener los participantes
$participantes = mysqli_query($conexion, "SELECT id, nombre FROM tb_participante");
?>

<div class="main-content" id="main-content">
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h3><i class="fas fa-leaf"></i> Detalles de la Orquídea</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Nombre de la Planta -->
                    <div class="mb-3 col-md-4">
                        <label for="edit_nombre_planta" class="form-label"><strong>Nombre de la Planta:</strong></label>
                        <p><?php echo $orquidea['nombre_planta']; ?></p>
                    </div>

                    <!-- Origen -->
                    <div class="mb-3 col-md-4">
                        <label for="edit_origen" class="form-label"><strong>Origen:</strong></label>
                        <p><?php echo $orquidea['origen']; ?></p>
                    </div>
                </div>

                <div class="row">
                    <!-- Grupo -->
                    <div class="mb-3 col-md-4">
                        <label for="edit_id_grupo" class="form-label"><strong>Grupo:</strong></label>
                        <?php
                        $grupo = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre_grupo FROM grupo WHERE id_grupo = '" . $orquidea['id_grupo'] . "'"));
                        ?>
                        <p><?php echo $grupo['nombre_grupo']; ?></p>
                    </div>

                    <!-- Clase -->
                    <div class="mb-3 col-md-4">
                        <label for="edit_id_clase" class="form-label"><strong>Clase:</strong></label>
                        <?php
                        $clase = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre_clase FROM clase WHERE id_clase = '" . $orquidea['id_clase'] . "'"));
                        ?>
                        <p><?php echo $clase['nombre_clase']; ?></p>
                    </div>
                </div>

                <div class="mb-3">
                    <!-- Participante -->
                    <label for="edit_id_participante" class="form-label"><strong>Participante:</strong></label>
                    <?php
                    $participante = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre FROM tb_participante WHERE id = '" . $orquidea['id_participante'] . "'"));
                    ?>
                    <p><?php echo $participante['nombre']; ?></p>
                </div>

                <div class="mb-3">
                    <!-- Foto de la orquídea -->
                    <label for="edit_foto" class="form-label"><strong>Foto de la Orquídea:</strong></label><br>
                    <?php if (!empty($orquidea['foto'])) {
                        if (strpos($orquidea['foto'], '/') !== false) {
                            echo '<img src="../../uploads/' . $orquidea['foto'] . '" alt="Foto Orquídea" width="150">';
                        } else {
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($orquidea['foto']) . '" alt="Foto Orquídea" width="150">';
                        }
                    } else { ?>
                        <p>No hay foto disponible.</p>
                    <?php } ?>
                </div>

                <div class="mb-3">
                    <!-- Código QR -->
                    <label for="edit_qr_code" class="form-label"><strong>Código QR:</strong></label><br>
                    <?php if (!empty($orquidea['qr_code'])) {
                        if (strpos($orquidea['qr_code'], '/') !== false) {
                            echo '<img src="../../uploads/' . $orquidea['qr_code'] . '" alt="Código QR" width="150">';
                        } else {
                            echo '<img src="data:image/png;base64,' . base64_encode($orquidea['qr_code']) . '" alt="Código QR" width="150">';
                        }
                    } else { ?>
                        <p>No hay código QR disponible.</p>
                    <?php } ?>
                </div>

                <!-- Botón para descargar PDF -->
                <div class="mb-3">
                    <a href="../Vistas/pdf/descargar_orquidea_pdf.php?id=<?php echo $id_orquidea; ?>" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i> Descargar PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>