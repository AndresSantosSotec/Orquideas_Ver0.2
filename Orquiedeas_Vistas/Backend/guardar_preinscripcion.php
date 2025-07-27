<?php
// Guarda datos de preinscripción en un archivo JSON
$dataFile = __DIR__ . '/preinscripciones.json';
$registro = [
    'nombre' => $_POST['nombre'] ?? '',
    'correo' => $_POST['correo'] ?? '',
    'orquidea' => $_POST['orquidea'] ?? '',
    'fecha' => date('Y-m-d H:i:s')
];

$registros = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $registros = json_decode($json, true) ?: [];
}
$registros[] = $registro;
file_put_contents($dataFile, json_encode($registros, JSON_PRETTY_PRINT));

header('Location: ../Vistas/preinscripcion.php?ok=1');
exit;
