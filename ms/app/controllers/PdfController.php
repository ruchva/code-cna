<?php
use Phalcon\Mvc\View as View;
use Municipio as Municipios;
use Servicio as Servicio;

class PdfController extends \Phalcon\Mvc\Controller
{
	public function indexAction(){

    }

    public function doc_pdfAction($id_municipio = NULL){
    	$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    	$contenido_controller = "Contenido 1";
    	$this->view->setVar('contenido_controller', $contenido_controller);

    	if(isset($id_municipio)) {    		
    		$ubicacion = Municipios::findFirst($id_municipio);
    		$this->view->setVar('ubicacion', $ubicacion);
    	}    	
    }

    public function plantilla_pdfAction($id_municipio = NULL){
    	$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    	$contenido_controller = "CONTENIDO CONTROLLER";
    	$ahora = $this->ahora();
    	$this->view->setVar('fecha', $ahora);
    	$this->view->setVar('contenido', $contenido_controller);

    	if(isset($id_municipio)) {    		
    		$ubicacion = Municipios::findFirst($id_municipio);
    		$this->view->setVar('ubicacion', $ubicacion);
    	}
    	
    	$monto = 1000;
    	$servicios = Servicio::find(array("monto > $monto AND activo"));
    	if(is_object($servicios)) {
    		$this->view->setVar('servicios', $servicios);
    	}    	
    }

    
    /****************************************************** AYUDA*/
    public function corregirFormatoFechaHora($fecha_hora) {
        if(strlen($fecha_hora) > 1) {
            $partes_fecha_hora = explode(' ', $fecha_hora);
            $fecha = '';
            $hora = '';
            if(strpos($partes_fecha_hora[0], ':') !== FALSE) {
                $fecha = $this->corregirFormatoFecha($partes_fecha_hora[1]);
                $hora = $partes_fecha_hora[0];
            }
            else {
                $fecha = $this->corregirFormatoFecha($partes_fecha_hora[0]);
                $hora = $partes_fecha_hora[1];
            }
            return $fecha . " " . $hora;
        }
        else {
            return $fecha_hora;
        }
    }

    public function corregirFormatoFecha($fecha) {
        if(strlen($fecha)) {
            $partes = explode(' ', $fecha);
            if(strlen($partes[0]) == 0) {
                $fecha = $partes[1];
            }
            else {
                $fecha = $partes[0];
            }
            //$this->flashSession->error($fecha);
            $partes = explode('-', $fecha);
            if(strlen($partes[0]) == 4) {
                return $partes[2] . '-' . $partes[1] . '-' . $partes[0];
            }
            else {
                return $fecha;
            }
        }
        else {
            return $fecha;
        }
    }

    public function corregirFormatoHora($hora) {
        if(strlen($hora)) {
            $partes = explode(' ', $hora);
            return $partes[1];

        }
        else {
            return $hora;
        }
    }

    public function fecha() {
        return date('d-m-Y');
    }

    public function hora() {
        return date('H:i:s');
    }

    public function ahora() {
        return date('d-m-Y H:i:s');
    }

    public function anio() {
        return date('Y');
    }
}