<?php
//
// Configuración de bd en localHost
$db_host = 'localhost';
$db_username = 'root';
$db_password = ''; // Cambia por una contraseña segura
$db_name = 'bd_orquideas';

// Conexión a la base de datos
$conexion = new mysqli($db_host, $db_username, $db_password, $db_name);
$conexion->set_charset("utf8");

// Manejo de errores
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Configuración de bd en cloud




//configuracion en el entorno de Pruebas 