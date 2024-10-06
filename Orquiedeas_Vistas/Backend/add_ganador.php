<?php
// Incluye la conexión a la base de datos
include 'Conexion_bd.php';

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los valores del formulario
    $id_orquidea = $_POST['id_orquidea'];
    $id_categoria = $_POST['id_categoria'];
    $posicion = $_POST['posicion'];
    $empate = $_POST['empate'] ?? 0; // Si no se ha marcado el checkbox, se asigna 0

    // Separa el id_grupo y id_clase del id_categoria
    list($id_grupo, $id_clase) = explode('-', $id_categoria);

    // Prepara la consulta de inserción
    $query = "INSERT INTO tb_ganadores (id_orquidea, id_grupo, id_clase, posicion, empate, fecha_ganador) VALUES (?, ?, ?, ?, ?, NOW())";

    // Prepara la sentencia
    $stmt = mysqli_prepare($conexion, $query);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }

    // Asigna los valores a la sentencia
    mysqli_stmt_bind_param($stmt, 'iiiii', $id_orquidea, $id_grupo, $id_clase, $posicion, $empate);

    // Ejecuta la sentencia
    if (mysqli_stmt_execute($stmt)) {
        // Si la inserción fue exitosa, genera la alerta con SweetAlert y recarga la página
        echo "<script>
                Swal.fire({
                    title: 'Éxito',
                    text: 'Ganador agregado exitosamente.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'http://localhost/Proyecto_Orquidea/Orquiedeas_Vistas/Vistas/juzgamiento.php';
                    }
                });
              </script>";
    } else {
        // Muestra un mensaje de error si la ejecución falla
        echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al agregar el ganador.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
