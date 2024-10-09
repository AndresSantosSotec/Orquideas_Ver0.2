<?php
include 'Conexion_bd.php'; // Ajusta la ruta de conexión a tu configuración


// Verificar si se ha recibido un ID y los datos necesarios
if (isset($_POST['id_ganador']) && isset($_POST['id_orquidea']) && isset($_POST['id_categoria']) && isset($_POST['posicion'])) {
    $id_ganador = $_POST['id_ganador'];
    $id_orquidea = $_POST['id_orquidea'];
    
    // Separar id_grupo y id_clase de la categoría
    $id_categoria = $_POST['id_categoria'];
    list($id_grupo, $id_clase) = explode("-", $id_categoria); // Separar id_grupo y id_clase
    
    $posicion = $_POST['posicion'];
    $empate = isset($_POST['empate']) ? 1 : 0; // Si no está marcado, será 0.

    // Preparar la consulta para actualizar el ganador
    $query = "UPDATE tb_ganadores SET id_orquidea = ?, id_grupo = ?, id_clase = ?, posicion = ?, empate = ? WHERE id_ganador = ?";

    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vincular los parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "iiiiii", $id_orquidea, $id_grupo, $id_clase, $posicion, $empate, $id_ganador);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudieron guardar los cambios.']);
        }

        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta.']);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos.']);
}
