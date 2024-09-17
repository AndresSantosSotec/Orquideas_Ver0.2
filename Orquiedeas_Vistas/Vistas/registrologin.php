
<?php
include '../Backend/Conexion_bd.php';
// Consultar los departamentos desde la base de datos
$consu = mysqli_query($conexion, "SELECT `id_departamento`, `nombre_departamento` FROM `tb_departamento`");
$consu1 = mysqli_query($conexion, "SELECT `id_aso`, `clase` FROM `tb_aso`");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Enlace a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Enlace a FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../../Recursos/css/EstilosLogin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>

    </style>
</head>
<body>

<div class="login-container">
    <!-- Formulario de Registro -->
    <div class="login-form">
        <div class="login-box">
            <h2 class="text-center login-title">Registro</h2>
            <p class="text-center">Por favor llena los siguientes campos para registrarte</p>
            <form action="../Backend/registrar_process.php" method="POST">
                    <!-- Nombre -->
                    <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Nombre Completo" required>
                    </div>
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Correo Electrónico" required>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" id="password" required>
                        <span class="input-group-text icon-eye" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                 <!-- Campos que se mostrarán si es Nacional -->
                 <div id="campos_nacional">
                    <div class="mb-3">
                        <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                        <select class="form-select" id="departamento" name="id_departamento">
                            <option value="">Selecciona un Departamento</option>
                            <!-- PHP para cargar los departamentos -->
                            <?php
                            // Cargar los departamentos de la base de datos
                            while ($row = mysqli_fetch_assoc($consu)) {
                                echo '<option value="' . $row['id_departamento'] . '">' . $row['nombre_departamento'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                 </div>
                 <div class="mb-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <select class="form-select" id="municipio" name="id_municipio">
                            <option value="">Selecciona un Municipio</option>
                        </select>
                     </div>
                </div>
                    <div class="mb-3">
                    <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                        <select class="form-select" id="Asociacion" name="id_aso">
                            <option value="">Selecciona una Asociación</option>
                            <!-- PHP para cargar las asociaciones -->
                            <?php
                            // Cargar las asociaciones de la base de datos 
                            while ($row = mysqli_fetch_assoc($consu1)) {
                                echo '<option value="' . $row['id_aso'] . '">' . $row['clase'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    </div>
                </div>
                <!-- boton de registro -->
                <div class="d-grid">
                 <button type="submit" class="btn btn-login w-100">Registrarse</button>
                </div>
            
                

            <!-- Links adicionales -->
            <div class="login-links">
                <p><a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a></p>
            </div>
        </div>
    </div>

    <!-- Imagen de Registro con Logo -->
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

    // Detectar cambio en el select de departamento
    $('#departamento').on('change', function() {
            var id_departamento = $(this).val();

            // Si se selecciona un departamento, cargar municipios por AJAX
            if (id_departamento) {
                $.ajax({
                    type: 'POST',
                    url: '../Backend/get_municipios.php', // Cambia la ruta según sea necesario
                    data: { id_departamento: id_departamento },
                    success: function(response) {
                        // Asegurarse de que el backend esté devolviendo un <option> válido para el select de municipios
                        $('#municipio').html(response); // Actualiza el select de municipios con los resultados
                    },
                    error: function() {
                        alert("Error al cargar los municipios");
                    }
                });
            } else {
                $('#municipio').html('<option value="">Selecciona un Municipio</option>');
            }
        });



</script>
</body>
</html>
