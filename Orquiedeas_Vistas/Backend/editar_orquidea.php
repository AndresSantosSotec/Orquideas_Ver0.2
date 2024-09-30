<?php
include 'Conexion_bd.php';

if (isset($_POST['id_orquidea'])) {
    $id_orquidea = $_POST['id_orquidea'];
    $nombre_planta = $_POST['nombre_planta'];
    $origen = $_POST['origen'];
    $id_grupo = $_POST['id_grupo'];
    $id_clase = $_POST['id_clase'];
    $id_participante = $_POST['id_participante'];

    // Si se ha subido una nueva imagen
    $foto = null;
    if (!empty($_FILES['foto']['name'])) {
        $foto = basename($_FILES['foto']['name']);
        $target_file = "../../uploads/" . $foto;
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
    }

    // Actualizar la consulta dependiendo si hay una nueva imagen o no
    if ($foto) {
        $query = "UPDATE tb_orquidea SET nombre_planta = ?, origen = ?, id_grupo = ?, id_clase = ?, id_participante = ?, foto = ? WHERE id_orquidea = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssiiiis", $nombre_planta, $origen, $id_grupo, $id_clase, $id_participante, $foto, $id_orquidea);
    } else {
        $query = "UPDATE tb_orquidea SET nombre_planta = ?, origen = ?, id_grupo = ?, id_clase = ?, id_participante = ? WHERE id_orquidea = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ssiiii", $nombre_planta, $origen, $id_grupo, $id_clase, $id_participante, $id_orquidea);
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar la orquídea.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de orquídea no proporcionado.']);
}
?>
