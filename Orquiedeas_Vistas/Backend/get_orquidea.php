<?php
include 'Conexion_bd.php';

if (isset($_GET['id'])) {
    $id_orquidea = $_GET['id'];

    // Consulta para obtener los datos de la orquídea
    $query = "SELECT * FROM tb_orquidea WHERE id_orquidea = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_orquidea);
    $stmt->execute();
    $result = $stmt->get_result();
    $orquidea = $result->fetch_assoc();

    // Retornar los datos en formato JSON
    echo json_encode($orquidea);

    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}
?>
