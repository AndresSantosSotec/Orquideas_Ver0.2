<?php

require('../fpdf186/fpdf.php');
include 'Conexion_bd.php';

// Obtener las fechas del formulario
$startDate = $_GET['start_date'];
$endDate = $_GET['end_date'];

// Validar que las fechas no estén vacías
if ($startDate && $endDate) {
    // Convertir fechas al formato correcto para MySQL
    $startDate = date('Y-m-d', strtotime($startDate));
    $endDate = date('Y-m-d', strtotime($endDate));

    // Modificar la consulta para incluir el filtro de fechas y el campo 'origen'
    $query = "
        SELECT 
            o.id_orquidea, 
            o.nombre_planta, 
            g.Cod_Grupo, 
            c.id_clase, 
            p.nombre AS nombre_participante,
            o.origen  -- Aquí incluimos el campo 'origen'
        FROM tb_orquidea o
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN tb_participante p ON o.id_participante = p.id
        WHERE o.fecha_creacion BETWEEN '$startDate' AND '$endDate'
        ORDER BY o.id_orquidea";
    
    $result = mysqli_query($conexion, $query);

    // Generar el PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Título del reporte
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Asociacion Altaverapacense de Orquideologia', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Coban, Alta Verapaz', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Listado General de Plantas', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Desde: ' . date('d/m/Y', strtotime($startDate)) . ' Hasta: ' . date('d/m/Y', strtotime($endDate)), 0, 1, 'C');
    $pdf->Ln(10);

    // Encabezado de tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, 'No', 1);
    $pdf->Cell(60, 10, 'Planta', 1);
    $pdf->Cell(30, 10, 'Clas', 1);
    $pdf->Cell(10, 10, 'Es', 1);  // Columna para especie
    $pdf->Cell(10, 10, 'Hi', 1);  // Columna para híbrida
    $pdf->Cell(60, 10, 'Nombre Participante', 1);
    $pdf->Ln();

    // Datos
    $pdf->SetFont('Arial', '', 10);
    $contador = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        $clas = $row['Cod_Grupo'] . "/" . $row['id_clase'];
        
        // Determinar si es especie o híbrida según el campo 'origen'
        $especie = ($row['origen'] === 'Especie') ? 'X' : '';
        $hibrida = ($row['origen'] === 'Hibrida') ? 'X' : '';
        
        // Agregar los datos de cada fila
        $pdf->Cell(10, 10, $contador, 1);
        $pdf->Cell(60, 10, $row['nombre_planta'], 1);
        $pdf->Cell(30, 10, $clas, 1);
        $pdf->Cell(10, 10, $especie, 1, 0, 'C');  // Marca "X" si es especie
        $pdf->Cell(10, 10, $hibrida, 1, 0, 'C');  // Marca "X" si es híbrida
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
} else {
    echo "Por favor, selecciona un rango de fechas válido.";
}
?>
