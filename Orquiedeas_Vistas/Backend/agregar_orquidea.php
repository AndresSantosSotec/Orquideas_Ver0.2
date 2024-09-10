<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Backend/Conexion_bd.php';

header('Content-Type: application/json'); // Asegúrate de que la respuesta sea JSON

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre_planta = $_POST['nombre_planta'];
        $especie = $_POST['especie'];
        $origen = $_POST['origen'];
        $id_participante = $_POST['id_participante'];

        // Generar el código de orquídea basado en la fecha y hora
        $codigo_orquidea = date('YmdHis');

        // Insertar los datos en la base de datos
        $query = "INSERT INTO tb_orquidea (nombre_planta, especie, origen, codigo_orquidea, id_participante, fecha_creacion, fecha_actualizacion)
                  VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conexion->prepare($query);

        // Verificar si la consulta está preparada correctamente
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
        }

        // Asociar los parámetros a la consulta
        $stmt->bind_param("sssii", 
            $nombre_planta, 
            $especie, 
            $origen, 
            $codigo_orquidea, 
            $id_participante
        );

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception('Error al registrar la orquídea: ' . $stmt->error);
        }

        // Si todo fue exitoso
        echo json_encode([
            'status' => 'success',
            'message' => 'Orquídea registrada correctamente',
        ]);

        $stmt->close();
    } else {
        throw new Exception('Método no permitido');
    }
} catch (Exception $e) {
    // En caso de error, siempre devolver un JSON
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ]);
}
?>