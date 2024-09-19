<?php
// Conexión a la base de datos
include '../Backend/Conexion_bd.php';

// Consulta para obtener todas las imágenes
$query = "SELECT id_orquidea, foto FROM tb_orquidea";
$result = $conexion->query($query);

// Verifica si hay resultados
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_orquidea = $row['id_orquidea'];
        $foto = $row['foto'];

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
            echo "Imagen no encontrada para la orquídea con ID: " . $id_orquidea . "<br>";
        }
    }
} else {
    echo "No se encontraron imágenes.";
}

$conexion->close();
?>
