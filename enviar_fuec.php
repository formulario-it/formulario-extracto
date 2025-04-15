<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'fpdf/fpdf.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Formulario FUEC');
$path = 'fuec_formulario.pdf';
$pdf->Output('F', $path);
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'extractofuec@gmail.com';
$mail->Password = 'xnpjdayahlvgaflq';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('extractofuec@gmail.com', 'Formulario FUEC');
$mail->addAddress('extractofuec@gmail.com');
$mail->Subject = 'FUEC generado';
$mail->Body = 'PDF FUEC adjunto.';
$mail->addAttachment($path);
$mail->send();
unlink($path);
?>