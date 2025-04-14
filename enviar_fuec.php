<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'fpdf.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Generar PDF
class PDF extends FPDF {
    function Header() {
        \$this->Image('pdf.pdf', 0, 0, 210, 297); // Fondo PDF
        // Fondo visual
        $this->Image('pdf.pdf', 0, 0, 210, 297); // Tamaño A4
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'FORMATO UNICO DE EXTRACTO DEL CONTRATO - FUEC',0,1,'C');
        $this->Ln(5);
    }

    function Section($title) {
        $this->SetFont('Arial','B',12);
        $this->SetFillColor(230,230,230);
        $this->Cell(0,10,$title,0,1,'L', true);
    }

    function Field($label, $value) {
        $this->SetFont('Arial','B',10);
        $this->Cell(60,8,iconv('UTF-8','ISO-8859-1',$label),1);
        $this->SetFont('Arial','',10);
        $this->Cell(130,8,iconv('UTF-8','ISO-8859-1',$value),1);
        $this->Ln();
    }
}

$pdf = new PDF();
$pdf->AddPage();

$secciones = [
    "Datos del Contrato" => ['contrato','contratante','ccnit','objeto','origen','convenio'],
    "Vigencia del Contrato" => ['fecha_inicial','fecha_vencimiento'],
    "Características del Vehículo" => ['placa','modelo','marca','clase','num_interno','tarjeta_operacion'],
    "Datos del Conductor 1" => ['conductor1_nombre','conductor1_cedula','conductor1_licencia','conductor1_conduccion','conductor1_vigencia'],
    "Datos del Conductor 2" => ['conductor2_nombre','conductor2_cedula','conductor2_licencia','conductor2_conduccion','conductor2_vigencia']
];

foreach ($secciones as $titulo => $campos) {
    $pdf->Section($titulo);
    foreach ($campos as $campo) {
        $valor = $_POST[$campo] ?? '';
        $pdf->Field(str_replace('_', ' ', strtoupper($campo)), $valor);
    }
}

// Guardar el PDF
$pdf_filename = 'FUEC_' . date('Ymd_His') . '.pdf';
$pdf->Output('F', $pdf_filename);

// Enviar por correo
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Cambia según el servidor
    $mail->SMTPAuth = true;
    $mail->Username = 'tu_correo@gmail.com'; // <-- CAMBIA ESTO
    $mail->Password = 'tu_contraseña_o_app_password'; // <-- CAMBIA ESTO
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('tu_correo@gmail.com', 'Sistema FUEC');
    $mail->addAddress('tu_correo@gmail.com'); // <-- CAMBIA ESTO TAMBIÉN

    $mail->isHTML(true);
    $mail->Subject = 'FUEC Generado';
    $mail->Body = 'Adjunto encontrarás el FUEC generado desde el formulario.';

    $mail->addAttachment($pdf_filename);
    $mail->send();

    echo 'FUEC enviado correctamente por correo.';
    unlink($pdf_filename); // Borrar archivo después de enviar
} catch (Exception $e) {
    echo "Error al enviar el FUEC: {$mail->ErrorInfo}";
}
?>
