<?php
include 'conexion.php'; // Conexión a la base de datos

if (isset($_GET['id_orquidea'])) {
    $id_orquidea = $_GET['id_orquidea'];

    // Consultar los detalles de la orquídea
    $query = "
        SELECT 
            o.id_orquidea, 
            o.codigo_orquidea,
            a.estado,
            a.motivo
        FROM tb_orquidea o
        LEFT JOIN tb_almacenadas a ON o.id_orquidea = a.id_orquidea
        WHERE o.id_orquidea = '$id_orquidea'
    ";

    $resultado = mysqli_query($conexion, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $orquidea = mysqli_fetch_assoc($resultado);

        // Devolver los datos en formato JSON
        echo json_encode($orquidea);
    } else {
        echo json_encode(['error' => 'No se encontraron datos']);
    }
}
?>
