<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['user_id'])) {
    // Redirigir al login si no hay sesión
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- Enlaces a Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/minty/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Enlace a FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Recursos/css/dashboard.css">
    <link rel="stylesheet" href="../../Recursos/css/icons.css">
    <!-- Incluir SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Estilos personalizados para el main-content y las tarjetas pequeñas -->
    <style>
        #contenido-principal {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; /* Alinear las tarjetas en el centro */
            padding: 20px; /* Espacio alrededor del contenido principal */
        }

        .my-custom-card {
            width: 200px; /* Ancho reducido */
            height: auto; /* Altura ajustable al contenido */
            margin: 10px; /* Separación entre tarjetas */
            padding: 15px; /* Espaciado interno */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra ligera */
            background-color: #f9f9f9; /* Color de fondo */
        }

        .my-custom-card .card-body {
            padding: 10px; /* Espaciado interno en el cuerpo de la tarjeta */
        }

        .my-custom-card .card-title {
            font-size: 16px; /* Tamaño de fuente más pequeño para el título */
            margin-bottom: 10px;
        }

        .my-custom-card .card-text {
            font-size: 14px; /* Tamaño de fuente más pequeño para el texto */
            margin-bottom: 10px;
        }

        .my-custom-card .btn {
            font-size: 12px; /* Botón pequeño */
            padding: 5px 10px; /* Espaciado pequeño en el botón */
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php include '../Vistas/modales/side_trofeos.php';?>

    <!-- Contenido principal donde se aplicarán las tarjetas pequeñas -->
    <div id="contenido-principal">
        <!-- Ejemplo de tarjeta con botón para descargar el PDF -->
        
    </div>

    <!-- Enlaces a Bootstrap JS, jQuery y tus scripts personalizados -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Versión completa de jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="../../Recursos/js/side.js"></script>

    <!-- Script para manejar la carga dinámica -->
    <script>
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


</body>

</html>
