<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'fpdf.php';
require 'fpdi.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use setasign\Fpdi\Fpdi;

// Recoger datos del formulario
$nombre = $_POST['nombre'] ?? '';
$cedula = $_POST['cedula'] ?? '';
$destino = $_POST['destino'] ?? '';

// Crear PDF desde plantilla visual
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile('pdf.pdf');
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);

// Insertar datos en coordenadas específicas
$pdf->SetFont('Helvetica');
$pdf->SetFontSize(10);
$pdf->SetTextColor(0, 0, 0);

$pdf->SetXY(50, 60);
$pdf->Write(0, $nombre);

$pdf->SetXY(50, 70);
$pdf->Write(0, $cedula);

$pdf->SetXY(50, 80);
$pdf->Write(0, $destino);

// Guardar PDF temporal
$nombre_pdf = 'fuec_generado.pdf';
$pdf->Output('F', $nombre_pdf);

// Enviar por correo con PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'extractofuec@gmail.com'; // tu correo
    $mail->Password = 'TU_CLAVE_APP'; // clave de aplicación
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('extractofuec@gmail.com', 'Sistema FUEC');
    $mail->addAddress('extractofuec@gmail.com');
    $mail->Subject = 'Formulario FUEC enviado';
    $mail->Body = 'Se adjunta el formulario FUEC con los datos del cliente.';
    $mail->addAttachment($nombre_pdf);

    $mail->send();
    echo 'Formulario enviado correctamente.';
} catch (Exception $e) {
    echo 'Error al enviar correo: ', $mail->ErrorInfo;
}
?>
