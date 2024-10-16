<?php
// Incluir la conexión a la base de datos
include 'Conexion_bd.php'; // Ajusta la ruta de conexión

// Verificar si se ha recibido un ID por POST
if (isset($_POST['id'])) {
    $id_trofeo = $_POST['id'];

    // Validar la conexión
    if (!$conexion) {
        echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos.']);
        exit;
    }

    // Preparar la consulta para eliminar el participante
    $query = "DELETE FROM tb_trofeo WHERE id_trofeo = ?";

    // Preparar la declaración para evitar inyecciones SQL
    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vincular el ID al parámetro de la consulta
        mysqli_stmt_bind_param($stmt, "i", $id_trofeo);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Enviar respuesta de éxito
            echo json_encode(['status' => 'success']);
        } else {
            // Enviar respuesta de error
            echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el registro.']);
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        // Enviar respuesta de error
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la declaración.']);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Enviar respuesta de error si no se recibe un ID
    echo json_encode(['status' => 'error', 'message' => 'ID no recibido.']);
}
