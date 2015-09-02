<?php
require_once(__DIR__ .'/../../public/assets/tcpdf/tcpdf.php');
//require_once('tcpdf/tcpdf.php');
class MYPDF extends TCPDF {
    public function Header() {
        $image_file = 'img/header.png';
        $this->Image($image_file, 10, 5, 0, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->ln(30);
    }
    public function Footer() {
        $this->SetY(-54);
        $this->SetFont('freesans', '', 8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 4, '__________________________', 0, 1);
        $this->Cell(0, 4, 'Firma Entrega Servicio', 0, 1);
        $this->Cell(0, 4, 'Se debe proceder a depositar el monto de:', 0, 1);
        $this->SetFont('courier', 'B', 14);
        $this->SetTextColor(5, 90, 200);
        $this->SetFont('freesans', '', 8);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 4, 'En la cuenta bancaria número:', 0, 1);
        $this->SetFont('courier', 'B', 14);
        $this->SetTextColor(5, 90, 200);
        $this->Cell(0, 5, '10000010918544 - BANCO UNION', 1, 1, 'C');
        $this->SetFont('times', 'I', 8);
        $this->Cell(0, 10, 'ru.develop.net ©' . date('Y'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
$pdf = new MYPDF('P', 'mm', 'Letter', true, 'UTF-8', false);

$pdf->SetCreator('ru.develop.net');
$pdf->SetAuthor('Area de Sistemas');
$pdf->SetSubject('');
$pdf->SetKeywords('');

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->SetAutoPageBreak(TRUE, 10);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetMargins(35, 35, 11);
$pdf->SetFooterMargin(0);

$pdf->AddPage();
$pdf->SetTextColor(0, 0, 0);
$pdf->setCellPaddings(0, 1, 0, 0);
$pdf->setCellMargins(0, 0, 0, 0);
$pdf->SetFillColor(255, 255, 127);

$contenido = "Este es el contenido de prueba blah blah blah";

if(isset($contenido_controller)) {
    $pdf->SetFont('times', 'B', 14);
    $pdf->MultiCell(0, 10, $contenido_controller, 0, 'C');
    switch ($contenido_controller) {
        case 'Contenido 1':
            goto contenido;
            break;
        case 'Contenido 2':
            goto contenido_controller;
            break;
        default:
            break;
    }
}

contenido:
if(is_object($ubicacion)) {
    $pdf->MultiCell(75,5,'DEPARTAMENTO: ',0,'R', 0, 0, '', '', true);
    $pdf->MultiCell(70,5,$ubicacion->getDepartamento() ,0,'L', 0, 1, '', '', true);
    $pdf->MultiCell(75,5,'PROVINCIA: ',0,'R', 0, 0, '', '', true);        
    $pdf->MultiCell(0,0,$ubicacion->getProvincia() ,0,'L', 0, 1, '', '', true);
    $pdf->MultiCell(75,5,'MUNICIPIO: ',0,'R', 0, 0, '', '', true);        
    $pdf->MultiCell(0,0,$ubicacion->getNombre() ,0,'L', 0, 1, '', '', true);
}

contenido_controller:
$pdf->ln(10);
$pdf->writeHTMLCell(165, '', '', '', $contenido, 0, 0, 0, true, 'J', true);


$codigo_qr = "www.ru.develop.net/ejemplo/controlador/accion/parametro";
$pdf->ln(4);
$pdf->SetFont('times', '', 11);
$y = $pdf->getY();
$estiloQR = array('border'=>2, 'vpadding'=>'auto', 'hpadding'=>'auto', 'fgcolor'=>array(0,0,0), 'bgcolor'=>false, 'module_width'=>1, 'module_height'=>1);
$pdf->write2DBarcode($codigo_qr, 'QRCODE,L', 10, 25, 35, 35, $estiloQR, 'N');
$pdf->Output('ruchva.pdf', 'I');