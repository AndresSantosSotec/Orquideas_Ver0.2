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
                <p><a href="Registro_usuario.php">¿No tienes cuenta? Regístrate</a></p>
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
