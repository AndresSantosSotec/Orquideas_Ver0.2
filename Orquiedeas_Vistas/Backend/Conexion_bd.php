<?php
// Conexión utilizando variables de entorno para mayor seguridad
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_username = getenv('DB_USER') ?: 'root';
$db_password = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'bd_orquideas';

$conexion = new mysqli($db_host, $db_username, $db_password, $db_name);
$conexion->set_charset('utf8');

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}
?>
