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
            g.nombre_grupo,  -- Obtener nombre del grupo
            c.nombre_clase,  -- Aquí obtenemos el nombre de la clase
            p.nombre AS nombre_participante,
            o.origen  -- Campo origen para determinar si es Especie o Híbrida
        FROM tb_orquidea o
        INNER JOIN grupo g ON o.id_grupo = g.id_grupo
        INNER JOIN clase c ON o.id_clase = c.id_clase
        INNER JOIN tb_participante p ON o.id_participante = p.id
        WHERE o.fecha_creacion BETWEEN '$startDate' AND '$endDate'
        ORDER BY g.Cod_Grupo, c.nombre_clase, o.nombre_planta";  // Ordenamos por grupo, clase y luego planta
    
    $result = mysqli_query($conexion, $query);

    // Verificar si la consulta retorna resultados
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "No se encontraron resultados para el rango de fechas seleccionado.";
        exit;
    }

    // Generar el PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Título del reporte
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, utf8_decode('Asociación Altaverapacense de Orquideología'), 0, 1, 'C');
    $pdf->Cell(0, 10, 'Coban, Alta Verapaz', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Listado General de Plantas por Clases', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Desde: ' . date('d/m/Y', strtotime($startDate)) . ' Hasta: ' . date('d/m/Y', strtotime($endDate)), 0, 1, 'C');
    $pdf->Ln(10);

    // Encabezado de tabla
    $pdf->SetFillColor(230, 230, 230); // Fondo gris claro
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(10, 10, 'No', 0);  // Sin borde
    $pdf->Cell(60, 10, 'Planta', 0);  // Sin borde
    $pdf->Cell(70, 10, 'Grupo/Clase', 0);  // Sin borde
    $pdf->Cell(10, 10, 'Es', 0);  // Sin borde
    $pdf->Cell(10, 10, 'Hi', 0);  // Sin borde
    $pdf->Cell(60, 10, 'Nombre Participante', 0);  // Sin borde
    $pdf->Ln();

    // Datos
    $pdf->SetFont('Arial', '', 10);
    $contador = 1;

    while ($row = mysqli_fetch_assoc($result)) {
        // Usar nombre_clase en lugar de id_clase
        $clas = utf8_decode($row['Cod_Grupo'] . " - " . $row['nombre_clase']);  // Mostrar grupo y clase
        
        // Determinar si es especie o híbrida según el campo 'origen'
        $especie = ($row['origen'] === 'Especie') ? 'X' : '';
        $hibrida = ($row['origen'] === 'Hibrida') ? 'X' : '';
        
        // Agregar los datos de cada fila
        $pdf->Cell(10, 10, $contador, 0, 0, 'C');  // Sin borde
        $pdf->Cell(60, 10, utf8_decode($row['nombre_planta']), 0);  // Sin borde
        $pdf->Cell(70, 10, $clas, 0);  // Sin borde
        $pdf->Cell(10, 10, $especie, 0, 0, 'C');  // Marca "X" si es especie
        $pdf->Cell(10, 10, $hibrida, 0, 0, 'C');  // Marca "X" si es híbrida
        $pdf->Cell(60, 10, utf8_decode($row['nombre_participante']), 0);  // Sin borde
        $pdf->Ln();
        
        $contador++;
    }

    // Pie de página con la fecha y el número de página
    $pdf->SetY(-15);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(0, 10, 'Generado el ' . date('d/m/Y'), 0, 0, 'L');
    $pdf->Cell(0, 10, 'Pagina ' . $pdf->PageNo(), 0, 0, 'R');

    // Salida del PDF
    $pdf->Output('I', 'Listado_Orquideas_Por_Clases.pdf');
} else {
    echo "Por favor, selecciona un rango de fechas válido.";
}
?>
