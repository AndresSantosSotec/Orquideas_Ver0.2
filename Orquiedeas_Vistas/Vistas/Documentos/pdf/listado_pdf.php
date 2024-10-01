<?php
// Usar __DIR__ para obtener la ruta absoluta y evitar problemas de rutas relativas
require 'C:/xampp/htdocs/dashboard/Orqudiea_Ver0.2/vendor/autoload.php';



// Usar la clase FPDF sin namespace (FPDF no tiene un namespace)
$pdf = new FPDF();  // Aquí no debe ir 'setasign\fpdf\fpdf', solo 'FPDF'
$pdf->AddPage();

// Configuración de la fuente
$pdf->SetFont('Arial', 'B', 12);

// Título del documento
$pdf->Cell(0, 10, 'ASOCIACION ALTAVERAPACENSE DE ORQUIDEOLOGIA', 0, 1, 'C');
$pdf->Cell(0, 10, 'COBAN, ALTA VERAPAZ, GUATEMALA, C.A.', 0, 1, 'C');
$pdf->Cell(0, 10, 'APARTADO POSTAL 115-16001', 0, 1, 'C');

// Espacio entre título y contenido
$pdf->Ln(10);

// Título de la tabla
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'SHOW JUDGING', 0, 1, 'C');

// Definir el tamaño de la fuente para el contenido
$pdf->SetFont('Arial', '', 10);

// Crear los títulos de las columnas
$pdf->Cell(30, 10, 'Grupo', 1, 0, 'C');
$pdf->Cell(30, 10, 'Subgrupo', 1, 0, 'C');
$pdf->Cell(30, 10, 'Clase', 1, 1, 'C');

// Espacios para escribir los valores
$pdf->Cell(30, 10, 'A', 1, 0, 'C'); // Grupo
$pdf->Cell(30, 10, 'A-1', 1, 0, 'C'); // Subgrupo
$pdf->Cell(30, 10, '5', 1, 1, 'C'); // Clase

// Crear una tabla para el registro de las orquídeas
$pdf->Ln(5); // Espacio

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, 'No. REG', 1, 0, 'C');
$pdf->Cell(80, 10, 'NOMBRE: ESPECIE/HIBRIDO', 1, 0, 'C');
$pdf->Cell(30, 10, 'EXP1', 1, 1, 'C');

// Espacios en blanco para los registros de orquídeas
$pdf->SetFont('Arial', '', 10);
for ($i = 0; $i < 3; $i++) {
    $pdf->Cell(20, 10, '', 1, 0, 'C'); // Espacio para No. REG
    $pdf->Cell(80, 10, '', 1, 0, 'C'); // Espacio para NOMBRE
    $pdf->Cell(30, 10, '', 1, 1, 'C'); // Espacio para EXP1
}

// Mención Honorífica
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'MENCION HONORIFICA', 0, 1, 'C');

// Tabla para la mención honorífica
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, '2do.', 1, 0, 'C');
$pdf->Cell(80, 10, '', 1, 1, 'C'); // Espacio para orquídea 2do. lugar

$pdf->Cell(30, 10, '2do.', 1, 0, 'C');
$pdf->Cell(80, 10, '', 1, 1, 'C'); // Espacio para orquídea 2do. lugar

$pdf->Cell(30, 10, '3er.', 1, 0, 'C');
$pdf->Cell(80, 10, '', 1, 1, 'C'); // Espacio para orquídea 3er. lugar

$pdf->Cell(30, 10, 'MH', 1, 0, 'C');
$pdf->Cell(80, 10, '', 1, 1, 'C'); // Espacio para Mención Honorífica

$pdf->Cell(30, 10, 'MH', 1, 0, 'C');
$pdf->Cell(80, 10, '', 1, 1, 'C'); // Espacio para Mención Honorífica

// Firma de los jueces
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, 'FIRMA DE LOS JUECES', 0, 1, 'C');

// Crear espacios para las firmas
$pdf->Cell(90, 10, '', 1, 0, 'C'); // Espacio para primera firma
$pdf->Cell(90, 10, '', 1, 1, 'C'); // Espacio para segunda firma

// Fecha y número de página
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'miercoles, 26 de noviembre de 2014', 0, 1, 'L');
$pdf->Cell(0, 10, 'Pagina 5 de 76', 0, 1, 'R');

// Generar el PDF
$pdf->Output();
