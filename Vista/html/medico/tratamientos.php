<?php
/* session_start(); */
if (!isset($_SESSION['correo']) || $_SESSION['rol'] != 3) {
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
         <div id="contenido">
            <h2>Gestion de medicos</h2>
            <a href="index.php?accion=asignarTratamientos">
               <button>Asignar Tratamiento</button>
            </a>
            <br> <br>
            <table border="1" cellpading="5">
               <tr>
                  <th>Identificación</th>
                  <th>Nombres</th>
                  <th>Apellidos</th>
                  <th>Fecha Nacimiento</th>
                  <th>Sexo</th>
               </tr>
               <?php while($paciente = $pacientes->fetch_object()) { ?>
               <tr>
                  <td><?php echo $paciente->PacIdentificacion; ?></td>
                  <td><?php echo $paciente->PacNombres; ?></td>
                  <td><?php echo $paciente->PacApellidos; ?></td>
                  <td><?php echo $paciente->PacFechaNacimiento; ?> </td>
                  <td><?php echo $paciente->PacSexo; ?> </td>
               </tr>
               <?php } ?>
            </table>
         </div>
      </div>
   </body>
</html>