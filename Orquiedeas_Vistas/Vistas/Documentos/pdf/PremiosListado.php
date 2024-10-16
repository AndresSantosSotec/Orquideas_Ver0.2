<?php
require '../fpdf186/fpdf.php';

class PDF extends FPDF
{
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    function Row($data)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 6 * $nb;
        $this->CheckPageBreak($h);
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);

            if ($i == count($data) - 1) {
                $this->MultiCell($w, 6, utf8_decode($data[$i]), 0, $a);
            } else {
                $this->Cell($w, 6, utf8_decode($data[$i]), 0, 0, $a);
            }
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Listado de Orquideas Ganadoras', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function LoadData($conn)
    {
        // Consulta para traer los datos requeridos, incluyendo Cod_Grupo, id_grupo, y id_clase
        $query = "
            SELECT 
                gr.Cod_Grupo, gr.id_grupo, c.id_clase, 
                o.id_orquidea, o.nombre_planta, 
                p.nombre AS propietario, g.posicion
            FROM 
                tb_ganadores g
            JOIN 
                tb_orquidea o ON g.id_orquidea = o.id_orquidea
            JOIN 
                tb_participante p ON o.id_participante = p.id
            JOIN 
                clase c ON o.id_clase = c.id_clase
            JOIN 
                grupo gr ON c.id_grupo = gr.id_grupo
            ORDER BY 
                c.id_clase, gr.Cod_Grupo";

        $result = $conn->query($query);

        if (!$result) {
            die("Error en la consulta SQL: " . $conn->error);
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $row['nombre_planta'] = strlen($row['nombre_planta']) > 25 ? substr($row['nombre_planta'], 0, 22) . '...' : $row['nombre_planta'];
            $row['Clase_Grupo'] = "{$row['Cod_Grupo']}  {$row['id_grupo']} / {$row['id_clase']}";
            $data[] = $row;
        }
        return $data;
    }

    function CreateTable($header, $data)
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetWidths([40, 20, 60, 40, 25, 15, 15, 15, 30]);

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($this->widths[$i], 7, utf8_decode($header[$i]), 1, 0, 'C');
        }
        $this->Ln();

        foreach ($data as $row) {
            $pos1 = ($row['posicion'] == 1) ? 'X' : '';
            $pos2 = ($row['posicion'] == 2) ? 'X' : '';
            $pos3 = ($row['posicion'] == 3) ? 'X' : '';
            $mh = '';

            $this->Row([
                $row['Clase_Grupo'], 
                $row['id_orquidea'], 
                $row['nombre_planta'], 
                $row['propietario'], 
                'Asociacion', 
                $pos1, $pos2, $pos3, $mh
            ]);
        }
    }
}

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'bd_orquideas';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

ob_start();

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$header = ['Clase / Grupo', 'No.', 'Nombre de la Planta', 'Propietario', 'Asociacion', '1', '2', '3', 'Trofeo(s)'];
$data = $pdf->LoadData($conn);

$pdf->CreateTable($header, $data);
$pdf->Output();

$conn->close();
ob_end_flush();
?>
