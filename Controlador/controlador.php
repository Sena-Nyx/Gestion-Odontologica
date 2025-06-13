<?php
class Controlador {
    public function verPagina($ruta){
        require_once $ruta;
    }

    /* Citas */
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

    /* Login y Register */
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

    /* Tratamientos */
    public function tratamientos() {
        $medicoId = $_SESSION['correo'];
        $gestor = new GestorCita();
        $pacientes = $gestor->consultarPacientesPorMedico($medicoId);
        require 'Vista/html/medico/tratamientos.php';
    }

    public function mostrarAsignarTratamiento() {
        $medicoId = $_SESSION['correo'];
        $gestor = new GestorCita();
        $pacientes = $gestor->consultarPacientesPorMedico($medicoId);
        require 'Vista/html/medico/asignarTratamientos.php';
    }

    /* Vista Paciente */
    public function verCitasPac() {
        $correo = $_SESSION['correo'];
        $gestor = new GestorCita();
        $paciente = $gestor->consultarPacientePorCorreo($correo);

        $inicio = isset($_GET['pos']) ? intval($_GET['pos']) : 0;
        $cantidad = 1;

        $result = $gestor->consultarCitasPorDocumentoPaginado($paciente->PacIdentificacion, $inicio, $cantidad);

        // Es para saber si hay mas citas
        $resultCantidad = $gestor->consultarCitasPorDocumento($paciente->PacIdentificacion);
        $totalCitas = $resultCantidad->num_rows;

        require 'Vista/html/paciente/verCitasPac.php';
    }

    public function verTratamientosPac() {
        $correo = $_SESSION['correo'];
        $gestor = new GestorCita();
        $paciente = $gestor->consultarPacientePorCorreo($correo);
        $result = $gestor->consultarTratamientosPorPaciente($paciente->PacIdentificacion);
        require 'Vista/html/paciente/verTratamientos.php';
    }

    public function guardarTratamiento($descripcion, $fechaInicio, $fechaFin, $observaciones, $paciente) {
        $gestor = new GestorCita();
        $fechaAsignado = date('Y-m-d');
        $resultado = $gestor->agregarTratamiento($fechaAsignado, $descripcion, $fechaInicio, $fechaFin, $observaciones, $paciente);
        if ($resultado) {
            header("Location: index.php?accion=tratamientos&registro=exito");
        } else {
            header("Location: index.php?accion=tratamientos&error=1");
        }
        exit;
    }

    /* Vista Admin (Pacientes) */
    public function verPacientes() {
        $gestor = new GestorCita();
        $pacientes = $gestor->consultarPacientes();
        require 'Vista/html/paciente.php';
    }

    public function mostrarEditarPaciente($identificacion) {
        $gestor = new GestorCita();
        $result = $gestor->consultarPacientePorId($identificacion);
        $paciente = $result->fetch_object(); 
        require 'Vista/html/editarPaciente.php';
    }

    public function editarPaciente($identificacion, $nombres, $apellidos, $fechaNacimiento, $sexo, $correo) {
        $gestor = new GestorCita();
        $gestor->editarPaciente($identificacion, $nombres, $apellidos, $fechaNacimiento, $sexo, $correo);
        header("Location: index.php?accion=paciente");
        exit;
    }

    public function consultarPaciente($doc){
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarPacientePorId($doc);
        require_once 'Vista/html/consultarPaciente.php';
    }

    public function agregarPaciente($doc,$nom,$ape,$fec,$sex,$cor){
        $paciente = new Paciente($doc, $nom, $ape, $fec, $sex, $cor);
        $gestorCita = new GestorCita();
        $registros = $gestorCita->agregarPaciente($paciente);
        if($registros > 0){
            echo "Se inserto el paciente con exito";
        } 
        else {
            echo "Error al grabar el paciente";
        }
    }

    public function confirmarEliminarPaciente($identificacion){
        $gestorCita = new GestorCita();
        $registros = $gestorCita->eliminarPaciente($identificacion);
        if($registros > 0){
            echo "El paciente se ha eliminado con éxito";
        } else {
            echo "Hubo un error al eliminar el paciente";
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

    public function cambiarEstadoPaciente($identificacion, $estado){
        $gestorCita = new GestorCita();
        
        if($estado == "Activo"){
            $estado = "Inactivo";
        } 
        elseif($estado == "Inactivo") {
            $estado = "Activo";
        }

        $registros = $gestorCita->cambiarEstadoPaciente($identificacion, $estado);
        header("Location: index.php?accion=paciente");
    }

    /* Vista Admin (Medicos) */
    public function verMedicos() {
        $gestor = new GestorCita();
        $medicos = $gestor->consultarMedicos();
        require 'Vista/html/medico.php';
    }

    public function procesarAgregarMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password) {
        $gestor = new GestorCita();
        $resultado = $gestor->agregarMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password);
        header("Location: index.php?accion=medicos");
        exit;
    }

    public function agregarMedico($ide, $nom, $ape, $cor, $pas){
        $gestorCita = new GestorCita();
        $resultado = $gestorCita->agregarMedico($ide, $nom, $ape, $cor, $pas);
        if($resultado === "existe"){
            echo "Ya existe un medico con esa identificación o correo.";
        } elseif($resultado === "exito"){
            echo "Se insertó el médico con exito";
        } else {
            echo "Error al grabar el medico";
        }
    }
    public function mostrarEditarMedico($identificacion) {
        $gestor = new GestorCita();
        $medico = $gestor->consultarMedicoPorId($identificacion);
        require 'Vista/html/editarMedico.php';
    }

    public function editarMedico($identificacion, $nombre, $apellido, $correo) {
        $gestor = new GestorCita();
        $gestor->editarMedico($identificacion, $nombre, $apellido, $correo);
        header("Location: index.php?accion=medicos");
        exit;
    }

    public function eliminarMedico($identificacion) {
        $gestor = new GestorCita();
        $resultado = $gestor->eliminarMedico($identificacion);
        if ($resultado) {
            header("Location: index.php?accion=medicos&eliminado=exito");
        } else {
            header("Location: index.php?accion=medicos&error=1");
        }
        exit;
    }

    public function confirmarEliminarMedico($identificacion){
        $gestorCita     = new GestorCita();
        $registros      = $gestorCita->eliminarMedico($identificacion);
        if($registros > 0){
            echo "El medico se ha eliminado con éxito";
        } else {
            echo "Hubo un error al eliminar el medico";
        }
    }

    public function procesarRegistroMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password) {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header("Location: index.php?accion=login");
            exit;
        }
        $gestor = new GestorCita();
        $resultado = $gestor->agregarMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password);
        if ($resultado) {
            header("Location: index.php?accion=verMedico&registro=exito");
        } else {
            header("Location: index.php?accion=administrador&error=1");
        }
        exit;
    }

    public function verCitasMed() {
        $medicoId = $_SESSION['correo'];
        $gestor = new GestorCita();
        $citas = $gestor->consultarCitasPorMedico($medicoId);
        require 'Vista/html/medico/verCitasMed.php';
    }

    public function cambiarEstadoMedico($identificacion, $estado){
        $gestorCita= new GestorCita();

        if($estado == "Activo"){
            $estado = "Inactivo";
        } 
        elseif($estado == "Inactivo") {
            $estado = "Activo";
        }

        $registro = $gestorCita->cambiarEstadoMedico($identificacion, $estado);
        header("Location: index.php?accion=medicos");
    }

    /* Pacientes */
    public function agregarCitasPac() {
        $gestorCita = new GestorCita();
        $medicos = $gestorCita->consultarMedicos();
        $consultorios = $gestorCita->consultarConsultorios();
        require 'Vista/html/paciente/agregarCitasPac.php';
    }
    
}