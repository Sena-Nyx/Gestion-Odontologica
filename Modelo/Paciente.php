<?php
class Paciente {
    private $identificacion;
    private $nombres;
    private $apellidos;
    private $fechaNacimiento;
    private $sexo;
    private $correo;

    public function __construct($ide,$nom,$ape,$fNa,$sex,$cor) {
        $this->identificacion = $ide;
        $this->nombres = $nom;
        $this->apellidos = $ape;
        $this->fechaNacimiento = $fNa;
        $this->sexo = $sex;
        $this->correo = $cor;
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
    public function obtenerFechaNacimiento(){
        return $this->fechaNacimiento;
    }
    public function obtenerSexo(){
        return $this->sexo;
    }
    public function obtenerCorreo(){
        return $this->correo;
    }
}