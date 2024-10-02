<?php

require('../fpdf186/fpdf.php');
include 'Conexion_bd.php';

// Consultar los datos de la orquídea, incluyendo grupo, clase y participante
//todo Huecos
$query = "
    SELECT 
        o.id_orquidea, 
        o.nombre_planta, 
        g.Cod_Grupo, 
        c.id_clase, 
        p.nombre AS nombre_participante
    FROM tb_orquidea o
    INNER JOIN grupo g ON o.id_grupo = g.id_grupo
    INNER JOIN clase c ON o.id_clase = c.id_clase
    INNER JOIN tb_participante p ON o.id_participante = p.id
    ORDER BY o.id_orquidea";

$result = mysqli_query($conexion, $query);

$pdf = new FPDF();
$pdf->AddPage();

// Título del reporte
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Asociacion Altaverapacense de Orquideologia', 0, 1, 'C');
$pdf->Cell(0, 10, 'Coban, Alta Verapaz', 0, 1, 'C');
$pdf->Cell(0, 10, 'Listado General Plantas', 0, 1, 'C');
$pdf->Ln(10);

// Encabezado de tabla
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(60, 10, 'Planta', 1);
$pdf->Cell(30, 10, 'Clas', 1);
$pdf->Cell(10, 10, 'Es', 1);
$pdf->Cell(10, 10, 'Hi', 1);
$pdf->Cell(60, 10, 'Nombre', 1);
$pdf->Ln();

// Datos
$pdf->SetFont('Arial', '', 12);
$contador = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $clas = $row['Cod_Grupo'] . "/" . $row['id_clase'];
    
    // Agregar los datos de cada fila
    $pdf->Cell(10, 10, $contador, 1);
    $pdf->Cell(60, 10, $row['nombre_planta'], 1);
    $pdf->Cell(30, 10, $clas, 1);
    $pdf->Cell(10, 10, 'x', 1);  // Campo Es fijo, según el formato
    $pdf->Cell(10, 10, 'x', 1);  // Campo Hi fijo, según el formato
    $pdf->Cell(60, 10, $row['nombre_participante'], 1);
    $pdf->Ln();
    
    $contador++;
}

// Pie de página con la fecha y el número de página
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Generado el ' . date('d/m/Y'), 0, 0, 'L');
$pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo(), 0, 0, 'R');

// Salida del PDF
$pdf->Output('I', 'Listado_General_Plantas.pdf');
