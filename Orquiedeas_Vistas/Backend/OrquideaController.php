<?php
require_once 'Conexion_bd.php';
require_once '../../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class OrquideaController
{
    private $db;

    public function __construct($conexion)
    {
        $this->db = $conexion;
    }

    public function add(array $data, array $files)
    {
        if (empty($data['nombre_planta']) || empty($data['origen']) || empty($data['id_participante']) || empty($data['id_grupo']) || empty($data['id_clase'])) {
            throw new Exception('Todos los campos obligatorios no fueron enviados.');
        }

        $nombre_planta   = $data['nombre_planta'];
        $origen          = $data['origen'];
        $id_participante = (int)$data['id_participante'];
        $id_grupo        = (int)$data['id_grupo'];
        $id_clase        = (int)$data['id_clase'];
        $codigo_orquidea = date('YmdHis');

        $foto = null;
        if (isset($files['foto']) && $files['foto']['error'] === 0) {
            $allowed = ['jpg', 'jpeg', 'png'];
            $ext = pathinfo($files['foto']['name'], PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                throw new Exception('Formato de imagen no permitido.');
            }
            $foto_nuevo_nombre = $codigo_orquidea . '.' . $ext;
            $destino = '../../Recursos/img/Saved_images/Images/' . $foto_nuevo_nombre;
            if (!is_dir('../../Recursos/img/Saved_images/Images/')) {
                mkdir('../../Recursos/img/Saved_images/Images/', 0777, true);
            }
            if (!move_uploaded_file($files['foto']['tmp_name'], $destino)) {
                throw new Exception('Error al subir la imagen.');
            }
            $foto = $foto_nuevo_nombre;
        }

        $qr_filename = $codigo_orquidea . '_qr.png';
        $qr_filepath = '../../Recursos/img/Saved_images/Qr/' . $qr_filename;
        if (!is_dir('../../Recursos/img/Saved_images/Qr/')) {
            mkdir('../../Recursos/img/Saved_images/Qr/', 0777, true);
        }
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($codigo_orquidea)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->build();
        $result->saveToFile($qr_filepath);

        $query = "INSERT INTO tb_orquidea (nombre_planta, origen, codigo_orquidea, id_participante, id_grupo, id_clase, foto, qr_code, fecha_creacion, fecha_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception('Error en la preparación de la consulta: ' . $this->db->error);
        }
        $stmt->bind_param('sssiiiss', $nombre_planta, $origen, $codigo_orquidea, $id_participante, $id_grupo, $id_clase, $foto, $qr_filename);
        if (!$stmt->execute()) {
            throw new Exception('Error al registrar la orquídea: ' . $stmt->error);
        }
        $stmt->close();
        echo json_encode(['status' => 'success', 'message' => 'Orquídea registrada correctamente']);
    }

    public function edit(array $data, array $files)
    {
        if (empty($data['id_orquidea'])) {
            throw new Exception('ID de orquídea no proporcionado.');
        }
        $id_orquidea    = (int)$data['id_orquidea'];
        $nombre_planta  = $data['nombre_planta'];
        $origen         = $data['origen'];
        $id_grupo       = (int)$data['id_grupo'];
        $id_clase       = (int)$data['id_clase'];
        $id_participante= (int)$data['id_participante'];
        $foto           = null;
        if (!empty($files['foto']['name'])) {
            $foto = basename($files['foto']['name']);
            $target_file = '../../uploads/' . $foto;
            move_uploaded_file($files['foto']['tmp_name'], $target_file);
        }
        if ($foto) {
            $query = "UPDATE tb_orquidea SET nombre_planta = ?, origen = ?, id_grupo = ?, id_clase = ?, id_participante = ?, foto = ? WHERE id_orquidea = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssiiisi', $nombre_planta, $origen, $id_grupo, $id_clase, $id_participante, $foto, $id_orquidea);
        } else {
            $query = "UPDATE tb_orquidea SET nombre_planta = ?, origen = ?, id_grupo = ?, id_clase = ?, id_participante = ? WHERE id_orquidea = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ssiiii', $nombre_planta, $origen, $id_grupo, $id_clase, $id_participante, $id_orquidea);
        }
        if (!$stmt->execute()) {
            throw new Exception('No se pudo actualizar la orquídea.');
        }
        $stmt->close();
        echo json_encode(['status' => 'success']);
    }

    public function delete(int $id)
    {
        $stmt = $this->db->prepare('DELETE FROM tb_orquidea WHERE id_orquidea = ?');
        $stmt->bind_param('i', $id);
        if (!$stmt->execute()) {
            throw new Exception('No se pudo eliminar el registro.');
        }
        $stmt->close();
        echo json_encode(['status' => 'success']);
    }

    public function get(int $id)
    {
        $stmt = $this->db->prepare('SELECT * FROM tb_orquidea WHERE id_orquidea = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        echo json_encode($result->fetch_assoc());
        $stmt->close();
    }

    public function details(int $id)
    {
        $query = "SELECT o.id_orquidea, o.nombre_planta, o.id_clase, c.nombre_clase, o.id_grupo, g.nombre_grupo, p.nombre AS nombre_participante FROM tb_orquidea o INNER JOIN clase c ON o.id_clase = c.id_clase INNER JOIN grupo g ON o.id_grupo = g.id_grupo INNER JOIN tb_participante p ON o.id_participante = p.id WHERE o.id_orquidea = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            throw new Exception('Error en la consulta SQL.');
        }
        $stmt->bind_param('i', $id);
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
            throw new Exception('No se encontraron datos para esta orquídea.');
        }
        $stmt->close();
    }
}

header('Content-Type: application/json');
$action = $_REQUEST['action'] ?? '';
$controller = new OrquideaController($conexion);

try {
    switch ($action) {
        case 'add':
            $controller->add($_POST, $_FILES);
            break;
        case 'edit':
            $controller->edit($_POST, $_FILES);
            break;
        case 'delete':
            if (!isset($_POST['id'])) {
                throw new Exception('ID no recibido.');
            }
            $controller->delete((int)$_POST['id']);
            break;
        case 'get':
            if (!isset($_GET['id'])) {
                throw new Exception('ID no proporcionado');
            }
            $controller->get((int)$_GET['id']);
            break;
        case 'details':
            if (!isset($_POST['id_orquidea'])) {
                throw new Exception('ID de orquídea no proporcionado.');
            }
            $controller->details((int)$_POST['id_orquidea']);
            break;
        default:
            throw new Exception('Acción no soportada');
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
