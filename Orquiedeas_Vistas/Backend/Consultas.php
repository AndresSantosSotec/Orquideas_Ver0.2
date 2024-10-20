<?php
session_start();
include 'Conexion_bd.php';

// Verifica que el id_usuario está disponible en la sesión
if (!isset($_SESSION['user_id'])) {
    die(json_encode(['status' => 'error', 'message' => 'No se encontró el ID del usuario en la sesión']));
}
$id_usuario = $_SESSION['user_id']; // Obtener el ID del usuario de la sesión
// Recibir los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $numero_telefonico = $_POST['numero_telefonico'];
    $direccion = $_POST['direccion'];
    $tipo_participante = $_POST['tipo_participante'];
    $id_aso = isset($_POST['id_aso']) ? $_POST['id_aso'] : null; // Recibir la asociación

    // Si es nacional, obtener el departamento y municipio, y fijar el país como Guatemala
    if ($tipo_participante == '1') {
        $id_departamento = $_POST['id_departamento'];
        $id_municipio = $_POST['id_municipio'];
        $pais = 'Guatemala';
    } else {
        // Si es extranjero, obtener el país y dejar los campos de departamento y municipio como null
        $id_departamento = null;
        $id_municipio = null;
        $pais = $_POST['pais'];
    }

    // Llamar a la función para insertar el participante
    $resultado = insertarParticipante($nombre, $numero_telefonico, $direccion, $tipo_participante, $id_departamento, $id_municipio, $pais, $id_aso, $id_usuario);

    // Enviar una respuesta en formato JSON al frontend
    if ($resultado) {
        echo json_encode(['status' => 'success', 'message' => 'Participante agregado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al agregar el participante']);
    }
}

// Función para insertar un participante en la base de datos
function insertarParticipante($nombre, $numero_telefonico, $direccion, $id_tipo, $id_departamento, $id_municipio, $pais, $id_aso, $id_usuario) {
    global $conexion;

    // Preparar la consulta SQL para insertar los datos
    $query = "INSERT INTO tb_participante (nombre, numero_telefonico, direccion, id_tipo, id_departamento, id_municipio, pais, id_aso, id_usuario, fecha_creacion, fecha_actualizacion) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    // Preparar la sentencia
    $stmt = $conexion->prepare($query);

    // Verificar si se preparó la consulta correctamente
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    // Asociar los parámetros a la consulta
    if (!$stmt->bind_param("sssiiissi", $nombre, $numero_telefonico, $direccion, $id_tipo, $id_departamento, $id_municipio, $pais, $id_aso, $id_usuario)) {
        die(json_encode(['status' => 'error', 'message' => 'Error en bind_param: ' . $stmt->error]));
    }

    // Ejecutar la consulta y devolver el resultado
    $resultado = $stmt->execute();
    $stmt->close();

    return $resultado;
}
?>
