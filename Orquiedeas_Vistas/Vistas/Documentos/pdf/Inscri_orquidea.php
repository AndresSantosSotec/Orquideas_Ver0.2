<?php
require('../fpdf186/fpdf.php');  // Cargar la librería FPDF

// Crear una clase personalizada para el PDF con mejoras en la estética
class PDF extends FPDF
{
    function Header()
    {
        // Encabezado con fondo verde
        $this->SetFillColor(0, 150, 0); // Verde suave
        $this->Rect(0, 0, 210, 20, 'F'); // Fondo verde en todo el ancho
        $this->SetFont('Arial', 'B', 16);
        $this->SetTextColor(255, 255, 255); // Texto blanco
        $this->Cell(0, 10, utf8_decode('Formato de Inscripción de Orquídeas'), 0, 1, 'C');
        $this->Ln(20); // Salto de línea
    }

    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }

    function ReporteInscripcion($especie = false, $hibrida = false)
    {
        // Estilo del cuerpo
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(190, 12, utf8_decode('Datos de Inscripción de la Orquídea'), 0, 1, 'C');

        // Formato de datos
        $this->SetFont('Arial', '', 10);

        // Nombre de la Planta
        $this->Cell(50, 10, utf8_decode('Nombre de la Planta:'), 1, 0);
        $this->Cell(140, 10, '', 1, 1);

        // Origen con "X" para Especie o Híbrida
        $this->Cell(50, 10, utf8_decode('Origen:'), 1, 0);
        $this->Cell(70, 10, utf8_decode('Especie: ') . ($especie ? '' : ''), 1, 0, 'C');  // Marcar con "X"
        $this->Cell(70, 10, utf8_decode('Híbrida: ') . ($hibrida ? '' : ''), 1, 1, 'C'); // Marcar con "X"

        // Grupo
        $this->Cell(50, 10, utf8_decode('Grupo:'), 1, 0);
        $this->Cell(140, 10, '', 1, 1);

        // Clase
        $this->Cell(50, 10, utf8_decode('Clase:'), 1, 0);
        $this->Cell(140, 10, '', 1, 1);

        // Participante
        $this->Cell(50, 10, utf8_decode('Participante:'), 1, 0);
        $this->Cell(140, 10, '', 1, 1);

        // Foto
        $this->Cell(50, 40, utf8_decode('Foto de la Orquídea:'), 1, 0);
        $this->Cell(140, 40, '', 1, 1); // Espacio para insertar la imagen
    }
}

// Crear un nuevo PDF
$pdf = new PDF();
$pdf->AddPage();

// Llamar a la función para llenar el contenido del PDF, marcando "Especie" o "Híbrida" según sea necesario
$pdf->ReporteInscripcion(true, false); // Ejemplo: Marcamos "Especie"

// Generar el PDF
$pdf->Output('I', 'Formato_Inscripcion_Orquidea.pdf');
?>
