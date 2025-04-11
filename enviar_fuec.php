<?php
require_once('fpdf.php');
require_once('fpdi.php');
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');
require_once('PHPMailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Crear nuevo PDF con base en pdf.pdf
$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile("pdf.pdf");
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);

// Estilo de fuente
$pdf->SetFont('Arial', '', 10);

// Posiciones: ajustá estas coordenadas según el diseño
// Ejemplo: contrato
$pdf->SetXY(40, 30);
$pdf->Cell(100, 10, utf8_decode($_POST['contrato'] ?? ''), 0, 1);

// contrato, contratante, ccnit, objeto, origen, convenio, etc.
// Agregá aquí las demás posiciones según el diseño del pdf.pdf

// Guardar el nuevo PDF
$pdf_output = 'fuec_formulario.pdf';
$pdf->Output($pdf_output, 'F');

// Enviar por correo
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'extractofuec@gmail.com';
    $mail->Password = 'xnpjdayahlvgaflq';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('extractofuec@gmail.com', 'Formulario FUEC');
    $mail->addAddress('extractofuec@gmail.com');
    $mail->Subject = 'Formulario FUEC - PDF con formato visual';
    $mail->Body = 'Adjunto el formulario FUEC con diseño oficial';

    $mail->addAttachment($pdf_output, 'fuec_formulario.pdf');
    $mail->send();

    unlink($pdf_output); // borrar el archivo temporal
    header('Location: index.html');
    exit();
} catch (Exception $e) {
    echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
