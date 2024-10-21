<?php
include '../Backend/Conexion_bd.php';
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: login.php"); // Redirigir al login si no hay sesión activa
    exit;
}

// Capturar el ID del usuario y su tipo desde la sesión
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Consultar los departamentos desde la base de datos
$consu = mysqli_query($conexion, "SELECT `id_departamento`, `nombre_departamento` FROM `tb_departamento`");
$consu1 = mysqli_query($conexion, "SELECT `id_aso`, `clase` FROM `tb_aso`");
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Participante</title>

    <!-- Enlaces a Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Recursos/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>

<body>
    <!-- Sidebar -->
    <?php include '../Vistas/modales/side_usu.php'; ?>

    <!-- Contenido principal -->

    <div id="contenido-principal">
        <?php include '../Vistas/Cards/participante.php'; ?>
    </div>

    <!-- Scripts para el sidebar y los selects dependientes -->
    <script>
        // Detectar cambio en el select de departamento
        $('#departamento').on('change', function() {
            var id_departamento = $(this).val();

            if (id_departamento) {
                $.ajax({
                    type: 'POST',
                    url: '../Backend/get_municipios.php',
                    data: {
                        id_departamento: id_departamento
                    },
                    success: function(response) {
                        $('#municipio').html(response);
                    },
                    error: function() {
                        alert("Error al cargar los municipios");
                    }
                });
            } else {
                $('#municipio').html('<option value="">Selecciona un Municipio</option>');
            }
        });

        // Mostrar/Ocultar campos según si es Nacional o Extranjero
        $('input[name="tipo_participante"]').on('change', function() {
            if ($(this).val() == '1') {
                $('#campos_nacional').show();
                $('#campo_extranjero').hide();
                $('#pais').val('Guatemala');
            } else if ($(this).val() == '2') {
                $('#campos_nacional').hide();
                $('#campo_extranjero').show();
                $('#pais').val('');
            }
        });

        // Validar y bloquear el botón de registro si el usuario tipo 5 ya tiene un registro
        document.addEventListener('DOMContentLoaded', function() {
            const userId = <?php echo json_encode($user_id); ?>;
            const userType = <?php echo json_encode($user_type); ?>;

            console.log("ID del Usuario Conectado:", userId);
            console.log("Tipo de Usuario:", userType);

            if (userType === 5) {
                $.ajax({
                    url: '../Backend/Consultas.php',
                    type: 'POST',
                    data: {
                        check_registro: true
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.hasRegistro) {
                            $('#form-participante button[type="submit"]').prop('disabled', true);
                            Swal.fire({
                                icon: 'info',
                                title: 'Registro limitado',
                                text: 'Solo puedes registrar un participante,.',
                                
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    },
                    error: function() {
                        console.error('Error al verificar el registro del participante.');
                    }
                });
            }
        });

        // Enviar el formulario usando AJAX
        $('#form-participante').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '../Backend/Consultas.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Participante agregado',
                            text: response.message,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = 'Registro_usuario.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            confirmButtonText: 'Aceptar'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo procesar la solicitud',
                        confirmButtonText: 'Aceptar'
                    });
                }
            });
        });

        // Funcionalidad de colapsar y expandir el sidebar
        document.getElementById('toggle-button').addEventListener('click', function() {
            var sidebar = document.getElementById('sidebar');
            var mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');
        });

        // Interceptar el clic en los enlaces del menú y cargar contenido dinámico
        $(document).ready(function() {
            $('ul li a').click(function(e) {
                e.preventDefault();
                var target = $(this).data('target');

                $.ajax({
                    url: target,
                    type: 'GET',
                    success: function(response) {
                        $('#contenido-principal').html(response);
                    },
                    error: function() {
                        alert('Error al cargar el contenido.');
                    }
                });
            });
        });
    </script>

</body>

</html>