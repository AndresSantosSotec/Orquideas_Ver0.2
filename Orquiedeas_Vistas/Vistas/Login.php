<?php
// Evitar que se guarden contraseñas en caché
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

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
        // Preparar la consulta SQL para obtener el id_usuario, contrasena y id_tipo_usu
        $query = $conexion->prepare("SELECT id_usuario, contrasena, id_tipo_usu FROM tb_usuarios WHERE correo = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $query->store_result();

        // Verificar si el usuario existe
        if ($query->num_rows === 1) {
            $query->bind_result($user_id, $hashed_password, $user_type);
            $query->fetch();

            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                // Inicio de sesión exitoso, guardar datos en la sesión
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;
                $_SESSION['user_type'] = $user_type; // Captura del id_tipo_usu

                // Redirigir al dashboard
                header('Location: Dashboard.php');
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

    $conexion->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .login-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-image {
            display: none;
        }

        @media (min-width: 768px) {
            .login-image {
                display: block;
                text-align: center;
            }

            .login-image img {
                max-width: 100%;
                height: auto;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <div style="position: absolute; top: 10px; left: 10px; z-index: 1000;">
        <img src="/Orquideas_Ver0.2/Recursos/img/LogoUMG.png" alt="Logo Universidad" style="width: 200px; height: auto;">
    </div>

    <div class="container login-container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="login-box">
                    <h2 class="text-center login-title">Iniciar Sesión</h2>
                    <p class="text-center">Por favor inicia sesión con tu cuenta</p>

                    <?php if (!empty($message)): ?>
                        <div class="error"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>

                    <form action="" method="POST" autocomplete="off">
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

                    <div class="login-links mt-3">
                        <p><a href="registrologin.php">¿No tienes cuenta? Regístrate</a></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 login-image">
                <img src="../../Recursos/img/Logo-fotor-bg-remover-2024090519443.png" alt="Logo de Empresa">
                <p class="logo-text">Asociación Altaverapacense de Orquideología<br>-AAO</p>
            </div>
        </div>
    </div>

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
