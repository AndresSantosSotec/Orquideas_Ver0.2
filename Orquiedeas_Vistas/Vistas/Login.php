<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../../Recursos/css/EstilosLogin.css">
    <style>
        .error {
            color: #dc3545;
            text-align: center;
        }
        .success {
            color: #28a745;
            text-align: center;
        }
    </style>
</head>
<body>

<?php
// Iniciar la sesión
session_start();
$message = '';

// Conexión a la base de datos
include '../Backend/Conexion_bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y sanitizar los inputs del formulario
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validar que los campos no estén vacíos
    if (!empty($email) && !empty($password)) {
        // Preparar la consulta SQL
        $query = $conexion->prepare("SELECT id_usuario, contrasena FROM tb_usuarios WHERE correo = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $query->store_result();

        // Verificar si el usuario existe
        if ($query->num_rows === 1) {
            $query->bind_result($user_id, $hashed_password);
            $query->fetch();

            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                // Inicio de sesión exitoso
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                header('Location: dashboard.php'); // Redirigir al panel de usuario
                exit();
            } else {
                $message = 'Contraseña incorrecta.';
            }
        } else {
            $message = 'Email no encontrado.';
        }

        $query->close();
    } else {
        $message = 'Por favor, complete todos los campos.';
    }

    // Cerrar la conexión
    $conexion->close();
}
?>

<div class="login-container">
    <!-- Formulario de Login -->
    <div class="login-form">
        <div class="login-box">
            <h2 class="text-center login-title">Iniciar Sesión</h2>
            <p class="text-center">Por favor inicia sesión con tu cuenta</p>

            <!-- Mostrar mensaje de error o éxito -->
            <?php if (!empty($message)): ?>
                <div class="error"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Usuario" required>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" id="password" required>
                        <span class="input-group-text icon-eye" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-login w-100">Iniciar Sesión</button>
            </form>

            <!-- Links adicionales -->
            <div class="login-links">
                <p><a href="#">¿Quieres iniciar sesión como Participante o Usuario?</a></p>
                <p><a href="registrologin.php">¿No tienes cuenta? Regístrate</a></p>
            </div>
        </div>
    </div>

    <!-- Imagen de Login con Logo -->
    <div class="login-image">
        <div class="text-center">
            <img src="../../Recursos/img/Logo-fotor-bg-remover-2024090519443.png" alt="Logo de Empresa">
            <p class="logo-text">Asociación Altaverapacense de Orquideología<br>-AAO</p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
    }
</script>
</body>

</html>
