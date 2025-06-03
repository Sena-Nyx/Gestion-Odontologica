<?php
   session_start();
   require_once 'Controlador/Controlador.php';
   require_once 'Modelo/GestorCita.php';
   require_once 'Modelo/Cita.php';
   require_once 'Modelo/Paciente.php';
   require_once 'Modelo/Conexion.php';

   $controlador = new Controlador();

   if( isset($_GET["accion"])){
      
      if($_GET["accion"] == "asignar"){ 
         $controlador->cargarAsignar();
      }

      elseif($_GET["accion"] == "principal"){
         $controlador->verPagina('Vista/html/interfazPrincipal.php');
      }

      elseif($_GET["accion"] == "consultar"){
         $controlador->verPagina('Vista/html/consultar.php');
      }

      elseif($_GET["accion"] == "cancelar"){
         $controlador->verPagina('Vista/html/cancelar.php');
      }

      elseif($_GET["accion"] == "medicos"){
         $controlador->verMedicos();
      }

      elseif($_GET["accion"] == "paciente"){
         $controlador->verPagina('Vista/html/paciente.php');
      }

      elseif($_GET["accion"] == "login"){
         $controlador->cargarLogin();
      }

      elseif($_GET["accion"] == "register"){
         $controlador->cargarRegister();
      }

      elseif($_GET["accion"] == "guardarCita"){
         $controlador->agregarCita(
         $_POST["asignarDocumento"],
         $_POST["medico"],
         $_POST["fecha"],
         $_POST["hora"],
         $_POST["consultorio"]);
      }

      elseif($_GET["accion"] == "consultarCita"){
         $controlador->consultarCitas($_GET["consultarDocumento"]);
      }

      elseif($_GET["accion"] == "cancelarCita"){
         $controlador->cancelarCitas($_GET["cancelarDocumento"]);
      }

      elseif($_GET["accion"] == "ConsultarPaciente"){
         $controlador->consultarPaciente($_GET["documento"]);
      }

      elseif($_GET["accion"] == "ingresarPaciente"){
         $controlador->agregarPaciente(
            $_GET["PacDocumento"],
            $_GET["PacNombres"],
            $_GET["PacApellidos"],
            $_GET["PacNacimiento"],
            $_GET["PacSexo"]
         );
      }

      elseif($_GET["accion"] == "consultarHora"){
         $controlador->consultarHorasDisponibles($_GET["medico"], $_GET["fecha"]);
      }

      elseif($_GET["accion"] == "verCita"){
         $controlador->verCita($_GET["numero"]);
      }

      elseif($_GET["accion"] == "confirmarCancelar"){
         $controlador->confirmarCancelarCita($_GET["numero"]);
      }

      elseif($_GET["accion"] == "procesarLogin"){
         $controlador->procesarLogin($_POST["correo"], $_POST["password"], $_POST["rol"]);
      }

      elseif($_GET["accion"] == "registerPaciente"){
         $controlador->verPagina('Vista/html/registerPaciente.php');
      }
      elseif($_GET["accion"] == "procesarRegistroPaciente"){
         $controlador->procesarRegistroPaciente(
            $_POST["identificacion"],
            $_POST["nombres"],
            $_POST["apellidos"],
            $_POST["fechaNacimiento"],
            $_POST["sexo"],
            $_POST["correo"],
            $_POST["password"]
         );
      }
   } 
      else {
         $controlador->verPagina('Vista/html/inicio.php');
      }
   
?>
