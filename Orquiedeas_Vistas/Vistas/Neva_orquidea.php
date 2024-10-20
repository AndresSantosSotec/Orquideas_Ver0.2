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
    <!-- Enlaces a Bootstrap JS (necesario para el funcionamiento de los modales) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Recursos/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
</head>

<body>
    <!-- Sidebar -->
    <?php include '../Vistas/modales/side_orquideas.php' ?>

    <!-- Contenido principal -->
    <div id="contenido-principal">
        <?php include '../Vistas/Cards/orquideas.php'; ?>
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
                    data: {
                        id_grupo: id_grupo
                    },
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
    </script>
    <script>
        // Función para llenar selects dinámicamente
        function fillSelectOptions(url, selectId, selectedValue) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    var options = JSON.parse(response);
                    $(selectId).empty();
                    options.forEach(function(option) {
                        $(selectId).append(new Option(option.name, option.id));
                    });
                    // Seleccionar el valor actual
                    $(selectId).val(selectedValue);
                }
            });
        }



        $(document).ready(function() {
            // Interceptar el clic en los enlaces del menú
            $('ul li a').click(function(e) {
                e.preventDefault(); // Prevenir la acción predeterminada del enlace

                var target = $(this).data('target'); // Obtener el archivo objetivo

                // Usar AJAX para cargar el archivo PHP dentro del contenedor principal
                $.ajax({
                    url: target,
                    type: 'GET',
                    success: function(response) {
                        $('#contenido-principal').html(response); // Reemplazar el contenido
                    },
                    error: function() {
                        alert('Error al cargar el contenido.');
                    }
                });
            });
        });
    </script>

    <script src="../../Recursos/js/side.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>