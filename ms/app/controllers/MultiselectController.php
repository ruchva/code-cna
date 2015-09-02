<?php
use Phalcon\Mvc\View as View;
use Persona as Persona;
use Cargo as Cargo;
use Municipio as Municipios;
use PersonaCargo as PersonaCargo;

class MultiselectController extends \Phalcon\Mvc\Controller
{

    public function indexAction(){

    }
	
	public function MultiselectAction(){
		echo "desde metodo accion";
		$dato_controller = "DATO OBTENIDO";		
		$this->view->setVar('dato_view', $dato_controller);		
	}
	
	public function DatosAction(){
		$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
	    echo $datos = '[{"caption":"Manuel Mujica Lainez","value":4},
		{"caption":"Gustavo Nielsen","value":3},
		{"caption":"Silvina Ocampo","value":3},
		{"caption":"Victoria Ocampo", "value":3},
		{"caption":"Hector German Oesterheld", "value":3},
		{"caption":"Olga Orozco", "value":3},
		{"caption":"Juan L. Ortiz", "value":3},
		{"caption":"Alicia Partnoy", "value":3},
		{"caption":"Roberto Payro", "value":3},
		{"caption":"Ricardo Piglia", "value":3},
		{"caption":"Felipe Pigna", "value":3},
		{"caption":"Alejandra Pizarnik", "value":3},
		{"caption":"Antonio Porchia", "value":3},
		{"caption":"Juan Carlos Portantiero", "value":3},
		{"caption":"Manuel Puig", "value":3},
		{"caption":"Andres Rivera", "value":3},
		{"caption":"Mario Rodriguez Cobos", "value":3},
		{"caption":"Arturo Andres Roig", "value":3},
		{"caption":"Ricardo Rojas", "value":3}]';

		$this->view->setVar('datos', $datos);

		/*<?php 
		echo "<br />";
		echo "<br />";
		print_r(json_decode($datos, true));
		?>*/		
	}
	
	public function DatosAjaxAction(){
		$this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
		$tag = '%' . strtolower($this->request->get('tag')) . '%';//lo hace mas veloz
        $tag = str_replace(' ', '?', $tag);//lo hace mas veloz
        /*
        SELECT p.id AS id_persona
		,concat(p.nombre,' ',p.apellido, ' - Cedula: ', p.cedula, ' - Cargo: ', c.nombre) AS persona
		FROM persona p
		JOIN persona_cargo pc ON p.id = pc.fk_persona
		JOIN cargo c ON c.id = pc.fk_cargo
		--WHERE pc.fk_cargo = 4
		ORDER BY p.id
		*/
        $builder = $this->modelsManager->createBuilder();
        $builder = $builder->addFrom('Persona', 'p');
        $builder->join('PersonaCargo', 'pc.fk_persona = p.id', 'pc');
        $builder->join('Cargo', 'pc.fk_cargo = c.id', 'c');        
        //$builder->where('pc.fk_cargo = 4');
        $datos = $builder->columns("p.id AS id_persona, CONCAT(p.nombre,' ',p.apellido, ' - Cedula: ', p.cedula, ' - Cargo: ', c.nombre) AS persona")
            ->orderBy('p.id')
            ->getQuery()
            ->execute();
        $this->generarDatosAjax($datos, 'id_persona', 'persona');
	}

	private function generarDatosAjax($datos, $campo_valor, $campo_texto, $camposMetodos = FALSE) {
        $this->view->disable();
        if ($this->request->isGet()/* && $this->request->isAjax()*/) {
            $json = array();
            if(is_object($datos) || is_array($datos)) {
                foreach ($datos as $dato) {
                    if ($camposMetodos) {
                    	//$json[] = array('key' => '' . $dato->$campo_valor(), 'value' => '' . $dato->$campo_texto());
                        $json[] = array('value' => '' . $dato->$campo_valor(), 'caption' => '' . $dato->$campo_texto());
                    } else {
                    	//$json[] = array('key' => '' . $dato->$campo_valor, 'value' => '' . $dato->$campo_texto);
                        $json[] = array('value' => '' . $dato->$campo_valor, 'caption' => '' . $dato->$campo_texto);
                    }
                }
            }
            $this->response->setJsonContent($json);
            $this->response->setStatusCode(200, "OK");
            $this->response->send();
        } else {
            $this->response->setStatusCode(404, "Not Found");
        }
    }

    public function municipiosAction() {
        $municipios = Municipios::find();
        $this->generarDatosAjax($municipios, 'getId', 'getUbicacion', TRUE);
    }

}

