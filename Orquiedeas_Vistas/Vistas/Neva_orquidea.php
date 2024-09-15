<?php
include '../Backend/Conexion_bd.php';

// Consultar los participantes desde la base de datos
$participantes = mysqli_query($conexion, "SELECT `id`, `nombre` FROM `tb_participante`");
// Consultar los grupos de orquídeas
$grupos = mysqli_query($conexion, "SELECT `id_grupo`, `nombre_grupo` FROM `grupo`");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Orquídea</title>

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
            <li><a href="#"><i class="fas fa-users"></i> <span>Ver Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content" id="main-content">
        <div class="container mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3><i class="fas fa-leaf"></i> Registrar Orquídea</h3>
                </div>
                <div class="card-body">
                    <form id="form-orquidea" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Nombre de la Planta -->
                            <div class="mb-3 col-md-4">
                                <label for="nombre_planta" class="form-label">Nombre de la Planta</label>
                                <input type="text" class="form-control" id="nombre_planta" name="nombre_planta" required>
                            </div>


                            <!-- Origen -->
                            <div class="mb-3 col-md-4">
                                <label for="origen" class="form-label">Origen</label>
                                <select class="form-select" id="origen" name="origen" required>
                                    <option value="">Selecciona el Origen</option>
                                    <option value="Natural">Natural</option>
                                    <option value="Laboratorio">Laboratorio</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Grupo -->
                            <div class="mb-3 col-md-4">
                                <label for="id_grupo" class="form-label">Grupo</label>
                                <select class="form-select" id="id_grupo" name="id_grupo" required>
                                    <option value="">Selecciona un Grupo</option>
                                    <?php
                                    // Llenar el select con los grupos de la base de datos
                                    while ($row = mysqli_fetch_assoc($grupos)) {
                                        echo '<option value="' . $row['id_grupo'] . '">' . $row['nombre_grupo'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Clase asociada (select dinámico) -->
                            <div class="mb-3 col-md-4">
                                <label for="id_clase" class="form-label">Clase</label>
                                <select class="form-select" id="id_clase" name="id_clase" required>
                                    <option value="">Selecciona una Clase</option>
                                </select>
                            </div>

                            <!-- Híbrida (booleano) -->
                            <div class="mb-3 col-md-4">
                                <label for="hibrida" class="form-label">¿Es Híbrida?</label>
                                <select class="form-select" id="hibrida" name="hibrida" required>
                                    <option value="0">No</option>
                                    <option value="1">Sí</option>
                                </select>
                            </div>
                        </div>

                        <!-- Participante -->
                        <div class="mb-3">
                            <label for="id_participante" class="form-label">Participante</label>
                            <select class="form-select" id="id_participante" name="id_participante" required>
                                <option value="">Selecciona un Participante</option>
                                <?php
                                // Llenar el select con los participantes de la base de datos
                                while ($row = mysqli_fetch_assoc($participantes)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Foto desde archivo -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto de la Orquídea</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>

                        <!-- Cámara -->
                        <div class="mb-3">
                            <label for="camara" class="form-label">Tomar Foto con la Cámara</label>
                            <button type="button" class="btn btn-primary" id="abrir-camara">Abrir Cámara</button>
                            <button type="button" class="btn btn-secondary" id="apagar-camara" style="display:none;">Apagar Cámara</button>
                            <video id="video" style="display:none;" width="300" height="200" autoplay></video>
                            <canvas id="canvas" style="display:none;"></canvas>
                            <button type="button" id="capturar" class="btn btn-success" style="display:none;">Capturar</button>
                        </div>

                        <button type="submit" class="btn btn-success">Registrar Orquídea</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para abrir la cámara -->
    <script>
        document.getElementById('abrir-camara').addEventListener('click', function() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const capturar = document.getElementById('capturar');
            const apagarCamara = document.getElementById('apagar-camara');

            // Pedir permisos para acceder a la cámara
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.style.display = 'block';
                    capturar.style.display = 'block';
                    apagarCamara.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error al acceder a la cámara: ', error);
                });

            capturar.addEventListener('click', function() {
                const context = canvas.getContext('2d');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
                video.style.display = 'none';
                capturar.style.display = 'none';
                apagarCamara.style.display = 'none';

                // Convertir la imagen en un blob y simular la subida de un archivo
                canvas.toBlob(function(blob) {
                    const fileInput = document.getElementById('foto');
                    const file = new File([blob], 'foto_orquidea.png', {
                        type: 'image/png'
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;
                });
            });

            // Apagar la cámara
            apagarCamara.addEventListener('click', function() {
                const stream = video.srcObject;
                const tracks = stream.getTracks();

                tracks.forEach(track => track.stop());
                video.style.display = 'none';
                capturar.style.display = 'none';
                apagarCamara.style.display = 'none';
            });
        });

        // Script para cargar clases según el grupo seleccionado
        $('#id_grupo').on('change', function() {
            var id_grupo = $(this).val();

            // Si se selecciona un grupo, cargar las clases por AJAX
            if (id_grupo) {
                $.ajax({
                    type: 'POST',
                    url: '../Backend/get_clases.php', // Cambia la ruta si es necesario
                    data: { id_grupo: id_grupo },
                    success: function(response) {
                        $('#id_clase').html(response); // Actualizar el select de clases con los resultados
                    },
                    error: function() {
                        alert("Error al cargar las clases");
                    }
                });
            } else {
                $('#id_clase').html('<option value="">Selecciona una Clase</option>');
            }
        });

        // Manejador del formulario
        $('#form-orquidea').on('submit', function(e) {
            e.preventDefault(); // Prevenir el envío tradicional del formulario

            var formData = new FormData(this);

            $.ajax({
                url: '../Backend/agregar_orquidea.php', // Cambia esta URL si es necesario
                type: 'POST',
                data: formData,
                processData: false, // No procesar los datos
                contentType: false, // No establecer un content-type específico
                dataType: 'json', // Esperamos una respuesta JSON
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Orquídea registrada',
                            text: response.message,
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.href = 'Neva_orquidea.php'; // Redirigir
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
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error en la solicitud: ', jqXHR.status, errorThrown);
                    console.log(jqXHR.responseText);
                    try {
                        let parsedResponse = JSON.parse(jqXHR.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: parsedResponse.message,
                            confirmButtonText: 'Aceptar'
                        });
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo procesar la solicitud. Revisa la consola para más detalles.',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                }
            });
        });

        //asignacion de tareas pendientes 
    </script>

    

</body>

</html>
