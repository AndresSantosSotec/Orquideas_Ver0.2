<?php
include '../Backend/Conexion_bd.php';
// Consultar los departamentos desde la base de datos
$consu = mysqli_query($conexion, "SELECT `id_departamento`, `nombre_departamento` FROM `tb_departamento`");
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
    <div class="sidebar" id="sidebar">
        <button class="toggle-button" id="toggle-button">☰</button>
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i> <span>Inicio</span></a></li>
            <li><a href="#"><i class="fas fa-seedling"></i> <span>Registro de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-users"></i> <span>Ver Usuarios</span></a></li>
            <li><a href="Identificar.php"><i class="fas fa-file-alt"></i> <span>Reporte de Usuarios</span></a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content" id="main-content">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-user-plus"></i> Agregar Participante</h3>
                </div>
                <div class="card-body">
                    <form id="form-participante">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="numero_telefonico" class="form-label">Número Telefónico</label>
                            <input type="tel" class="form-control" id="numero_telefonico" name="numero_telefonico" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                        <div class="mb-3">
                            <label for="tipo_participante" class="form-label">Tipo de Participante</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_participante" id="nacional" value="1" required>
                                <label class="form-check-label" for="nacional">Nacional</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo_participante" id="extranjero" value="2" required>
                                <label class="form-check-label" for="extranjero">Extranjero</label>
                            </div>
                        </div>
                        
                        <!-- Campos que se mostrarán si es Nacional -->
                        <div id="campos_nacional">
                            <div class="mb-3">
                                <label for="departamento" class="form-label">Departamento</label>
                                <select class="form-select" id="departamento" name="id_departamento">
                                    <option value="">Selecciona un Departamento</option>
                                    <?php
                                    // Cargar los departamentos de la base de datos
                                    while ($row = mysqli_fetch_assoc($consu)) {
                                        echo '<option value="' . $row['id_departamento'] . '">' . $row['nombre_departamento'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="municipio" class="form-label">Municipio</label>
                                <select class="form-select" id="municipio" name="id_municipio">
                                    <option value="">Selecciona un Municipio</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campo que se mostrará si es Extranjero -->
                        <div id="campo_extranjero" style="display: none;">
                            <div class="mb-3">
                                <label for="pais" class="form-label">País</label>
                                <input type="text" class="form-control" id="pais" name="pais">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Agregar Participante</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para el sidebar y los selects dependientes -->
    <script>
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

        // Mostrar/Ocultar campos según si es Nacional o Extranjero
        $('input[name="tipo_participante"]').on('change', function() {
            if ($(this).val() == '1') {
                $('#campos_nacional').show();
                $('#campo_extranjero').hide();
                $('#pais').val('Guatemala'); // Fijar el país a Guatemala cuando es Nacional
            } else if ($(this).val() == '2') {
                $('#campos_nacional').hide();
                $('#campo_extranjero').show();
                $('#pais').val(''); // Limpiar el campo de país cuando es Extranjero
            }
        });

        // Enviar el formulario usando AJAX
        $('#form-participante').on('submit', function(e) {
            e.preventDefault(); // Prevenir el envío tradicional del formulario

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
                            window.location.href = 'Registro_usuario.php'; // Redirigir a la página de registro
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
    </script>
</body>
</html>
