<?php
require 'fpdf.php';
require 'fpdi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdf = new FPDI();

    $pdf->AddPage();
    $pdf->setSourceFile("pdf.pdf");
    $template = $pdf->importPage(1);
    $pdf->useTemplate($template, 0, 0);

    $pdf->SetFont("Helvetica");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFontSize(10);

    // Campos de ejemplo
    $nombre = $_POST['nombre'] ?? '';
    $cedula = $_POST['cedula'] ?? '';
    $destino = $_POST['destino'] ?? '';

    $pdf->SetXY(50, 60);
    $pdf->Write(0, $nombre);

    $pdf->SetXY(50, 70);
    $pdf->Write(0, $cedula);

    $pdf->SetXY(50, 80);
    $pdf->Write(0, $destino);

    $outputPath = "fuec_generado.pdf";
    $pdf->Output("F", $outputPath);

    // Envío por correo (modo simplificado)
    $to = "extractofuec@gmail.com";
    $subject = "Formulario FUEC enviado";
    $message = "Adjunto el formulario FUEC.";
    $headers = "From: no-reply@formulario-extracto
";

    mail($to, $subject, $message, $headers);
    echo "Formulario enviado con éxito.";
} else {
    echo "Acceso no permitido.";
}
?>
