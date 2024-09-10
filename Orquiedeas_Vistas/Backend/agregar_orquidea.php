<?php
include '../Backend/Conexion_bd.php';
require '../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_planta = $_POST['nombre_planta'];
    $especie = $_POST['especie'];
    $origen = $_POST['origen'];
    $id_participante = $_POST['id_participante'];

    // Generar el código de orquídea basado en la fecha y hora
    $codigo_orquidea = date('YmdHis');

    // Verificar que la carpeta de uploads exista
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Subir la imagen de la orquídea
    $foto_orquidea_nombre = basename($_FILES["foto"]["name"]);
    $target_file_orquidea = $target_dir . $foto_orquidea_nombre;
    $imageFileType = strtolower(pathinfo($target_file_orquidea, PATHINFO_EXTENSION));

    // Verificar si es una imagen válida
    $check_orquidea = getimagesize($_FILES["foto"]["tmp_name"]);
    if ($check_orquidea === false) {
        echo json_encode(['status' => 'error', 'message' => 'El archivo de la orquídea no es una imagen válida']);
        exit;
    }

    // Mover la imagen de la orquídea subida al servidor
    if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_orquidea)) {
        echo json_encode(['status' => 'error', 'message' => 'Hubo un error al subir la imagen de la orquídea']);
        exit;
    }

    try {
        // Directorio donde se guardarán los QR
        $qr_dir = "../descargas/";

        // Asegúrate de que la carpeta de descargas exista
        if (!is_dir($qr_dir)) {
            mkdir($qr_dir, 0777, true);
        }

        // Generar el código QR
        $qr_text = "Orquídea: $nombre_planta, Código: $codigo_orquidea";
        $qr_filename = $qr_dir . 'qr_' . $codigo_orquidea . '.png';

        // Crear el código QR usando Endroid QR Code con el Builder
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qr_text)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->size(300)
            ->margin(10)
            ->build();

        // Guardar el código QR como imagen
        $result->saveToFile($qr_filename);

        // Insertar los datos en la base de datos
        $query = "INSERT INTO tb_orquidea (nombre_planta, especie, origen, foto, qr_code, codigo_orquidea, id_participante, fecha_creacion, fecha_actualizacion)
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conexion->prepare($query);

        // Verificar si la consulta está preparada correctamente
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }

        // Asociar los parámetros a la consulta
        $stmt->bind_param("ssssssi", $nombre_planta, $especie, $origen, $foto_orquidea_nombre, $qr_filename, $codigo_orquidea, $id_participante);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Respuesta de éxito incluyendo la URL del QR para descargar
            echo json_encode([
                'status' => 'success',
                'message' => 'Orquídea registrada correctamente',
                'qr_url' => $qr_filename // Añadir la URL para descargar el QR
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al registrar la orquídea']);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al generar el código QR: ' . $e->getMessage()]);
    }
}
?>
