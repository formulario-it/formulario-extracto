<?php
require_once('fpdf.php');
require_once('fpdi.php');
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');
require_once('PHPMailer/src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

<<<<<<< HEAD
require 'fpdf.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Generar PDF
class PDF extends FPDF {
    function Header() {
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
=======
// Crear nuevo PDF con base en pdf.pdf
$pdf = new FPDI();
>>>>>>> f1345d4e1da9546d061909fbaee633e4b258333d
$pdf->AddPage();
$pdf->setSourceFile("pdf.pdf");
$tpl = $pdf->importPage(1);
$pdf->useTemplate($tpl);

<<<<<<< HEAD
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

=======
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

>>>>>>> f1345d4e1da9546d061909fbaee633e4b258333d
// Enviar por correo
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Cambia según el servidor
    $mail->SMTPAuth = true;
<<<<<<< HEAD
    $mail->Username = 'extractofuec@gmail.com; // <-- CAMBIA ESTO
    $mail->Password = 'xnpjdayahlvgaflq'; // <-- CAMBIA ESTO
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('extractofuec@gmail.com', 'Sistema FUEC');
    $mail->addAddress('extractofuec@gmail.com'); // <-- CAMBIA ESTO TAMBIÉN

    $mail->isHTML(true);
    $mail->Subject = 'FUEC Generado';
    $mail->Body = 'Adjunto encontrarás el FUEC generado desde el formulario.';

    $mail->addAttachment($pdf_filename);
    $mail->send();

    echo 'FUEC enviado correctamente por correo.';
    unlink($pdf_filename); // Borrar archivo después de enviar
} catch (Exception $e) {
    echo "Error al enviar el FUEC: {$mail->ErrorInfo}";
=======
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
>>>>>>> f1345d4e1da9546d061909fbaee633e4b258333d
}
?>
