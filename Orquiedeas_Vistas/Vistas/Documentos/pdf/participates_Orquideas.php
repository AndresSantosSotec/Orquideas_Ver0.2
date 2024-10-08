<?php
require('../fpdf186/fpdf.php');
include ('conexion_bd.php'); // Asegúrate de que la conexión esté correcta

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Título
        $this->Cell(0, 10, 'Reporte de Participantes y Orquideas Asignadas', 0, 1, 'C');
        // Salto de línea
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
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    // Función para la tabla de participantes y orquídeas
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita (Azul)
        $this->SetFillColor(30, 144, 255); // Azul para el fondo de la cabecera
        $this->SetTextColor(255); // Blanco para el texto de la cabecera
        $this->SetDrawColor(0, 0, 139); // Azul oscuro para los bordes
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 12);

        // Anchuras de las columnas
        $w = array(40, 40, 45, 40, 35, 30, 30); // Ajustado para Grupo y Clase

        // Cabecera
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();

        // Restaurar colores y fuente para el contenido de la tabla
        $this->SetFillColor(224, 235, 255); // Azul claro para las filas alternadas
        $this->SetTextColor(0); // Negro para el texto de las filas
        $this->SetFont('Arial', '', 10);

        // Datos
        $fill = false;
        foreach ($data as $row) {
            // Ajustar el texto del Participante si es muy largo
            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell($w[0], 6, utf8_decode($row['participante_nombre']), 'LR', 'L', $fill);
            $this->SetXY($x + $w[0], $y); // Mover a la siguiente celda sin saltar línea
            
            // Otras celdas que no requieren ajuste
            $this->Cell($w[1], 6, $row['numero_telefonico'], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, utf8_decode($row['direccion']), 'LR', 0, 'L', $fill);
            
            // Ajustar el texto de Orquídea si es muy largo
            $x = $this->GetX();
            $y = $this->GetY();
            $this->MultiCell($w[3], 6, utf8_decode($row['nombre_planta']), 'LR', 'L', $fill);
            $this->SetXY($x + $w[3], $y); // Mover a la siguiente celda sin saltar línea
            
            // Otras celdas que no requieren ajuste
            $this->Cell($w[4], 6, utf8_decode($row['origen']), 'LR', 0, 'L', $fill);
            $this->Cell($w[5], 6, 'Grupo: ' . utf8_decode($row['Cod_Grupo']), 'LR', 0, 'L', $fill); // Mostrar Grupo
            $this->Cell($w[6], 6, 'Clase: ' . $row['id_clase'], 'LR', 0, 'L', $fill); // Mostrar Clase
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

// Crear un objeto de la clase PDF en orientación horizontal (L)
$pdf = new PDF('L', 'mm', 'A4'); // 'L' para Landscape (Horizontal)

// Agregar una página
$pdf->AddPage();

// Encabezados de la tabla
$header = array('Participante', 'Telefono', 'Direccion', 'Orquidea', 'Origen', 'Grupo', 'Clase');

// Realizar la consulta para obtener los datos de participantes y orquídeas
$query = "
    SELECT 
        p.nombre AS participante_nombre, 
        p.numero_telefonico, 
        p.direccion, 
        o.nombre_planta, 
        o.origen, 
        g.Cod_Grupo, 
        c.id_clase
    FROM tb_participante p
    INNER JOIN tb_orquidea o ON p.id = o.id_participante
    INNER JOIN clase c ON o.id_clase = c.id_clase
    INNER JOIN grupo g ON c.id_grupo = g.id_grupo";

$result = mysqli_query($conexion, $query);

// Verificar si la consulta tiene errores
if (!$result) {
    die('Error en la consulta: ' . mysqli_error($conexion));
}

// Obtener los datos en un array
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Generar la tabla en el PDF
$pdf->FancyTable($header, $data);

// Output del PDF
$pdf->Output('I', 'Reporte_Participantes_Orquideas_Tabla_Grupo_Clase.pdf');
?>
