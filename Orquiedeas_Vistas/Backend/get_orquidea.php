<?php
include 'Conexion_bd.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id_orquidea = mysqli_real_escape_string($conexion, $_GET['id']);
    
    // Consulta para obtener los datos de la orquídea
    $query = "SELECT * FROM tb_orquidea WHERE id_orquidea = '$id_orquidea'";
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $orquidea = mysqli_fetch_assoc($result);
        echo json_encode($orquidea); // Devolver los datos en formato JSON
    } else {
        echo json_encode(['error' => 'No se encontraron datos.']);
    }
}
?>
