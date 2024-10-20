<?php
// Incluye el archivo de conexión a la base de datos
include 'Conexion_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén los valores enviados desde el formulario
    $id_orquidea = isset($_POST['id_orquidea']) ? $_POST['id_orquidea'] : null;

    // Verifica que el ID de la orquídea no esté vacío
    if ($id_orquidea) {
        // Obtén los datos de clase y grupo de la orquídea seleccionada
        $query_get_data = "SELECT id_clase, id_grupo FROM tb_orquidea WHERE id_orquidea = ?";
        $stmt_get_data = $conexion->prepare($query_get_data);
        $stmt_get_data->bind_param("i", $id_orquidea);
        $stmt_get_data->execute();
        $result_data = $stmt_get_data->get_result();
        
        if ($result_data->num_rows > 0) {
            $row_data = $result_data->fetch_assoc();
            $id_clase = $row_data['id_clase'];
            $id_grupo = $row_data['id_grupo'];
        } else {
            echo "<script>alert('Error al obtener los datos de la orquídea'); window.history.back();</script>";
            exit();
        }

        $categoria = 'Ganador Absoluto'; // Define la categoría

        // Consulta para insertar los datos en la tabla `tb_trofeo`
        $query = "INSERT INTO tb_trofeo (id_orquidea, id_clase, id_grupo, categoria, fecha_ganador) 
                  VALUES (?, ?, ?, ?, NOW())";

        // Prepara la consulta
        if ($stmt = $conexion->prepare($query)) {
            // Vincula los parámetros
            $stmt->bind_param("iiis", $id_orquidea, $id_clase, $id_grupo, $categoria);

            // Ejecuta la consulta
            if ($stmt->execute()) {
                // Muestra un mensaje de éxito y redirige después de 3 segundos
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        Trofeo asignado exitosamente.
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                      </div>";

                echo "<script>
                        setTimeout(function() {
                            window.location.href = '../Vistas/trofeos.php';
                        }, 3000);
                      </script>";
            } else {
                // Muestra un mensaje de error en la ejecución
                echo "<script>alert('Error al asignar el trofeo: " . $conexion->error . "'); window.history.back();</script>";
            }

            // Cierra la sentencia
            $stmt->close();
        } else {
            // Si hay un error al preparar la consulta
            echo "<script>alert('Error preparando la consulta: " . $conexion->error . "'); window.history.back();</script>";
        }
    } else {
        // Si no se ha proporcionado el ID de la orquídea
        echo "<script>alert('Faltan datos obligatorios.'); window.history.back();</script>";
    }
} else {
    // Si la solicitud no es de tipo POST
    echo "<script>alert('Solicitud inválida.'); window.history.back();</script>";
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Trofeo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Contenido del cuerpo de la página -->
    
    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
