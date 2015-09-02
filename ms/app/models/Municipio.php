<?php

class Municipio extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $nombre;

    /**
     *
     * @var string
     */
    protected $provincia;

    /**
     *
     * @var string
     */
    protected $departamento;

    /**
     *
     * @var integer
     */
    protected $codigo_municipio;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field nombre
     *
     * @param string $nombre
     * @return $this
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Method to set the value of field provincia
     *
     * @param string $provincia
     * @return $this
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Method to set the value of field departamento
     *
     * @param string $departamento
     * @return $this
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Method to set the value of field codigo_municipio
     *
     * @param integer $codigo_municipio
     * @return $this
     */
    public function setCodigoMunicipio($codigo_municipio)
    {
        $this->codigo_municipio = $codigo_municipio;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Returns the value of field provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Returns the value of field departamento
     *
     * @return string
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Returns the value of field codigo_municipio
     *
     * @return integer
     */
    public function getCodigoMunicipio()
    {
        return $this->codigo_municipio;
    }

    /**
     * DENTRO DEL MODELO
     * @return string
     */
    public function getUbicacion()
    {
        return $this->departamento.' - '.$this->provincia.' - '.$this->nombre.' - '.$this->codigo_municipio;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("");
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'nombre' => 'nombre', 
            'provincia' => 'provincia', 
            'departamento' => 'departamento', 
            'codigo_municipio' => 'codigo_municipio'
        );
    }

}
