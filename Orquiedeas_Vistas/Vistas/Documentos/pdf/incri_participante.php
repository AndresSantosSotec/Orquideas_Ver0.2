<?php
require('../fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Encabezado de página
    function Header()
    {
        // Colores, logo y título
        $this->SetFillColor(0, 150, 0); // Color verde
        $this->Rect(0, 0, 210, 20, 'F'); // Fondo verde
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(255, 255, 255); // Texto blanco
        $this->Cell(0, 10, utf8_decode('FORMULARIO DE INSCRIPCIÓN DE PARTICIPANTE'), 0, 1, 'C', true);
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Crear tabla para datos personales
    function DatosPersonales()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(0, 150, 0); // Verde
        $this->SetTextColor(255, 255, 255); // Texto blanco
        $this->Cell(190, 10, utf8_decode('DATOS PERSONALES'), 1, 1, 'C', true);
        
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0); // Texto negro
        $this->SetFillColor(240, 240, 240); // Color fondo claro
        $this->Cell(50, 10, utf8_decode('Nombre Completo:'), 1, 0, 'L', true);
        $this->Cell(140, 10, '', 1, 1, 'L'); // Campo vacío para rellenar

        $this->Cell(50, 10, utf8_decode('Número Telefónico:'), 1, 0, 'L', true);
        $this->Cell(140, 10, '', 1, 1, 'L'); // Campo vacío para rellenar
        
        $this->Cell(50, 10, utf8_decode('Dirección:'), 1, 0, 'L', true);
        $this->Cell(140, 10, '', 1, 1, 'L'); // Campo vacío

        $this->Cell(50, 10, utf8_decode('Tipo de Participante:'), 1, 0, 'L', true);
        $this->Cell(70, 10, '', 1, 0, 'L'); // Campo vacío
        $this->Cell(30, 10, utf8_decode('Nacional/Extranjero:'), 1, 0, 'L', true);
        $this->Cell(40, 10, '', 1, 1, 'L'); // Campo vacío
    }

    // Crear tabla para la sección de datos adicionales
    function DatosAdicionales()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(0, 150, 0); // Verde
        $this->SetTextColor(255, 255, 255); // Texto blanco
        $this->Cell(190, 10, utf8_decode('DATOS ADICIONALES'), 1, 1, 'C', true);
        
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0); // Texto negro
        $this->SetFillColor(240, 240, 240); // Color fondo claro

        $this->Cell(50, 10, utf8_decode('Departamento:'), 1, 0, 'L', true);
        $this->Cell(140, 10, '', 1, 1, 'L'); // Campo vacío

        $this->Cell(50, 10, utf8_decode('Municipio:'), 1, 0, 'L', true);
        $this->Cell(140, 10, '', 1, 1, 'L'); // Campo vacío

        $this->Cell(50, 10, utf8_decode('Asociación:'), 1, 0, 'L', true);
        $this->Cell(140, 10, '', 1, 1, 'L'); // Campo vacío
    }
}

// Creación del PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Agregar datos personales
$pdf->DatosPersonales();
$pdf->Ln(5); // Separación entre secciones

// Agregar sección de datos adicionales
$pdf->DatosAdicionales();
$pdf->Output();
?>
