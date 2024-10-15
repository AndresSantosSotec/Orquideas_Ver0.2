<?php
include 'Conexion_bd.php'; // Asegúrate de que la ruta sea correcta

if (isset($_POST['id_orquidea'])) {
    $id_orquidea = $_POST['id_orquidea'];

    // Consulta SQL para obtener los datos de la orquídea
    $query = "
        SELECT o.id_orquidea, o.nombre_planta, o.id_clase, c.nombre_clase, o.id_grupo, g.nombre_grupo, p.nombre AS nombre_participante
        FROM tb_orquidea o
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN tb_participante p ON o.id_participante = p.id
        WHERE o.id_orquidea = ?
    ";

    if ($stmt = $conexion->prepare($query)) {
        $stmt->bind_param("i", $id_orquidea);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo json_encode([
                'status' => 'success',
                'id_orquidea' => $row['id_orquidea'],
                'nombre_planta' => $row['nombre_planta'],
                'id_clase' => $row['id_clase'],
                'nombre_clase' => $row['nombre_clase'],
                'id_grupo' => $row['id_grupo'],
                'nombre_grupo' => $row['nombre_grupo'],
                'nombre_participante' => $row['nombre_participante']
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se encontraron datos para esta orquídea.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error en la consulta SQL.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de orquídea no proporcionado.']);
}
?>
