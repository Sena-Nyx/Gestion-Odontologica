<?php
if (!isset($_SESSION['correo']) || $_SESSION['rol'] != 1) {
   header("Location: index.php?accion=login");
   exit;
}

$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Sistema de Gestión Odontológica</title>

      <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">

      <script src="Vista/jquery/jquery-3.7.1.js"></script>
      <script>
         var rolUsuario = <?php echo json_encode($rol); ?>;
      </script> 
      <script src="Vista/js/menu.js"></script>
      <script src="Vista/jquery/jquery-ui-1.14.1.custom/jquery-ui.js" type="text/javascript"></script>
      <link href="Vista/jquery/jquery-ui-1.14.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
      <script src="Vista/js/script.js" type="text/javascript"></script>
   </head>
   <body>
      <div id="contenedor">
         <div id="encabezado">
               <h1>Sistema de Gestión Odontológica</h1>
         </div>
         <ul id="menu"> </ul>
         <div id="contenido" style="position: relative;">
            <?php if (isset($_SESSION['nombre'])): ?>
               <div style="position: absolute; top: 5px; right: 10px; font-weight: bold; color: #0075ff;">
                  <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                  <a href="index.php?accion=logout" style="font-weight:normal; color:#ff3333; font-size:0.95em;">Cerrar sesion</a>
               </div>
            <?php endif; ?>
            <h2>Asignar cita</h2>
            <form id="frmasignar" action="index.php?accion=guardarCita" method="post">
               <table>
                  <tr>
                     <td>Documento del paciente</td>
                     <td><input type="text" name="asignarDocumento" id="asignarDocumento"></td>
                  </tr>

                  <tr>
                     <td colspan="2"><input type="button" name="consultarConsultar" value="Consultar" id="consultarConsultar" onclick="consultarPaciente()"></td>  
                  </tr>

                  <tr>
                     <td colspan="2"><div id="paciente"></div></td>
                  </tr>

                  <tr>
                     <td>Médico</td>
                     <td>
                        <select id="medico" name="medico" onchange="cargarHoras()">
                        <option value="-1" selected="selected">---Selecione el Médico</option>
                        <?php
                           while( $fila = $result->fetch_object())
                           {
                        ?>

                        <option value = <?php echo $fila->MedIdentificacion; ?> >

                        <?php echo $fila->MedIdentificacion . " " . $fila->MedNombres ." ". $fila->MedApellidos; ?>
                     
                        </option>

                        <?php 
                           } 
                        ?>
                        </select>
                     </td>
                  </tr>

                  <tr>
                     <td>Fecha</td>
                     <td>
                        <input type="date" id="fecha" name="fecha" onchange="cargarHoras()">
                     </td>
                  </tr>

                  <tr>
                     <td>Hora</td>
                     <td>
                        <select id="hora" name="hora" onmousedown="seleccionarHora()">
                           <option value="-1" selected="selected">---Seleccione la hora ---</option>
                        </select>
                     </td>
                  </tr>

                  <tr>
                     <td>Consultorio</td>
                     <td>
                        <select id="consultorio" name="consultorio" onchange="cargarHoras()">
                           <option value="-1" selected="selected">---Selecione el Consultorio</option>
                           <?php
                              while( $fila = $result2->fetch_object())
                              {
                           ?>
                           <option value = <?php echo $fila->ConNumero; ?> >
                           <?php echo $fila->ConNumero . " - " . $fila->ConNombre ; ?>
                           </option>
                           <?php } ?>
                        </select>
                     </td>
                  </tr>

                  <tr>
                     <td colspan="2">
                        <input type="submit" name="asignarEnviar" value="Enviar" id="asignarEnviar">
                     </td>
                  </tr>
               </table>
            </form>

         </div>
      </div>
   </body>
</html>




