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

      elseif($_GET["accion"] == "tratamientos"){
         $controlador->tratamientos();
      }

      elseif($_GET["accion"] == "verCitasMed"){
         $controlador->verCitasMed();
      }

      elseif($_GET["accion"] == "paciente"){
         $controlador->verpacientes();
      }

      elseif($_GET["accion"] == "login"){
         $controlador->cargarLogin();
      }

      elseif($_GET["accion"] == "register"){
         $controlador->cargarRegister();
      }

      elseif($_GET["accion"] == "asignarTratamientos"){
         $controlador->mostrarAsignarTratamiento();
      }

      elseif($_GET["accion"] == "verCitasPac"){
         $controlador->verCitasPac();
      }
      
      elseif($_GET["accion"] == "verTratamientos"){
         $controlador->verTratamientosPac();
      }

      elseif($_GET["accion"] == "cancelarCita"){
         $controlador->cancelarCitas($_GET["cancelarDocumento"]);
      }

      elseif($_GET["accion"] == "ConsultarPaciente"){
         $controlador->consultarPaciente($_GET["documento"]);
      }
      
      elseif($_GET["accion"] == "agregarCitasPac"){
         $controlador->agregarCitasPac();
      }

      elseif($_GET["accion"] == "guardarTratamiento"){
         $controlador->guardarTratamiento(
            $_POST["TraDescripcion"],
            $_POST["TraFechaInicio"],
            $_POST["TraFechaFin"],
            $_POST["TraObservaciones"],
            $_POST["TraPaciente"]
         );
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
         if (isset($_GET["consultarDocumento"])) {
            $controlador->consultarCitas($_GET["consultarDocumento"]);
         } else {
            echo "Debe ingresar el documento del paciente.";
         }
      }    

      elseif($_GET["accion"] == "ingresarPaciente"){
         $controlador->agregarPaciente(
            $_GET["PacIdentificacion"],
            $_GET["PacNombres"],
            $_GET["PacApellidos"],
            $_GET["PacNacimiento"],
            $_GET["PacSexo"],
            $_GET["pacCorreo"]
         );
      }

      elseif($_GET["accion"] == "ingresarMedicos"){
         $controlador->agregarMedico(
            $_GET["MedIdentificacion"],
            $_GET["MedNombres"],
            $_GET["MedApellidos"],
            $_GET["medCorreo"],
            $_GET["medPassword"]
         );
      }

      elseif($_GET["accion"] == "editarPaciente"){
         $controlador->mostrarEditarPaciente($_GET["identificacion"]);
      }

      elseif($_GET["accion"] == "procesarEditarPaciente"){
         $controlador->editarPaciente(
            $_POST["identificacion"],
            $_POST["nombres"],
            $_POST["apellidos"],
            $_POST["fechaNacimiento"],
            $_POST["sexo"],
            $_POST["correo"]
         );
      }

      elseif($_GET["accion"] == "editarMedico"){
         $controlador->mostrarEditarMedico($_GET["identificacion"]);
      }

      elseif($_GET["accion"] == "procesarEditarMedicos"){
         $controlador->editarMedico(
         $_POST["identificacion"],
         $_POST["nombre"],
         $_POST["apellido"],
         $_POST["correo"]
         );
      }

      elseif($_GET["accion"]=="estadoPaciente"){
         $controlador->cambiarEstadoPaciente(
            $_GET["identificacion"], 
            $_GET["estado"]);
      }

      elseif($_GET["accion"]=="estadoMedico"){
         $controlador->cambiarEstadoMedico(
            $_GET["identificacion"], 
            $_GET["estado"]);
      }

      elseif($_GET["accion"] == "eliminarMedico"){
         $controlador->eliminarMedico($_GET["identificacion"]);
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

      elseif($_GET["accion"] == "confirmarEliminarMedico"){
         $controlador->confirmarEliminarMedico($_GET["identificacion"]);
      }

      elseif($_GET["accion"] == "confirmarEliminarPaciente"){
         $controlador->confirmarEliminarPaciente($_GET["identificacion"]);
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
