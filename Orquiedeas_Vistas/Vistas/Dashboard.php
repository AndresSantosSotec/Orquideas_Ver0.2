<?php
// Incluir conexión a la base de datos
include "../Backend/Conexion_bd.php";
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['user_id'])) {
    // Redirigir al login si no hay sesión
    header("Location: login.php");
    exit;
}

// Año actual
$year = date('Y');

// Consulta para contar participantes registrados en el año actual
$sql_participantes = "SELECT COUNT(*) AS total_participantes 
                      FROM tb_participante 
                      WHERE YEAR(fecha_creacion) = ?";
$stmt1 = $conexion->prepare($sql_participantes);
$stmt1->bind_param("i", $year);
$stmt1->execute();
$result1 = $stmt1->get_result();
$total_participantes = $result1->fetch_assoc()['total_participantes'];

// Consulta para contar orquídeas registradas en el año actual
$sql_orquideas = "SELECT COUNT(*) AS total_orquideas 
                  FROM tb_orquidea 
                  WHERE YEAR(fecha_creacion) = ?";
$stmt2 = $conexion->prepare($sql_orquideas);
$stmt2->bind_param("i", $year);
$stmt2->execute();
$result2 = $stmt2->get_result();
$total_orquideas = $result2->fetch_assoc()['total_orquideas'];

$stmt1->close();
$stmt2->close();

// Capturar el tipo de usuario de la sesión
$user_type = $_SESSION['user_type'];
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

    <!-- Enlace a FontAwesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../../Recursos/css/dashboard.css">
    <link rel="stylesheet" href="../../Recursos/css/icons.css">

</head>

<body>
        <!-- Logo de la universidad en la esquina superior derecha -->
        <div style="position: absolute; top: 10px; right: 10px; z-index: 1000;">
         <!-- Segundo logo -->
        <img src="/Orquideas_Ver0.2/Recursos/img/Logo-fotor-bg-remover-2024090519443.png" alt="Logo 2" style="width: 100px; height: auto; margin-right: 10px;">
        <img src="/Orquideas_Ver0.2/Recursos/img/LogoUMG.png" alt="Logo Universidad" style="width: 200px; height: auto;">    </div>
    <!-- Sidebar -->
    <?php include '../Vistas/modales/side.php'; ?>
    <!---->
    <div class="main-content" id="main-content">
        <h1>Bienvenido al Dashboard</h1>
        <b>Haz click en el icono que quieres acceder</b>
        <!-- Sub-sección: Datos del año actual -->
        <div class="row mt-4">
            <div class="col-lg-6 section-5">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Participantes Registrados (<?php echo $year; ?>)</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $total_participantes; ?> Participantes</h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Orquídeas Registradas (<?php echo $year; ?>)</div>
                    <div class="card-body crdbody">
                        <h5 class="card-title"><?php echo $total_orquideas; ?> Orquídeas</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Perfiles de Usuario -->
            <div class="col-lg-4 col-md-6 mb-4 section-5" style="display: none;">
                <div class="card crdbody" onclick="location.href='Registro_usuario.php'">
                    <div class="card-body">
                        <i class="fas fa-user card-icon perfiles"></i>
                        <h5 class="card-title">Participantes</h5>
                        <p class="card-text">Gestiona los perfiles de los usuarios.</p>
                    </div>
                </div>
            </div>

            <!-- Registro de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4 section-5" style="display: none;">
                <div class="card crdbody" onclick="location.href='Neva_orquidea.php'">
                    <div class="card-body">
                        <i class="fas fa-plus-circle card-icon orquidea"></i>
                        <h5 class="card-title">Gestionar Orquídeas</h5>
                        <p class="card-text">Gestiona y registra Orquídeas.</p>
                    </div>
                </div>
            </div>

            <!-- Identificación de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4 " style="display: none;">
                <div class="card crdbody" onclick="location.href='Identificar.php'">
                    <div class="card-body">
                        <i class="fas fa-leaf card-icon identificacion"></i>
                        <h5 class="card-title">Identificación de Orquídeas</h5>
                        <p class="card-text">Sistema para identificar orquídeas.</p>
                    </div>
                </div>
            </div>

            <!-- Juzgamiento -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card" onclick="location.href='juzgamiento.php'">
                    <div class="card-body">
                        <i class="fas fa-gavel card-icon juzgamiento"></i>
                        <h5 class="card-title">Juzgamiento</h5>
                        <p class="card-text">Sistema de juzgamiento de orquídeas.</p>
                    </div>
                </div>
            </div>

            <!-- Reporte de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card" onclick="location.href='Reportes.php'">
                    <div class="card-body">
                        <i class="fas fa-chart-bar card-icon reporte"></i>
                        <h5 class="card-title">Reporte de Orquídeas</h5>
                        <p class="card-text">Consulta reportes completos de orquídeas, su clasificación, ganadores, y accede a los formatos de inscripción y juzgamiento.</p>
                    </div>
                </div>
            </div>

            <!-- Revisión de Estado de Orquídeas -->
            <div class="col-lg-4 col-md-6 mb-4 section-5" style="display: none;">
                <div class="card" onclick="location.href='estado.php'">
                    <div class="card-body">
                        <i class="fas fa-search card-icon revision"></i>
                        <h5 class="card-title">Estado de Orquídeas</h5>
                        <p class="card-text">Revisa el estado actual de las orquídeas.</p>
                    </div>
                </div>
            </div>

            <!-- Premios -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card" onclick="location.href='Trofeos.php'">
                    <div class="card-body">
                        <i class="fas fa-trophy card-icon premios"></i>
                        <h5 class="card-title">Premios</h5>
                        <p class="card-text">Gestiona y otorga los premios de las orquídeas.</p>
                    </div>
                </div>
            </div>

            <!-- Formatos de Inscripción -->
            <div class="col-lg-4 col-md-6 mb-4 section-5" style="display: none;">
                <div class="card" onclick="descargarReportes()">
                    <div class="card-body">
                        <i class="fas fa-file card-icon premios"></i>
                        <h5 class="card-title">Formato Inscripcion</h5>
                        <p class="card-text">Descargar los formatos de inscripción para registrarse de forma manuscrita.</p>
                    </div>
                </div>
            </div>
        </div> <!-- Cierre del div.row -->
    </div>
    <script>
        function descargarReportes() {
            const reportes = [
                '../Vistas/Documentos/pdf/incri_participante.php',
                '../Vistas/Documentos/pdf/Inscri_orquidea.php'
            ];

            reportes.forEach((reporte) => {
                const link = document.createElement('a');
                link.href = reporte;
                link.download = reporte.split('/').pop() + '.pdf'; // Nombre del archivo descargado
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        }
    </script>
    <script>
        // Ejecutar cuando el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function () {
            // Capturar el tipo de usuario desde PHP
            const userType = <?php echo json_encode($user_type); ?>;

            // Enviar el tipo de usuario a la consola del navegador
            console.log("Tipo de Usuario Conectado:", userType);

            // Ocultar todas las secciones al inicio
            document.querySelectorAll('.col-lg-4').forEach(section => {
                section.style.display = 'none';
            });

            if (userType === 1) {
                // Mostrar todas las secciones para el usuario tipo 1
                document.querySelectorAll('.col-lg-4').forEach(section => {
                    section.style.display = 'block';
                });
                console.log("Usuario tipo 1: Acceso completo al dashboard.");
            } else if (userType === 5) {
                // Mostrar solo las secciones específicas para tipo 5
                document.querySelectorAll('.section-5').forEach(section => {
                    section.style.display = 'block';
                });
                console.log("Usuario tipo 5: Acceso limitado.");
            } else {
                console.log("Usuario sin acceso a secciones específicas.");
            }
        });
    </script>

    <!-- Enlaces a Bootstrap JS, jQuery y tus scripts personalizados -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script src="../../Recursos/js/side.js"></script>
</body>

</html>