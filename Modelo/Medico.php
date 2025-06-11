<?php
class Medico {
    private $identificacion;
    private $nombres;
    private $apellidos;
    private $correo;
    private $password;

    public function __construct($ide,$nom,$ape,$cor,$pas) {
        $this->identificacion = $ide;
        $this->nombres = $nom;
        $this->apellidos = $ape;
        $this->correo = $cor;
        $this->password = $pas;
    }

    public function obtenerIdentificacion(){
        return $this->identificacion;
    }
    public function obtenerNombres(){
        return $this->nombres;
    }
    public function obtenerApellidos(){
        return $this->apellidos;
    }
    public function obtenerCorreo(){
        return $this->correo;
    }
    public function obtenerPassword(){
        return $this->password;
    }

}