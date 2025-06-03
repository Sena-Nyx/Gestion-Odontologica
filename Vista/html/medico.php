<?php
/* session_start(); */
if (!isset($_SESSION['correo']) || $_SESSION['rol'] != 1) {
   header("Location: ../../index.php?accion=login");
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
         <ul id="menu"></ul>
         <div id="contenido">
            <h2>Gestion de medicos</h2>
            <input type="button" name="ingMedico" id="ingMedico" value="IngresarMedico" onclick="medicoFormulario()">
            <br> <br>
            <table border="1" cellpadding="5">
               <tr>
                  <th>Identificación</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Correo</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
               </tr>
               <?php while($medico = $medicos->fetch_object()) { ?>
               <tr>
                  <td><?php echo $medico->MedIdentificacion; ?></td>
                  <td><?php echo $medico->MedNombres; ?></td>
                  <td><?php echo $medico->MedApellidos; ?></td>
                  <td><?php echo $medico->medCorreo; ?></td>
                  <td></td>
                  <td></td>
               </tr>
            <?php } ?>
            </table>
         </div>
      </div>

      <div id="frmMedico" title="Agregar Nuevo Medico">
         <form id="agregarPaciente">
            <table>
               <tr>
                  <td>Documento</td>
                  <td><input type="text" name="MedIdentificacion" id="PacDocumento"></td>
               </tr>
               <tr>
                  <td>Nombres</td>
                  <td><input type="text" name="PacNombres" id="PacNombres"></td>
               </tr>
               <tr>
                  <td>Apellidos</td>
                  <td><input type="text" name="PacApellidos" id="PacApellidos"></td>
               </tr>
               <tr>
                  <td>Fecha de Nacimiento</td>
                  <td><input type="date" name="PacNacimiento" id="PacNacimiento"></td>
               </tr>
               <tr>
                  <td>Sexo</td>
                  <td>
                  <select id="pacSexo" name="PacSexo">
                     <option value="-1" selected="selected">--Selecione el sexo ---</option>
                     <option value="M">Masculino</option>
                     <option value="F">Femenino</option>
                  </select>
                  </td>
               </tr>
            </table>
         </form>
      </div>
   </body>
</html>