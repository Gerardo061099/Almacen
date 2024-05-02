<?php
require('../fpdf/fpdf.php');
include('abrir_conexion.php');
class PDF extends FPDF {
// Cabecera de página
    function Header() {
        $this->SetFont('Times','B',15);
        $this->Image('../img/titulo.jpg',25,5,150);
        $this->setXY(70,30);
        $this->Cell(50,15,'Reporte de Herramientas',0,0,'C',0);
        $this->Ln(20);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','B',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
    protected $widths;
    protected $aligns;

    function SetWidths($w) {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a) {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data,$setX) {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 5*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h,$setX);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h,'DF');
            // Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h,$setX) {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger){
            $this->AddPage($this->CurOrientation);
            $this->SetX($setX);

            $this->SetFont('Helvetica','B',8);
            $this->SetFillColor(81, 86, 119);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(10,8,'ID',1,0,'C',1);
            $this->Cell(20,8,'Solicitante',1,0,'C',1);
            $this->Cell(22,8,'Apellidos',1,0,'C',1);
            $this->Cell(16,8,'Nombre',1,0,'C',1);
            $this->Cell(25,8,'Descripcion',1,0,'C',1);
            $this->Cell(25,8,'Material',1,0,'C',1);
            $this->Cell(10,8,'Gav',1,0,'C',1);
            $this->Cell(12,8,'Ancho',1,0,'C',1);
            $this->Cell(10,8,'Largo',1,0,'C',1);
            $this->Cell(10,8,'Stock',1,0,'C',1);
            $this->Cell(20,8,'Fecha',1,1,'C',1);
            $this->SetFont('Helvetica','',8);
            
            $this->SetFillColor(246, 246, 246);
            $this->SetTextColor(0, 0, 0);
        }
        if($setX == 100) {
            $this->SetX(100);
        } else {
            $this->SetX($setX);
        }
        
    }

    function NbLines($w, $txt) {
        // Compute the number of lines a MultiCell of width w will take
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}


// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,50);
$pdf->SetX(10);
$pdf->SetFont('Helvetica','B',8);
$pdf->SetFillColor(81, 86, 119);
$pdf->SetTextColor(255, 255, 255);
//$pdf->SetDrawColor();
$pdf->Cell(10,8,'ID',1,0,'C',1);
$pdf->Cell(20,8,'Solicitante',1,0,'C',1);
$pdf->Cell(22,8,'Apellidos',1,0,'C',1);
$pdf->Cell(16,8,'Nombre',1,0,'C',1);
$pdf->Cell(25,8,'Descripcion',1,0,'C',1);
$pdf->Cell(25,8,'Material',1,0,'C',1);
$pdf->Cell(10,8,'Gav',1,0,'C',1);
$pdf->Cell(12,8,'Ancho',1,0,'C',1);
$pdf->Cell(10,8,'Largo',1,0,'C',1);
$pdf->Cell(10,8,'Stock',1,0,'C',1);
$pdf->Cell(20,8,'Fecha',1,1,'C',1);
$pdf->SetFont('Helvetica','',8);
$pdf->SetFillColor(246, 246, 246);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetWidths(array(10,20,22,16,25,25,10,12,10,10,20));
$herramientasquery = mysqli_query($conexion,"SELECT s.id_solicitud,e.nombre as solicitante,e.apellidos,h.Nombre as herramienta,c.Descripcion,c.Material,g.Num_gavilanes AS Gav,m.Largo,m.Ancho,d.cantidad,s.Fecha from $tbsoli_db10 s inner join $tbdet_db4 d on s.id_solicitud = d.id_solicitud inner join $tbherr_db7 h on d.id_herramientas = h.id_herramienta inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas inner join $tbem_db5 e on s.id_empleado = e.id_empleado ORDER BY s.id_solicitud DESC"); 
$result_data = mysqli_fetch_all($herramientasquery,MYSQLI_ASSOC);

$pdf->SetTextColor(1, 1, 1);
for ($i=0; $i < count($result_data); $i++) { 
    $pdf->Row(array($result_data[$i]['id_solicitud'],$result_data[$i]['solicitante'],$result_data[$i]['apellidos'],$result_data[$i]['herramienta'],$result_data[$i]['Descripcion'],$result_data[$i]['Material'],$result_data[$i]['Gav'],$result_data[$i]['Ancho'],$result_data[$i]['Largo'],$result_data[$i]['cantidad'],$result_data[$i]['Fecha']),10);
}


$pdf->Output();
include('cerrar_conexion.php');
?>