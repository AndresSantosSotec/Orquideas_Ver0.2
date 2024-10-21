<?php
session_start();
include 'Conexion_bd.php';

$id_usuario = $_SESSION['user_id']; // Obtener ID del usuario
$user_type = $_SESSION['user_type']; // Obtener tipo del usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si la solicitud es para comprobar registro existente
    if (isset($_POST['check_registro'])) {
        $query = "SELECT COUNT(*) as total FROM tb_participante WHERE id_usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()['total'];

        echo json_encode(['hasRegistro' => $total > 0]);
        exit;
    }

    // Verificar si el usuario es tipo 5 y ya tiene un registro
    if ($user_type == 5) {
        $query = "SELECT COUNT(*) as total FROM tb_participante WHERE id_usuario = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $total = $result->fetch_assoc()['total'];
        $stmt->close();

        if ($total > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Solo puedes registrar un participante.']);
            exit;
        }
    }

    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $numero_telefonico = $_POST['numero_telefonico'];
    $direccion = $_POST['direccion'];
    $tipo_participante = $_POST['tipo_participante'];
    $id_aso = isset($_POST['id_aso']) ? $_POST['id_aso'] : null;

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
    $resultado = insertarParticipante(
        $nombre, $numero_telefonico, $direccion, $tipo_participante, 
        $id_departamento, $id_municipio, $pais, $id_aso, $id_usuario
    );

    // Enviar una respuesta en formato JSON al frontend
    if ($resultado) {
        echo json_encode(['status' => 'success', 'message' => 'Participante agregado correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al agregar el participante']);
    }
}

// Función para insertar un participante en la base de datos
function insertarParticipante(
    $nombre, $numero_telefonico, $direccion, $id_tipo, 
    $id_departamento, $id_municipio, $pais, $id_aso, $id_usuario
) {
    global $conexion;

    $query = "INSERT INTO tb_participante 
              (nombre, numero_telefonico, direccion, id_tipo, id_departamento, 
               id_municipio, pais, id_aso, id_usuario, fecha_creacion, fecha_actualizacion) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("sssiiissi", $nombre, $numero_telefonico, $direccion, 
                      $id_tipo, $id_departamento, $id_municipio, $pais, 
                      $id_aso, $id_usuario);

    $resultado = $stmt->execute();
    $stmt->close();

    return $resultado;
}
?>
