<?php
// Incluye la conexión a la base de datos
include 'Conexion_bd.php';

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los valores del formulario
    $id_orquidea = $_POST['id_orquidea'];
    $estado = $_POST['estado'];
    $motivo = $_POST['motivo'] ?? ''; // Si no se ha ingresado motivo, se asigna una cadena vacía

    // Prepara la consulta de inserción
    $query = "INSERT INTO tb_almacenadas (id_orquidea, estado, motivo) 
              VALUES (?, ?, ?)"; // Se agregó NOW() para registrar la fecha de cambio de estado

    // Prepara la sentencia
    $stmt = mysqli_prepare($conexion, $query);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Asigna los valores a la sentencia
    mysqli_stmt_bind_param($stmt, 'iss', $id_orquidea, $estado, $motivo);

    // Ejecuta la sentencia
    if (mysqli_stmt_execute($stmt)) {
        // Si la inserción fue exitosa, genera la alerta con Bootstrap
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Estado de la orquídea agregado exitosamente.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";

        // Recargar la página después de 3 segundos
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../Vistas/estado.php';
                }, 3000); // 3 segundos
              </script>";
    } else {
        // Muestra un mensaje de error si la ejecución falla
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                Hubo un problema al agregar el estado.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estado de Orquídea</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Contenido del cuerpo de la página -->
    
    <!-- Bootstrap JS y Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
