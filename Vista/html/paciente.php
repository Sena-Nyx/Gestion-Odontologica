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
      <script src="Vista/js/admin.js"></script>
   </head>
   <body>
      <div id="contenedor">
         <div id="encabezado">
               <h1>Sistema de Gestión Odontológica</h1>
         </div>
         <ul id="menu"></ul>
         <div id="contenido" style="position: relative;">
            <?php if (isset($_SESSION['nombre'])): ?>
               <div style="position: absolute; top: 5px; right: 10px; font-weight: bold; color: #0075ff;">
                  <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                  <a href="index.php?accion=logout" style="font-weight:normal; color:#ff3333; font-size:0.95em;">Cerrar sesion</a>
               </div>
            <?php endif; ?>

            <h2>Gestion de pacientes</h2>
            <input type="button" name="ingPaciente" id="ingpaciente" value="Ingresar Paciente" onclick="pacienteFormulario()">
            <br> <br>
            <table border="1" cellpadding="2">
               <tr>
                  <th>Identificación</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Fecha Nacimiento</th>
                  <th>Sexo</th>
                  <th>Estado</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
               </tr>
               <?php while($paciente = $pacientes->fetch_object()) { ?>
               <tr>
                  <td><?php echo $paciente->PacIdentificacion; ?></td>
                  <td><?php echo $paciente->PacNombres; ?></td>
                  <td><?php echo $paciente->PacApellidos; ?></td>
                  <td><?php echo $paciente->PacFechaNacimiento; ?></td>
                  <td><?php echo $paciente->PacSexo; ?></td>
                  <td><a href="index.php?accion=estadoPaciente&identificacion=<?php echo $paciente->PacIdentificacion; ?>&estado=<?php echo $paciente->PacEstado;?> "><?php echo $paciente->PacEstado;?></a></td>
                  <td><a href='index.php?accion=editarPaciente&identificacion=<?php echo $paciente->PacIdentificacion; ?>'>Editar</a></td>
                  <td><a href="#" onclick="confirmarCancelarPaciente('<?php echo $paciente->PacIdentificacion; ?>')">Eliminar</a></td>
               </tr>
            <?php } ?>
            </table>
         </div>
      </div>

      <!-- Modal para ingresar Paciente -->
      <div id="frmPaciente" title="Agregar Nuevo Paciente">
         <form id="agregarPaciente">
            <table>
               <tr>
                  <td>Identificacion</td>
                  <td><input type="text" name="PacIdentificacion" id="PacIdentificacion"></td>
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
                     <select id="PacSexo" name="PacSexo">
                        <option value="-1" selected="selected">--Selecione el sexo ---</option>
                        <option value="M">Masculino</option>
                        <option value="F">Femenino</option>
                     </select>
                  </td>
               </tr>
               <tr>
                  <td>Correo</td>
                  <td><input type="text" name="pacCorreo" id="pacCorreo"></td>
               </tr>
            </table>
         </form>
      </div>
   </body>
</html>

