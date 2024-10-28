<?php
include '../../../Backend/Conexion_bd.php';

if (isset($_POST['id_orquidea'])) {
    $id_orquidea = $_POST['id_orquidea'];

    // Consulta para obtener el grupo y la clase de la orquídea seleccionada
    $query = "SELECT o.id_grupo, o.id_clase, g.Cod_Grupo, c.nombre_clase 
              FROM tb_orquidea o
              INNER JOIN grupo g ON o.id_grupo = g.id_grupo
              INNER JOIN clase c ON o.id_clase = c.id_clase
              WHERE o.id_orquidea = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_orquidea);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se encontró información.']);
    }

    $stmt->close();
}
?>
