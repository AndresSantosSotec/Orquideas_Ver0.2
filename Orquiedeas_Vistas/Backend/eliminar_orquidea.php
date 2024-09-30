<?php
include 'Conexion_bd.php';

if (isset($_POST['id'])) {
    $id_orquidea = $_POST['id'];

    // Ejecutar la consulta de eliminación
    $query = "DELETE FROM tb_orquidea WHERE id_orquidea = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_orquidea);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el registro.']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID no recibido.']);
}
?>
