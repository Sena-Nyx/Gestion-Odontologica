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
         <div id="contenido" style="position: relative;">
            <?php if (isset($_SESSION['nombre'])): ?>
               <div style="position: absolute; top: 5px; right: 10px; font-weight: bold; color: #0075ff;">
                  <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                  <a href="index.php?accion=logout" style="font-weight:normal; color:#ff3333; font-size:0.95em;">Cerrar sesion</a>
               </div>
            <?php endif; ?>
            <h2>Gestion de tratamientos</h2>
            <a href="index.php?accion=asignarTratamientos">
               <button>Asignar Tratamiento</button>
            </a>
            <br> <br>
            <table border="1" cellpading="5">
               <tr>
                  <th>Numero</th>
                  <th>Descripcion</th>
                  <th>Fecha Inicio</th>
                  <th>Fecha Fin</th>
                  <th>Paciente</th>
                  <th>Editar</th>
                  <th>Eliminar</th>
               </tr>
               <?php while($trat = $tratamientos->fetch_object()) { ?>
               <tr>
                  <td><?php echo $trat->TraNumero; ?></td>
                  <td><?php echo $trat->TraDescripcion; ?></td>
                  <td><?php echo $trat->TraFechaInicio; ?></td>
                  <td><?php echo $trat->TraFechaFin; ?> </td>
                  <td><?php echo $trat->TraPaciente; ?> </td>
                  <td><a href="index.php?accion=editarTratamiento&numero=<?php echo $trat->TraNumero; ?>">Editar</a></td>
                  <td><a href="index.php?accion=eliminarTratamiento&numero=<?php echo $trat->TraNumero; ?>" onclick="return confirm('¿Seguro que deseas eliminar este tratamiento?');">Eliminar</a></td>
               </tr>
               <?php } ?>
            </table>
         </div>
      </div>
   </body>
</html>