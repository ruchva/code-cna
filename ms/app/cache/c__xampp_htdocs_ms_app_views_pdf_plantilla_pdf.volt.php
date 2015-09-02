<?php
require_once(__DIR__ . '/../../public/assets/tcpdf/tcpdf.php');
require_once(__DIR__ . '/../../public/assets/fpdi/fpdi.php');
class PDF extends FPDI
{
    /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx;

    /**
     * Draw an imported PDF logo on every page
     */
    function Header()
    {
        if (is_null($this->_tplIdx)) {
            $this->setSourceFile("img/plantilla.pdf");
            $this->_tplIdx = $this->importPage(1);
        } else {
            $this->setSourceFile("img/blanco.pdf");
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx, 0, 0);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('times', 'I', 6);
        $this->Cell(0, 10, 'Sistema Integrado Institucional ©' . date('Y'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function MultiRow($left, $right) {
        // MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)

        $page_start = $this->getPage();
        $y_start = $this->GetY();

        // write the left cell
        $this->MultiCell(70, 0, $left, 1, 'R', 1, 2, '', '', true, 0);

        $page_end_1 = $this->getPage();
        $y_end_1 = $this->GetY();

        $this->setPage($page_start);

        // write the right cell
        $this->MultiCell(0, 0, $right, 1, 'J', 0, 1, $this->GetX() ,$y_start, true, 0);

        $page_end_2 = $this->getPage();
        $y_end_2 = $this->GetY();

        // set the new row position by case
        if (max($page_end_1,$page_end_2) == $page_start) {
            $ynew = max($y_end_1, $y_end_2);
        } elseif ($page_end_1 == $page_end_2) {
            $ynew = max($y_end_1, $y_end_2);
        } elseif ($page_end_1 > $page_end_2) {
            $ynew = $y_end_1;
        } else {
            $ynew = $y_end_2;
        }

        $this->setPage(max($page_end_1,$page_end_2));
        $this->SetXY($this->GetX(),$ynew);
    }
}

// initiate PDF
$pdf = new PDF('P', 'mm', 'Letter', true, 'UTF-8', false);

$pdf->SetCreator('ru.develop.net');
$pdf->SetAuthor('Area de Sistemas');
$pdf->SetSubject('');
$pdf->SetKeywords('');

$pdf->SetMargins(PDF_MARGIN_LEFT, 40, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(true, 40);
$pdf->setFontSubsetting(false);

$pdf->SetMargins(10, 13, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
$pdf->SetCompression ($compress=true);


$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// add a page
$pdf->AddPage();

$estiloQR = array('border'=>1, 'vpadding'=>'auto', 'hpadding'=>'auto', 'fgcolor'=>array(0,0,0), 'bgcolor'=>array(255,255,255), 'module_width'=>1, 'module_height'=>1);
$pdf->write2DBarcode('http://www.ru.develop.net.bo/aplicacion/controlador/accion/parametro', 'QRCODE,L', 171, 5    , 55, 55, $estiloQR, 'N');


$pdf->SetTextColor(0, 0, 0);
$pdf->setCellPaddings(1, 0.5, 1, 0);
$pdf->setCellMargins(0, 0, 0, 0);
$pdf->SetFillColor(255, 255, 127);

$contenido = "007 LICENCIA PARA MATAR";

$pdf->SetFont('times', 'B', 10);

$pdf->ln();
$pdf->MultiRow('CÓDIGO ÚNICO', $contenido."\n");
$pdf->MultiRow('FECHA Y HORA SOLICITUD ', $fecha."\n");

if(is_object($ubicacion)) {
    $pdf->MultiRow('DEPARTAMENTO', $ubicacion->getDepartamento()."\n");
    $pdf->MultiRow('PROVINCIA', $ubicacion->getProvincia()."\n");
    $pdf->MultiRow('MUNICIPIO', $ubicacion->getNombre()."\n");
}

$pdf->MultiRow('CANTIDAD DE SERVICIOS SOLICITADOS', count($servicios)."\n\n");
if(is_object($servicios)) {
   
    $concatenados = "";
    $sw = TRUE;
    foreach($servicios as $servicio) {
        if($sw) {
            $concatenados = $concatenados.$servicio->getNombre().'(Monto: '.$servicio->getMonto().' Bs.)';
            $sw = FALSE;
        }
        else
            $concatenados = $concatenados.', '.$servicio->getNombre().'(Monto: '.$servicio->getMonto().' Bs.)';
    }
    $pdf->MultiRow('DETALLE DE SERVICIOS SOLICITADOS', $concatenados."\n");
}

$pdf->ln(40);
$pdf->SetFont('freesans', 'I', 8);
$pdf->MultiCell(100, 2, '', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(100, 2, '', 0, 'C', 0, 1, '', '', true);
$pdf->MultiCell(100, 2, '___________________________________________________', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(100, 2, '___________________________________________________', 0, 'C', 0, 1, '', '', true);
$pdf->MultiCell(100, 2, 'Sello y Firma Funcionario', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(100, 2, 'Firma Recibido', 0, 'C', 0, 1, '', '', true);
$pdf->MultiCell(100, 2, 'El presente Certificado:', 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(100, 2, 'a) NO otorga derecho de prioridad sobre el área solicitada. ', 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(100, 2, 'b) NO otorga derecho alguno, ni autoriza la realización de actividades.', 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(120, 2, 'c) SI otorga la reserva temporal del área solicitada, sujeta al plazo establecido por Ley y a la formalización de la solicitud.', 0, 'L', 0, 1, '', '', true);
$pdf->MultiCell(150, 2, 'La información contenida en el presente certificado está sujeta a confirmación y disponibilidad dentro de la etapa de informe técnico, tomando en cuenta las previsiones establecidas en el artículo 26, parágrafo III, artículos 93 y 220 de la Ley Nº 535; y otros criterios de disponibilidad establecidos.', 0, 'L', 0, 1, '', '', true);
$pdf->Output('ruchva.pdf', 'I');