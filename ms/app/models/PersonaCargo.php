<?php

class PersonaCargo extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $fk_persona;

    /**
     *
     * @var integer
     */
    protected $fk_cargo;

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
     * Method to set the value of field fk_persona
     *
     * @param integer $fk_persona
     * @return $this
     */
    public function setFkPersona($fk_persona)
    {
        $this->fk_persona = $fk_persona;

        return $this;
    }

    /**
     * Method to set the value of field fk_cargo
     *
     * @param integer $fk_cargo
     * @return $this
     */
    public function setFkCargo($fk_cargo)
    {
        $this->fk_cargo = $fk_cargo;

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
     * Returns the value of field fk_persona
     *
     * @return integer
     */
    public function getFkPersona()
    {
        return $this->fk_persona;
    }

    /**
     * Returns the value of field fk_cargo
     *
     * @return integer
     */
    public function getFkCargo()
    {
        return $this->fk_cargo;
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
            'fk_persona' => 'fk_persona', 
            'fk_cargo' => 'fk_cargo'
        );
    }

}
