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
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        .login-container {
            display: flex;
            height: 100vh;
        }

        .login-form {
            width: 50%;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        .login-image {
            width: 50%;
            background-color: #0043a4;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-image img {
            max-width: 80%;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
        }

        .form-control {
            height: 45px;
            font-size: 1.1rem;
        }

        .btn-login {
            background-color: #0043a4;
            color: #fff;
            font-size: 1.2rem;
            height: 45px;
        }

        .btn-login:hover {
            background-color: #003183;
        }

        .input-group-text {
            background-color: #0043a4;
            color: #fff;
        }

        .form-control:focus {
            border-color: #0043a4;
            box-shadow: none;
        }

        .icon-eye {
            cursor: pointer;
        }

        .login-title {
            font-size: 2rem;
            color: #0043a4;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-image .logo-text {
            color: #fff;
            font-size: 1.2rem;
            text-align: center;
        }

        .login-links {
            text-align: center;
            margin-top: 20px;
        }

        .login-links a {
            color: #0043a4;
            text-decoration: none;
            font-weight: bold;
        }

        .login-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Formulario de Login -->
    <div class="login-form">
        <div class="login-box">
            <h2 class="text-center login-title">Iniciar Sesión</h2>
            <p class="text-center">Por favor inicia sesión con tu cuenta</p>
            <form action="#" method="POST">
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="email" class="form-control" placeholder="Usuario" required>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" placeholder="Contraseña" id="password" required>
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
                <p><a href="#">¿No tienes cuenta? Regístrate</a></p>
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
