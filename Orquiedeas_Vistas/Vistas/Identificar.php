<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reconocimiento de Orquídeas</title>

    <!-- Enlaces a Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">

    <!-- Enlace a FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../../Recursos/css/recon.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> <span>Volver al Inicio</span></a></li>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
            <li><a href="#"><i class="fas fa-plus-circle"></i> <span>Registro de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-user"></i> <span>Perfiles de Usuario</span></a></li>
            <li><a href="#"><i class="fas fa-leaf"></i> <span>Identificación de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-gavel"></i> <span>Juzgamiento</span></a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> <span>Reporte de Orquídeas</span></a></li>
            <li><a href="#"><i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span></a></li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="main-content">
        <h1 class="text-center mt-5">Reconocimiento de Orquídeas</h1>
        <p class="text-center">Elige entre usar la cámara o cargar una imagen para identificar las orquídeas.</p>

        <!-- Botones para elegir entre usar cámara o subir imagen -->
        <div class="text-center mb-4">
            <button class="btn btn-primary" id="useCameraButton"><i class="fas fa-camera"></i> Usar Cámara</button>
            <button class="btn btn-secondary" id="uploadImageButton"><i class="fas fa-upload"></i> Cargar Imagen</button>
        </div>

        <!-- Contenedor de la cámara -->
        <div class="camera-container" id="cameraSection" style="display: none;">
            <video id="cameraStream" autoplay></video>
            <div class="camera-buttons">
                <button class="btn btn-success" id="openCameraButton"><i class="fas fa-camera"></i> Abrir Cámara</button>
                <button class="btn btn-danger" id="closeCameraButton" disabled><i class="fas fa-times-circle"></i> Cerrar Cámara</button>
                <button class="btn btn-warning" id="recognizeButtonCamera" disabled><i class="fas fa-search"></i> Reconocer Orquídea</button>
            </div>
            <div class="camera-info" id="cameraStatus"></div>
        </div>

        <!-- Contenedor para cargar imagen -->
        <div class="upload-container" id="uploadSection" style="display: none;">
            <input type="file" id="uploadInput" accept="image/png, image/jpeg, image/jpg, image/gif" class="form-control mb-3">
            <img id="uploadedImage" src="#" alt="Imagen seleccionada" style="display: none;">
            <div class="upload-buttons">
                <button class="btn btn-warning" id="recognizeButtonImage" style="display:none;"><i class="fas fa-search"></i> Reconocer Orquídea</button>
            </div>
            <div class="upload-info" id="uploadStatus"></div>
        </div>
    </div>

    <!-- Enlaces a Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        const apiKey = 'OEIpwUZDZVaQLKPumB5zd0D1rnfkA05bIDIWokqwQfOwcT3dHa';  // Reemplaza con tu API Key de Plant.id
        const apiUrl = 'https://plant.id/api/v3/identification';  // URL correcta de la API

        async function recognizeOrchid(base64Image) {
            const requestData = {
                images: [base64Image],
                modifiers: ["crops_fast", "similar_images"],
                plant_details: ["common_names", "url", "name_authority", "wiki_description", "taxonomy"]
            };

            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Api-Key': apiKey // Asegúrate de enviar la API Key en el header
                },
                body: JSON.stringify(requestData)
            });

            if (!response.ok) {
                throw new Error(`Error HTTP! status: ${response.status}`);
            }

            const result = await response.json();
            return result;
        }

        // Variables para la cámara y el stream
        let cameraStream = document.getElementById('cameraStream');
        let stream;

        // Botones
        let openCameraButton = document.getElementById('openCameraButton');
        let closeCameraButton = document.getElementById('closeCameraButton');
        let recognizeButtonCamera = document.getElementById('recognizeButtonCamera');
        let cameraStatus = document.getElementById('cameraStatus');

        // Secciones de cámara e imagen
        let cameraSection = document.getElementById('cameraSection');
        let uploadSection = document.getElementById('uploadSection');

        // Función para abrir la cámara
        openCameraButton.addEventListener('click', function () {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function (mediaStream) {
                        stream = mediaStream;
                        cameraStream.srcObject = stream;
                        cameraStatus.innerHTML = "<p class='text-success'>Cámara activada.</p>";
                        closeCameraButton.disabled = false;
                        recognizeButtonCamera.disabled = false;
                        openCameraButton.disabled = true;
                    })
                    .catch(function (error) {
                        cameraStatus.innerHTML = "<p class='text-danger'>No se pudo acceder a la cámara: " + error.message + "</p>";
                    });
            } else {
                cameraStatus.innerHTML = "<p class='text-danger'>Tu dispositivo no soporta el acceso a la cámara.</p>";
            }
        });

        // Función para cerrar la cámara
        closeCameraButton.addEventListener('click', function () {
            stream.getTracks().forEach(function (track) {
                track.stop();
            });
            cameraStream.srcObject = null;
            cameraStatus.innerHTML = "<p class='text-info'>Cámara desactivada.</p>";
            openCameraButton.disabled = false;
            closeCameraButton.disabled = true;
            recognizeButtonCamera.disabled = true;
        });

        // Botones de selección de cámara o cargar imagen
        document.getElementById('useCameraButton').addEventListener('click', function () {
            cameraSection.style.display = 'block';
            uploadSection.style.display = 'none';
        });

        document.getElementById('uploadImageButton').addEventListener('click', function () {
            cameraSection.style.display = 'none';
            uploadSection.style.display = 'block';
        });

        // Funcionalidad para cargar una imagen
        document.getElementById('uploadInput').addEventListener('change', function (event) {
            let file = event.target.files[0];
            let validTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];

            if (validTypes.includes(file.type)) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    let uploadedImage = document.getElementById('uploadedImage');
                    uploadedImage.src = e.target.result;
                    uploadedImage.style.display = 'block';

                    // Llama a la API para reconocer la imagen
                    recognizeOrchid(e.target.result.split(',')[1])
                        .then(data => {
                            // Muestra los resultados de la API
                            document.getElementById('uploadStatus').innerHTML = `<p class='text-success'>Orquídea reconocida: ${data.suggestions[0].plant_name}</p>`;
                        })
                        .catch(err => {
                            document.getElementById('uploadStatus').innerHTML = `<p class='text-danger'>Error al reconocer la orquídea: ${err.message}</p>`;
                        });

                    document.getElementById('recognizeButtonImage').style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('uploadStatus').innerHTML = "<p class='text-danger'>Por favor, selecciona un archivo de imagen válido (JPEG, PNG, GIF).</p>";
                event.target.value = '';  // Resetea el campo de carga de archivos
            }
        });
    </script>
</body>

</html>