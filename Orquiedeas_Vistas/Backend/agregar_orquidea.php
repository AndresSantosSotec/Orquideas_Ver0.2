<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../Backend/Conexion_bd.php';
require '../../vendor/autoload.php'; // Asegúrate de ajustar esta ruta según tu estructura

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica si todos los campos obligatorios están presentes
        if (empty($_POST['nombre_planta']) || empty($_POST['origen']) || empty($_POST['id_participante']) || empty($_POST['id_grupo']) || empty($_POST['id_clase']) || !isset($_POST['hibrida'])) {
            throw new Exception('Todos los campos obligatorios no fueron enviados.');
        }

        // Recibir los datos del formulario
        $nombre_planta = $_POST['nombre_planta'];
        $origen = $_POST['origen'];
        $id_participante = (int)$_POST['id_participante'];
        $id_grupo = (int)$_POST['id_grupo'];
        $id_clase = (int)$_POST['id_clase'];
        $hibrida = (int)$_POST['hibrida'];

        // Generar el código de orquídea basado en la fecha y hora
        $codigo_orquidea = date('YmdHis');

        // Manejar la imagen si se ha subido
        $foto = null;
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
            // Validar el tipo de archivo
            $allowed_extensions = ['jpg', 'jpeg', 'png'];
            $foto_extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);

            if (!in_array($foto_extension, $allowed_extensions)) {
                throw new Exception('Formato de imagen no permitido.');
            }

            // Generar un nombre único para la imagen
            $foto_nuevo_nombre = $codigo_orquidea . '.' . $foto_extension;
            
            // Asegurarse de que la carpeta existe
            $foto_destino = '../../Recursos/img/Saved_images/Images/' . $foto_nuevo_nombre;
            if (!is_dir('../../Recursos/img/Saved_images/Images/')) {
                mkdir('../../Recursos/img/Saved_images/Images/', 0777, true); // Crear directorios si no existen
            }

            // Mover la imagen al destino
            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_destino)) {
                throw new Exception('Error al subir la imagen.');
            }

            // Guardar el nombre de la imagen en la base de datos
            $foto = $foto_nuevo_nombre;
        }

        // Generar el código QR basado en el código de la orquídea
        $qr_filename = $codigo_orquidea . '_qr.png';
        $qr_filepath = '../../Recursos/img/Saved_images/Qr/' . $qr_filename;

        // Asegurarse de que la carpeta QR existe
        if (!is_dir('../../Recursos/img/Saved_images/Qr/')) {
            mkdir('../../Recursos/img/Saved_images/Qr/', 0777, true);
        }

        // Crear el QR con los detalles requeridos
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($codigo_orquidea)  // Puedes cambiar esto por la información que quieras en el QR
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->build();

        // Guardar el código QR en un archivo
        $result->saveToFile($qr_filepath);

        // Insertar los datos en la base de datos
        $query = "INSERT INTO tb_orquidea (nombre_planta, origen, codigo_orquidea, id_participante, id_grupo, id_clase, hibrida, foto, qr_code, fecha_creacion, fecha_actualizacion)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $conexion->prepare($query);

        // Verificar si la consulta está preparada correctamente
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $conexion->error);
        }

        // Asociar los parámetros a la consulta
        $stmt->bind_param("sssiiisss", 
            $nombre_planta, 
            $origen, 
            $codigo_orquidea, 
            $id_participante, 
            $id_grupo, 
            $id_clase, 
            $hibrida, 
            $foto, 
            $qr_filename // Guardar el nombre del archivo QR
        );

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception('Error al registrar la orquídea: ' . $stmt->error);
        }

        // Respuesta exitosa
        echo json_encode([
            'status' => 'success',
            'message' => 'Orquídea registrada correctamente con QR',
        ]);

        $stmt->close();
    } else {
        throw new Exception('Método no permitido');
    }
} catch (Exception $e) {
    // Respuesta de error en formato JSON
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ]);
}
?>
