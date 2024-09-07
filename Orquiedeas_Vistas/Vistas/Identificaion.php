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
    <style>
        .camera-container, .upload-container {
            text-align: center;
            margin-top: 20px;
        }

        .camera-container video, .upload-container img {
            width: 100%;
            max-width: 500px;
            border: 2px solid #007bff;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .camera-buttons, .upload-buttons {
            margin-top: 20px;
        }

        .camera-buttons button, .upload-buttons button {
            margin: 0 10px;
        }

        .camera-info, .upload-info {
            margin-top: 20px;
        }

        .sub-modules {
            margin-top: 40px;
        }

        .sub-modules .card {
            text-align: center;
            transition: transform 0.2s;
        }

        .sub-modules .card:hover {
            transform: scale(1.05);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
    </style>
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
            <input type="file" id="uploadInput" accept="image/*" class="form-control mb-3">
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
            let reader = new FileReader();
            reader.onload = function (e) {
                let uploadedImage = document.getElementById('uploadedImage');
                uploadedImage.src = e.target.result;
                uploadedImage.style.display = 'block';
                document.getElementById('uploadStatus').innerHTML = "<p class='text-success'>Imagen cargada correctamente.</p>";
                document.getElementById('recognizeButtonImage').style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        });

        // Simulación de reconocimiento de orquídea para la cámara
        recognizeButtonCamera.addEventListener('click', function () {
            cameraStatus.innerHTML = "<p class='text-info'>Reconociendo orquídea... (Simulación)</p>";
            setTimeout(function () {
                cameraStatus.innerHTML = "<p class='text-success'>Orquídea reconocida correctamente.</p>";
            }, 2000);
        });

        // Simulación de reconocimiento de orquídea para la imagen cargada
        document.getElementById('recognizeButtonImage').addEventListener('click', function () {
            document.getElementById('uploadStatus').innerHTML = "<p class='text-info'>Reconociendo orquídea... (Simulación)</p>";
            setTimeout(function () {
                document.getElementById('uploadStatus').innerHTML = "<p class='text-success'>Orquídea reconocida correctamente.</p>";
            }, 2000);
        });
    </script>
</body>

</html>
