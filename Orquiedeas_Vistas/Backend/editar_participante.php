<?php
include 'Conexion_bd.php'; // Ajusta la ruta de conexión a tu configuración

// Verificar si se ha recibido un ID y los datos necesarios
if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['numero_telefonico']) && isset($_POST['direccion']) && isset($_POST['id_tipo']) && isset($_POST['id_departamento']) && isset($_POST['id_municipio']) && isset($_POST['pais']) && isset($_POST['id_aso'])) {
    $id_participante = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['numero_telefonico'];
    $direccion = $_POST['direccion'];
    $tipo = $_POST['id_tipo'];
    $departamento = $_POST['id_departamento'];
    $municipio = $_POST['id_municipio'];
    $pais = $_POST['pais'];
    $asociacion = $_POST['id_aso'];

    // Preparar la consulta para actualizar el participante
    $query = "UPDATE tb_participante SET nombre = ?, numero_telefonico = ?, direccion = ?, id_tipo = ?, id_departamento = ?, id_municipio = ?, pais = ?, id_aso = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vincular los parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "sssiiisii", $nombre, $telefono, $direccion, $tipo, $departamento, $municipio, $pais, $asociacion, $id_participante);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudieron guardar los cambios.']);
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta.']);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
}
