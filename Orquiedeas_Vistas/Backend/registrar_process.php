<?php
// Incluir la conexión a la base de datos
include '../Backend/Conexion_bd.php';

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capturar los datos del formulario
    $nombre_usuario = mysqli_real_escape_string($conexion, $_POST['name']);
    $correo = mysqli_real_escape_string($conexion, $_POST['email']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['password']);
    $id_departamento = mysqli_real_escape_string($conexion, $_POST['id_departamento']);
    $id_municipio = mysqli_real_escape_string($conexion, $_POST['id_municipio']);
    $id_aso = mysqli_real_escape_string($conexion, $_POST['id_aso']);
    
    $id_tipo_usu = 5; // Tipo de usuario fijo

    // Validar la contraseña por medio de una expresion regular 
    if (!preg_match('/^(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $contrasena)) {
        $message = "Error: La contraseña debe tener al menos 8 caracteres, un número y un carácter especial.";
        $messageType = "error";
    } else {
        // Verificar si el correo ya existe
        $check_email_query = "SELECT correo FROM tb_usuarios WHERE correo = '$correo'";
        $check_email_result = mysqli_query($conexion, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            $message = "Error: El correo ya está registrado.";
            $messageType = "error";
        } else {
            // Encriptar la contraseña
            $password_encrypted = password_hash($contrasena, PASSWORD_DEFAULT);
            $fecha_registro = date('Y-m-d H:i:s'); // Fecha actual

            // Insertar los datos
            $sql = "INSERT INTO tb_usuarios (nombre_usuario, correo, contrasena, id_departamento, id_municipio, id_tipo_usu, id_aso, fecha_registro) 
                    VALUES ('$nombre_usuario', '$correo', '$password_encrypted', '$id_departamento', '$id_municipio', '$id_tipo_usu', '$id_aso', '$fecha_registro')";

            if (mysqli_query($conexion, $sql)) {
                $message = "Registro exitoso";
                $messageType = "success";
            } else {
                $message = "Error al registrar: " . mysqli_error($conexion);
                $messageType = "error";
            }
        }
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Mostrar SweetAlert dependiendo del resultado
        <?php if ($messageType == 'success'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Registro exitoso',
                text: '<?php echo $message; ?>',
                confirmButtonText: 'Iniciar Sesión'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../Vistas/Login.php';
                }
            });
        <?php elseif ($messageType == 'error'): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo $message; ?>',
                confirmButtonText: 'Intentar de nuevo'
                
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../Vistas/registrologin.php';
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>
