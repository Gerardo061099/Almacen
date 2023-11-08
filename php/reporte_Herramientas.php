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
}

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,50);
$pdf->SetX(6);
$pdf->SetFont('Helvetica','B',10);
$pdf->SetFillColor(81, 86, 119);
$pdf->SetTextColor(255, 255, 255);
//$pdf->SetDrawColor();
$pdf->Cell(10,8,'N',1,0,'C',1);
$pdf->Cell(16,8,'Nombre',1,0,'C',1);
$pdf->Cell(38,8,'Material',1,0,'C',1);
$pdf->Cell(38,8,'Descripcion',1,0,'C',1);
$pdf->Cell(16,8,'Gavilan',1,0,'C',1);
$pdf->Cell(20,8,'Ancho',1,0,'C',1);
$pdf->Cell(20,8,'Largo',1,0,'C',1);
$pdf->Cell(20,8,'Stock',1,0,'C',1);
$pdf->Cell(20,8,'Stock min.',1,1,'C',1);
$pdf->SetTextColor(1, 1, 1);
$herramientasquery = mysqli_query($conexion,"SELECT h.id_herramienta AS id,h.Nombre AS nombre,c.material AS material,c.descripcion AS descripcion,g.Num_gavilanes AS gavilanes,m.Ancho AS ancho,m.Largo AS largo,h.cantidad_minima AS stock_m,h.cantidad AS stock FROM $tbherr_db7 h inner join $tbcat_db3 c on h.id_categoria = c.id_categoria inner join $tbgav_db6 g on h.id_gavilanes = g.id_gav inner join $tbmed_db9 m on h.id_medidas = m.id_medidas ORDER BY h.id_herramienta"); 
while ($result_data = mysqli_fetch_array($herramientasquery)) {
    $pdf->SetX(6);
    $pdf->SetFont('Helvetica','',8);
    $pdf->Cell(10,8,''.$result_data['id'],1,0,'C',0);
    $pdf->Cell(16,8,$result_data['nombre'],1,0,'C',0);
    $pdf->Cell(38,8,$result_data['material'],1,0,'C',0);
    $pdf->Cell(38,8,$result_data['descripcion'],1,0,'C',0);
    $pdf->Cell(16,8,$result_data['gavilanes'],1,0,'C',0);
    $pdf->Cell(20,8,$result_data['ancho'],1,0,'C',0);
    $pdf->Cell(20,8,$result_data['largo'],1,0,'C',0);
    $pdf->Cell(20,8,$result_data['stock'],1,0,'C',0);
    $pdf->Cell(20,8,$result_data['stock_m'],1,1,'C',0);
}
$pdf->Output();
?>