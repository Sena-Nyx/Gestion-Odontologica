<?php
class GestorCita {
    public function agregarCita(Cita $cita){
        $conexion = new Conexion();
        $conexion->abrir();
        $fecha = $cita->obtenerFecha();
        $hora = $cita->obtenerHora();
        $paciente = $cita->obtenerPaciente();
        $medico = $cita->obtenerMedico();
        $consultorio = $cita->obtenerConsultorio();
        $estado = $cita->obtenerEstado();
        $observaciones = $cita->obtenerObservaciones();
        $sql = "INSERT INTO citas VALUES (null,'$fecha','$hora','$paciente','$medico','$consultorio','$estado', '$observaciones')";
        $conexion->consulta($sql);
        $citaId = $conexion->obtenerCitaId();
        $conexion->cerrar();

        return $citaId ;
    }

    public function consultarCitaPorId($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT pacientes.* , medicos.*, consultorios.*, citas.* "
        . "FROM Pacientes as pacientes, Medicos as medicos, Consultorios as consultorios, citas "
        . "WHERE citas.CitPaciente = pacientes.PacIdentificacion "
        . "AND citas.CitMedico = medicos.MedIdentificacion "
        . "AND citas.CitConsultorio = consultorios.ConNumero "
        . "AND citas.CitNumero = $id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result ;
    }

    public function consultarCitasPorDocumento($doc){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM citas "
                . "WHERE CitPaciente = '$doc' "
                . " AND CitEstado = 'Solicitada' ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result ;
    }
    
    public function consultarPaciente($doc){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM Pacientes WHERE PacIdentificacion = '$doc' ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result ;
    }
    
    public function agregarPaciente(Paciente $paciente){
        $conexion = new Conexion();
        $conexion->abrir();
        $identificacion = $paciente->obtenerIdentificacion();
        $nombres = $paciente->obtenerNombres();
        $apellidos = $paciente->obtenerApellidos();
        $fechaNacimiento = $paciente->obtenerFechaNacimiento();
        $sexo = $paciente->obtenerSexo();
        $sql = "INSERT INTO Pacientes VALUES ('$identificacion','$nombres','$apellidos',". "'$fechaNacimiento','$sexo')";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();

        return $filasAfectadas;
    }

    public function consultarHorasDisponibles($medico,$fecha){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql    = "SELECT hora FROM horas WHERE hora NOT IN "
                . "( SELECT CitHora FROM citas WHERE CitMedico = '$medico' AND 
                CitFecha = '$fecha'"
                . " AND CitEstado = 'Solicitada') ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result ;        
    }

    public function consultarConsultorios(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql    = "SELECT * FROM consultorios ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result ;        
    }

    public function cancelarCita($cita){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql    = "UPDATE citas SET CitEstado = 'Cancelada' "
                . " WHERE CitNumero = $cita ";
        $conexion->consulta($sql);
        $conexion->cerrar();
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        return $filasAfectadas;
    }

    public function consultarRol(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM roles";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function validarLogin($correo, $password, $rol) {
        $conexion = new Conexion();
        $conexion->abrir();

        if ($rol == 1) { 
            $tabla = 'administradores';
            $campoCorreo = 'admCorreo';
            $campoPass = 'admPassword';
            $campoRol = 'id_rol';
        } elseif ($rol == 2) { 
            $tabla = 'pacientes';
            $campoCorreo = 'pacCorreo';
            $campoPass = 'pacPassword';
            $campoRol = 'id_rol';
        } elseif ($rol == 3) { 
            $tabla = 'medicos';
            $campoCorreo = 'medCorreo';
            $campoPass = 'medPassword';
            $campoRol = 'id_rol';
        } else {
            return false;
        }

        $sql = "SELECT * FROM $tabla WHERE $campoCorreo = '$correo' AND $campoPass = '$password' AND $campoRol = $rol";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function registrarPaciente($identificacion, $nombres, $apellidos, $fechaNacimiento, $sexo, $correo, $password) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO pacientes (PacIdentificacion, PacNombres, PacApellidos, PacFechaNacimiento, PacSexo, pacCorreo, pacPassword, id_rol) 
                VALUES ('$identificacion', '$nombres', '$apellidos', '$fechaNacimiento', '$sexo', '$correo', '$password', 2)";
        $conexion->consulta($sql);
        $filas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $filas > 0;
    }
    
    public function verMedicos() {
        $gestor = new GestorCita();
        $medicos = $gestor->consultarMedicos();
        require 'Vista/html/medico.php';
    }

    public function consultarMedicos(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM medicos ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        
        return $result ;
    }

    public function registrarMedico($identificacion, $nombres, $apellidos, $especialidad, $correo, $password) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO medicos (MedIdentificacion, MedNombres, MedApellidos, MedEspecialidad, MedCorreo, MedPassword, id_rol) 
                VALUES ('$identificacion', '$nombres', '$apellidos', '$especialidad', '$correo', '$password', 3)";
        $conexion->consulta($sql);
        $filas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $filas > 0;
    }

    public function editarMedico($identificacion, $nombres, $apellidos, $password) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE medicos SET MedNombres='$nombres', MedApellidos='$apellidos', MedPassword='$password' WHERE MedIdentificacion='$identificacion'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result > 0;
    }

}