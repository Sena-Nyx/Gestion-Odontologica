<?php
class GestorCita {

    /* Citas */
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
        $sql = "SELECT citas.*, medicos.MedIdentificacion, medicos.MedNombres, medicos.MedApellidos, consultorios.ConNumero, consultorios.ConNombre
                FROM citas
                INNER JOIN medicos ON citas.CitMedico = medicos.MedIdentificacion
                INNER JOIN consultorios ON citas.CitConsultorio = consultorios.ConNumero
                WHERE citas.CitPaciente = '$doc' AND citas.CitEstado = 'Solicitada'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        return $result;
    }

    public function consultarCitasPorDocumentoPaginado($doc, $inicio, $cantidad){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT citas.*, medicos.MedIdentificacion, medicos.MedNombres, medicos.MedApellidos, consultorios.ConNumero, consultorios.ConNombre
                FROM citas
                INNER JOIN medicos ON citas.CitMedico = medicos.MedIdentificacion
                INNER JOIN consultorios ON citas.CitConsultorio = consultorios.ConNumero
                WHERE citas.CitPaciente = '$doc' AND citas.CitEstado = 'Solicitada'
                ORDER BY citas.CitFecha DESC
                LIMIT $inicio, $cantidad";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
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

    /* Login */
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

    /* Pacientes */
    public function consultarPacientes(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM pacientes ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        
        return $result ;
    }

    public function consultarPacientePorId($doc){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM pacientes WHERE PacIdentificacion = '$doc' ";
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
        $correo = $paciente->obtenerCorreo();

        $sql = "INSERT INTO pacientes (PacIdentificacion, PacNombres, PacApellidos, PacFechaNacimiento, PacSexo, id_rol, pacCorreo) 
                VALUES ('$identificacion','$nombres','$apellidos','$fechaNacimiento','$sexo', 2, '$correo')";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();

        return $filasAfectadas;
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

    public function editarPaciente($identificacion, $nombres, $apellidos, $fechaNacimiento, $sexo, $correo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $set = "PacNombres='$nombres', PacApellidos='$apellidos', PacFechaNacimiento='$fechaNacimiento', PacSexo='$sexo', pacCorreo='$correo'";
        $sql = "UPDATE pacientes SET $set WHERE PacIdentificacion='$identificacion'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function eliminarPaciente($identificacion) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM pacientes WHERE PacIdentificacion='$identificacion'";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();

        return $filasAfectadas;
    }

    public function cambiarEstadoPaciente($documento, $estado){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE pacientes SET PacEstado = '$estado' WHERE PacIdentificacion = '$documento'";
        $conexion->consulta($sql);
        // $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    
    /* Medicos */
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

    public function consultarMedicoPorId($identificacion) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM medicos WHERE MedIdentificacion = '$identificacion'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result->fetch_object();
    }

    public function agregarMedico($identificacion, $nombres, $apellidos, $correo, $password){
        $conexion = new Conexion();
        $conexion->abrir();
        $sqlCheck = "SELECT * FROM medicos WHERE MedIdentificacion = '$identificacion' OR medCorreo = '$correo'";
        $conexion->consulta($sqlCheck);
        if ($conexion->obtenerResult()->num_rows > 0) {
            $conexion->cerrar();
            return "existe";
        }
        $sql = "INSERT INTO medicos (MedIdentificacion, MedNombres, MedApellidos, id_rol, medCorreo, medPassword) 
                VALUES ('$identificacion','$nombres','$apellidos', 3, '$correo', '$password')";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();

        if ($filasAfectadas > 0) {
            return "exito";
        } else {
            return "error";
        }
    }

    public function editarMedico($identificacion, $nombre, $apellido, $correo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $set = "MedNombres='$nombre', MedApellidos='$apellido', medCorreo='$correo'";
        $sql = "UPDATE medicos SET $set WHERE MedIdentificacion='$identificacion'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function eliminarMedico($identificacion) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM medicos WHERE MedIdentificacion='$identificacion'";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();

        return $filasAfectadas;
    }

    public function consultarPacientesPorMedico($medicoCorreo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT DISTINCT p.* FROM pacientes p
                INNER JOIN citas c ON c.CitPaciente = p.PacIdentificacion
                INNER JOIN medicos m ON c.CitMedico = m.MedIdentificacion
                WHERE m.medCorreo = '$medicoCorreo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function consultarCitasPorMedico($medicoCorreo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT c.* FROM citas c
                INNER JOIN medicos m ON c.CitMedico = m.MedIdentificacion
                WHERE m.medCorreo = '$medicoCorreo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function cambiarEstadoMedico($identificacion, $estado){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE medicos SET MedEstado = '$estado' WHERE MedIdentificacion = '$identificacion'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    /* Tratamientos */
    public function agregarTratamiento($fechaAsignado, $descripcion, $fechaInicio, $fechaFin, $observaciones, $paciente) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO tratamientos (TraFechaAsignado, TraDescripcion, TraFechaInicio, TraFechaFin, TraObservaciones, TraPaciente)
                VALUES ('$fechaAsignado', '$descripcion', '$fechaInicio', '$fechaFin', '$observaciones', '$paciente')";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $filasAfectadas > 0;
    }

    public function consultarPacientePorCorreo($correo){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM pacientes WHERE pacCorreo = '$correo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result->fetch_object();
    }

    public function consultarTratamientosPorPaciente($doc){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM tratamientos WHERE TraPaciente = '$doc'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
}