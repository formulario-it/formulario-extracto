<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'fpdf.php';
require 'fpdi.php';
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdf = new \setasign\Fpdi\Fpdi();

    $pdf->AddPage();
    $pdf->setSourceFile("pdf.pdf");
    $template = $pdf->importPage(1);
    $pdf->useTemplate($template, 0, 0);

    $pdf->SetFont("Helvetica");
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFontSize(10);

    // Ejemplo de campos que podrías recibir
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

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "extractofuec@gmail.com"; // tu correo
        $mail->Password = "TU_CLAVE_DE_APP";
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("extractofuec@gmail.com", "FUEC App");
        $mail->addAddress("extractofuec@gmail.com");
        $mail->Subject = "Formulario FUEC enviado";
        $mail->Body = "Adjunto el formulario rellenado en PDF.";
        $mail->addAttachment($outputPath);

        $mail->send();
        echo "Correo enviado con éxito.";
    } catch (Exception $e) {
        echo "Error al enviar correo: {$mail->ErrorInfo}";
    }
} else {
    echo "Acceso inválido.";
}
?>
