<?php
require('../fpdf186/fpdf.php');

// Crear una clase personalizada para el PDF con mejoras en la estética
class PDF extends FPDF
{
    function Header()
    {
        // Encabezado con fondo verde
        $this->SetFillColor(0, 150, 0); // Verde suave
        $this->Rect(0, 0, 210, 20, 'F'); // Fondo verde en todo el ancho
        // Título del documento
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(255, 255, 255); // Texto blanco
        $this->Cell(0, 10, utf8_decode('ASOCIACIÓN ALTAVERAPACENSE DE ORQUIDEOLOGÍA'), 0, 1, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('COBÁN, ALTA VERAPAZ, GUATEMALA, C.A.'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('APARTADO POSTAL 115-16001'), 0, 1, 'C');
        $this->Ln(10); // Espacio entre encabezado y contenido
    }

    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Fuente para el pie de página
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function ReporteJuzgamiento()
    {
        // Título de la tabla
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('SHOW JUDGING'), 0, 1, 'C');

        // Crear los títulos de las columnas
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(230, 230, 230); // Fondo gris claro para encabezados
        $this->Cell(30, 10, 'Grupo', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Subgrupo', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Clase', 1, 1, 'C', true);

        // Espacios para escribir los valores
        $this->SetFont('Arial', '', 12);
        $this->Cell(30, 10, '', 1, 0, 'C'); // Grupo
        $this->Cell(30, 10, '', 1, 0, 'C'); // Subgrupo
        $this->Cell(30, 10, '', 1, 1, 'C'); // Clase

        // Crear una tabla para el registro de las orquídeas
        $this->Ln(5); // Espacio entre tablas
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(20, 10, utf8_decode('No. REG'), 1, 0, 'C', true);
        $this->Cell(100, 10, utf8_decode('NOMBRE: ESPECIE/HÍBRIDO'), 1, 0, 'C', true);
        $this->Cell(30, 10, utf8_decode('EXP1'), 1, 1, 'C', true);

        // Espacios en blanco para los registros de orquídeas
        $this->SetFont('Arial', '', 12);
        for ($i = 0; $i < 3; $i++) {
            $this->Cell(20, 10, '', 1, 0, 'C'); // Espacio para No. REG
            $this->Cell(100, 10, '', 1, 0, 'C'); // Espacio para NOMBRE
            $this->Cell(30, 10, '', 1, 1, 'C'); // Espacio para EXP1
        }

        // Mención Honorífica
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('MENCIONES HONORÍFICAS'), 0, 1, 'C');

        // Tabla para la mención honorífica
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30, 10, '2do.', 1, 0, 'C', true);
        $this->Cell(100, 10, '', 1, 1, 'C'); // Espacio para orquídea 2do. lugar

        $this->Cell(30, 10, '3er.', 1, 0, 'C', true);
        $this->Cell(100, 10, '', 1, 1, 'C'); // Espacio para orquídea 3er. lugar

        $this->Cell(30, 10, 'MH', 1, 0, 'C', true);
        $this->Cell(100, 10, '', 1, 1, 'C'); // Espacio para Mención Honorífica

        // Firma de los jueces
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode('FIRMA DE LOS JUECES'), 0, 1, 'C');

        // Crear espacios para las firmas
        $this->Cell(80, 20, '', 1, 0, 'C'); // Espacio para primera firma
        $this->Cell(30, 0, '', 0, 0); // Espacio entre firmas
        $this->Cell(80, 20, '', 1, 1, 'C'); // Espacio para segunda firma
    }
}

// Crear un nuevo PDF
$pdf = new PDF();
$pdf->AddPage();

// Llamar a la función para llenar el contenido del PDF
$pdf->ReporteJuzgamiento();

// Generar el PDF
$pdf->Output();
?>
