<?php
// Incluir la conexión a la base de datos
include '../Backend/Conexion_bd.php';

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Capturar los datos del formulario
    $nombre_usuario = mysqli_real_escape_string($conexion, $_POST['name']);
    $correo = mysqli_real_escape_string($conexion, $_POST['email']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['password']);
    $id_departamento = mysqli_real_escape_string($conexion, $_POST['id_departamento']);
    $id_municipio = mysqli_real_escape_string($conexion, $_POST['id_municipio']);
    $id_aso = mysqli_real_escape_string($conexion, $_POST['id_aso']);
    
    // ID de tipo de usuario siempre será 5
    $id_tipo_usu = 5;

    // Encriptar la contraseña antes de guardarla
    $password_encrypted = password_hash($contrasena, PASSWORD_DEFAULT);

    // Capturar la fecha de registro
    $fecha_registro = date('Y-m-d H:i:s'); // Fecha en formato Año-Mes-Día Hora:Minuto:Segundo
    
    // Verificar si los campos obligatorios no están vacíos
    if (!empty($nombre_usuario) && !empty($correo) && !empty($contrasena) && !empty($id_departamento) && !empty($id_municipio)) {

        // Preparar la consulta SQL para insertar los datos en la tabla
        $sql = "INSERT INTO tb_usuarios (nombre_usuario, correo, contrasena, id_departamento, id_municipio, id_tipo_usu, id_aso, fecha_registro) 
                VALUES ('$nombre_usuario', '$correo', '$password_encrypted', '$id_departamento', '$id_municipio', '$id_tipo_usu', '$id_aso', '$fecha_registro')";

        // Ejecutar la consulta
        if (mysqli_query($conexion, $sql)) {
            $message= "Registro exitoso";
            $messageType="success";
            // Redirigir o mostrar mensaje de éxito
        } else {
            $message= "Error al registrar: " . mysqli_error($conexion);
            $messageType="error";

        }
    } else {
        $message= "Por favor, completa todos los campos obligatorios.";
        $messageType="error";
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
    <style>
        .message-box {
            width: 80%;
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            color: #fff;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }
        .success {
            background-color: #28a745; /* Verde */
        }
        .error {
            background-color: #dc3545; /* Rojo */
        }
    </style>
</head>
<body>
    <div class="message-box <?php echo $messageType; ?>">
        <?php echo $message; ?>
    </div>

    <script>
        // Redirigir después de 3 segundos
        setTimeout(function() {
            window.location.href = '../Vistas/Login.php';
        }, 3000);
    </script>
</body>
</html>
