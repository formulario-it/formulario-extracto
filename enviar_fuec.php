<?php
require 'fpdf.php';

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'FORMULARIO FUEC FUNCIONAL',0,1,'C');
        $this->Ln(5);
    }

    function Field($label, $value) {
        $this->SetFont('Arial','B',10);
        $this->Cell(60,8,utf8_decode($label),1);
        $this->SetFont('Arial','',10);
        $this->Cell(130,8,utf8_decode($value),1);
        $this->Ln();
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->Field("Ejemplo", "PDF generado correctamente sin errores de fuentes.");
$pdf->Output();
?>
