<?php
require('../fpdf186/fpdf.php');  // Cargar la librería FPDF
include '../../../Backend/Conexion_bd.php';  // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id_orquidea = $_GET['id'];

    // Consultar la orquídea específica por su ID
    $query = "
        SELECT 
            o.nombre_planta,
            o.origen,
            o.foto,
            o.qr_code,
            p.nombre AS nombre_participante,
            g.nombre_grupo,
            c.nombre_clase
        FROM tb_orquidea o
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN tb_participante p ON o.id_participante = p.id
        WHERE o.id_orquidea = '$id_orquidea'";
    
    $result = mysqli_query($conexion, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $orquidea = mysqli_fetch_assoc($result);
    } else {
        echo "No se encontraron datos para esta orquídea.";
        exit;
    }
} else {
    echo "ID de orquídea no proporcionado.";
    exit;
}

// Crear PDF usando FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10,utf8_decode('Detalles de la Orquídea'), 1, 1, 'C');

// Nombre de la planta
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_decode('Nombre de la Planta: ') . utf8_decode($orquidea['nombre_planta']), 0, 1);

// Origen
$pdf->Cell(0, 10, utf8_decode('Origen: ') . utf8_decode($orquidea['origen']), 0, 1);

// Participante
$pdf->Cell(0, 10, utf8_decode('Participante: ') . utf8_decode($orquidea['nombre_participante']), 0, 1);

// Grupo y Clase
$pdf->Cell(0, 10, utf8_decode('Grupo: ') . utf8_decode($orquidea['nombre_grupo']), 0, 1);
$pdf->Cell(0, 10, utf8_decode('Clase: ') . utf8_decode($orquidea['nombre_clase']), 0, 1);

if (file_exists('../../../../Recursos/img/Saved_images/Images/' . $orquidea['foto'])) {
    $pdf->Image('../../../../Recursos/img/Saved_images/Images/' . $orquidea['foto'], 10, 100, 50, 50);
} else {
    // No imprimas nada aquí, solo depura el problema
    error_log('La imagen no existe en la ruta: ../../../../Recursos/img/Saved_images/Images/' . $orquidea['foto']);
}
// Verificar y mostrar el código QR
if (!empty($orquidea['qr_code'])) {
    if (file_exists('../../../../Recursos/img/Saved_images/Qr/' . $orquidea['qr_code'])) {
        $pdf->Image('../../../../Recursos/img/Saved_images/Qr/' . $orquidea['qr_code'], 100, 100, 50, 50); // Ajusta la posición y tamaño
    } else {
        error_log('El código QR no existe en la ruta: ../../../../Recursos/img/Saved_images/Qr/' . $orquidea['qr_code']);
    }
}
// Salida del PDF
$pdf->Output('D', 'orquidea_' . $id_orquidea . '.pdf');  // Descargar el archivo PDF
?>
