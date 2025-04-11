<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'fpdf/fpdf.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

class PDF extends FPDF {
    function Header() {
        // Logo
        $this->Image('logo.png', 10, 10, 40); // logo.png debe estar en el mismo directorio
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
    "DATOS DEL CONTRATO" => ['contrato','contratante','ccnit','objeto','origen','convenio'],
    "VIGENCIA DEL CONTRATO" => ['fecha_inicial','fecha_vencimiento'],
    "CARACTERISTICAS DEL VEHICULO" => ['placa','modelo','marca','clase','num_interno','tarjeta_operacion'],
    "DATOS DEL CONDUCTOR 1" => ['conductor1_nombre','conductor1_cedula','conductor1_licencia','conductor1_conduccion','conductor1_vigencia'],
    "DATOS DEL CONDUCTOR 2" => ['conductor2_nombre','conductor2_cedula','conductor2_licencia','conductor2_conduccion','conductor2_vigencia'],
    "RESPONSABLE DEL CONTRATANTE" => ['responsable_nombre','responsable_cedula','responsable_telefono','responsable_direccion']
];

foreach ($secciones as $titulo => $campos) {
    $pdf->Section($titulo);
    foreach ($campos as $campo) {
        $pdf->Field(ucwords(str_replace("_", " ", $campo)), $_POST[$campo] ?? '');
    }
    $pdf->Ln(2);
}

$pdf_file_name = 'fuec_formulario.pdf';
$pdf_path = __DIR__ . '/' . $pdf_file_name;
$pdf->Output($pdf_path, 'F');

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'extractofuec@gmail.com'; // REEMPLAZA
    $mail->Password = 'xnpjdayahlvgaflq'; // REEMPLAZA
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('extractofuec@gmail.com', 'Formulario FUEC');
    $mail->addAddress('extractofuec@gmail.com');
    $mail->Subject = 'Formulario FUEC enviado';
    $mail->Body = 'Adjunto encontrarás el formulario FUEC en formato PDF.';
    $mail->addAttachment($pdf_path, $pdf_file_name);

    $mail->send();
    unlink($pdf_path);
    header("Location: index.html");
    exit();
} catch (Exception $e) {
    echo "❌ Error al enviar el correo: {$mail->ErrorInfo}";
}
?>
