<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Imágenes de Orquídeas</title>
</head>
<body>
    <h1>Galería de Imágenes de Orquídeas</h1>
    
    <?php
    // Conexión a la base de datos
    include '../Backend/Conexion_bd.php';

    // Consulta para obtener todas las imágenes
    $query = "SELECT id_orquidea FROM tb_orquidea";
    $result = $conexion->query($query);

    if ($result->num_rows > 0) {
        // Mostrar cada imagen en un <img>
        while ($row = $result->fetch_assoc()) {
            $id_orquidea = $row['id_orquidea'];
            echo '<img src="get_image.php?id=' . $id_orquidea . '" alt="Imagen de Orquídea" style="width:200px;height:auto;margin:10px;">';
        }
    } else {
        echo "No se encontraron imágenes.";
    }

    $conexion->close();
    ?>
</body>
</html>
