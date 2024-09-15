<?php
// Conexión a la base de datos
include '../Backend/Conexion_bd.php';

// Verifica si el ID ha sido proporcionado
if (isset($_GET['id'])) {
    $id_orquidea = intval($_GET['id']);
    
    // Consulta para obtener la imagen
    $query = "SELECT foto FROM tb_orquidea WHERE id_orquidea = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_orquidea);
    $stmt->execute();
    $stmt->bind_result($foto);
    $stmt->fetch();
    $stmt->close();

    // Ruta completa de la imagen
    $image_path = '../../Recursos/img/Saved_images/Images/' . $foto;

    // Verifica si el archivo existe
    if (file_exists($image_path)) {
        // Obtén el tipo de contenido
        $info = getimagesize($image_path);
        $content_type = $info['mime'];
        
        // Establecer el encabezado del contenido
        header("Content-Type: $content_type");

        // Leer la imagen
        readfile($image_path);
    } else {
        echo "Imagen no encontrada.";
    }
} else {
    echo "No se proporcionó un ID válido.";
}
