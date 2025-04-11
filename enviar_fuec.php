<?php
require 'fpdf.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'FORMULARIO FUEC SIMPLE',0,1,'C');
        $this->Ln(5);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,'Ejemplo de formulario sin PHPMailer ni fuentes externas',0,1);
$pdf->Output();
?>
