<?php
class Controlador {
    public function verPagina($ruta){
        require_once $ruta;
    }

    public function agregarCita($doc,$med,$fec,$hor,$con){
        $cita = new Cita(null, $fec, $hor, $doc, $med, $con, "Solicitada","Ninguna");
        $gestorCita = new GestorCita();
        $id = $gestorCita->agregarCita($cita);
        $result = $gestorCita->consultarCitaPorId($id);
        require_once 'Vista/html/confirmarCita.php';
    }

    public function consultarCitas($doc){
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarCitasPorDocumento($doc);
        require_once 'Vista/html/consultarCitas.php';
    }

    public function cancelarCitas($doc){
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarCitasPorDocumento($doc);
        require_once 'Vista/html/cancelarCitas.php';
    }

    public function consultarPaciente($doc){
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarPaciente($doc);
        require_once 'Vista/html/consultarPaciente.php';
    }

    public function agregarPaciente($doc,$nom,$ape,$fec,$sex){
        $paciente = new Paciente($doc, $nom, $ape, $fec, $sex);
        $gestorCita = new GestorCita();
        $registros = $gestorCita->agregarPaciente($paciente);
        if($registros > 0){
            echo "Se insertó el paciente con exito";
        } 
        else {
            echo "Error al grabar el paciente";
        }
    }

    public function cargarAsignar(){
        $gestorCita     = new GestorCita();
        $result         = $gestorCita->consultarMedicos();
        $result2        = $gestorCita->consultarConsultorios();
        require_once 'Vista/html/asignar.php';
    }
    
    public function consultarHorasDisponibles($medico,$fecha){
        if (!isset($_SESSION['correo']) || $_SESSION['rol'] != 1) {
            header("Location: index.php?accion=login");
            exit;
        }
        $gestorCita     = new GestorCita();
        $result         = $gestorCita->consultarHorasDisponibles($medico, $fecha);
        require_once 'Vista/html/consultarHoras.php';
    }

    public function verCita($cita){
        $gestorCita     = new GestorCita();
        $result         = $gestorCita->consultarCitaPorId($cita);
        require_once 'Vista/html/confirmarCita.php';
    }

    public function confirmarCancelarCita($cita){
        $gestorCita     = new GestorCita();
        $registros      = $gestorCita->cancelarCita($cita);
        if($registros > 0){
            echo "La cita se ha cancelado con éxito";
        } else {
            echo "Hubo un error al cancelar la cita";
        }
    }

    public function cargarLogin() {
        $gestor = new GestorCita();
        $roles = $gestor->consultarRol(); 

        require 'Vista/html/login.php';
    }

    public function cargarRegister() {
        $gestor = new GestorCita();
        $roles = $gestor->consultarRol(); 

        require 'Vista/html/registerPaciente.php';
    }

    public function procesarLogin($correo, $password, $rol) {
        $gestor = new GestorCita();
        $result = $gestor->validarLogin($correo, $password, $rol);
        $usuario = $result->fetch_object();

        if ($usuario) {
            if ($rol == 1) { // Administrador
                $_SESSION['correo'] = $usuario->admCorreo; 
                $_SESSION['password'] = $usuario->admPassword;
                $_SESSION['rol'] = $usuario->id_rol; 
            }

            elseif ($rol == 2) { // Paciente
                $_SESSION['correo'] = $usuario->pacCorreo; 
                $_SESSION['password'] = $usuario->pacPassword;
                $_SESSION['rol'] = $usuario->id_rol; 
            }

            elseif ($rol == 3) { // Médico
                $_SESSION['correo'] = $usuario->medCorreo; 
                $_SESSION['password'] = $usuario->medPassword;
                $_SESSION['rol'] = $usuario->id_rol; 
            }
            header("Location: index.php?accion=principal");
            exit;
        } else {
            header("Location: index.php?accion=login&error=1");
            exit;
        }
    }

    public function procesarRegistroPaciente($identificacion, $nombres, $apellidos, $fechaNacimiento, $sexo, $correo, $password) {
        $gestor = new GestorCita();
        $resultado = $gestor->registrarPaciente($identificacion, $nombres, $apellidos, $fechaNacimiento, $sexo, $correo, $password);
        if ($resultado) {
            header("Location: index.php?accion=login&registro=exito");
        } else {
            header("Location: index.php?accion=registerPaciente&error=1");
        }
        exit;
    }


    public function procesarRegistroMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password) {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header("Location: index.php?accion=login");
            exit;
        }
        $gestor = new GestorCita();
        $resultado = $gestor->registrarMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password);
        if ($resultado) {
            header("Location: index.php?accion=verMedico&registro=exito");
        } else {
            header("Location: index.php?accion=administrador&error=1");
        }
        exit;
    }

    public function verMedicos() {
        $gestor = new GestorCita();
        $medicos = $gestor->consultarMedicos();
        require 'Vista/html/medico.php';
    }

    public function procesarAgregarMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password) {
        $gestor = new GestorCita();
        $resultado = $gestor->registrarMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password);
        header("Location: index.php?accion=medicos");
        exit;
    }

    public function editarMedico($identificacion, $nombres, $apellidos, $password) {
        $gestor = new GestorCita();
        $resultado = $gestor->editarMedico($identificacion, $nombres, $apellidos, $password);
        header("Location: index.php?accion=medicos");
        exit;
    }




}