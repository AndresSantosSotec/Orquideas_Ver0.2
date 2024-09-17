<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir al login
header("Location: ../Vistas/login.php");
exit;
?>
