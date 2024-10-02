<?php
require('fpdf/fpdf.php');
include '../../Backend/Conexion_bd.php'; // Ajusta la ruta de conexión

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
$pdf->Cell(0, 10, 'Detalles de la Orquídea', 1, 1, 'C');

// Nombre de la planta
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nombre de la Planta: ' . $orquidea['nombre_planta'], 0, 1);

// Origen
$pdf->Cell(0, 10, 'Origen: ' . $orquidea['origen'], 0, 1);

// Participante
$pdf->Cell(0, 10, 'Participante: ' . $orquidea['nombre_participante'], 0, 1);

// Grupo y Clase
$pdf->Cell(0, 10, 'Grupo: ' . $orquidea['nombre_grupo'], 0, 1);
$pdf->Cell(0, 10, 'Clase: ' . $orquidea['nombre_clase'], 0, 1);

// Insertar imagen de la orquídea (si existe)
if (!empty($orquidea['foto'])) {
    $pdf->Image('data:image/jpeg;base64,' . base64_encode($orquidea['foto']), 10, 100, 50, 50); // Ajusta la posición y tamaño
}

// Insertar código QR (si existe)
if (!empty($orquidea['qr_code'])) {
    $pdf->Image('data:image/png;base64,' . base64_encode($orquidea['qr_code']), 100, 100, 50, 50); // Ajusta la posición y tamaño
}

// Salida del PDF
$pdf->Output('D', 'orquidea_' . $id_orquidea . '.pdf'); // Descargar el archivo
?>
