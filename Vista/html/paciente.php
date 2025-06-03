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
            <h2>Gestion de pacientes</h2>
            <p>Contenido de la página</p>
               <table border="1" cellpadding="5">
                  <tr>
                     <th>MedIdentificacion</th>
                     <th>MedNombres</th>
                     <th>MedApellidos</th>
                     <th>Editar Medico</th>
                     <th>Eliminar Medico</th>
                  </tr>

                  <?php
                     $conexion = mysqli_connect('localhost', 'root', '', 'tareas') or die("Problemas con la conexión");

                     $registros = mysqli_query($conexion, "SELECT * FROM tareas WHERE usuario_id = '$_SESSION[usuario_id]'") 
                     or die("Problemas en el select: " . mysqli_error($conexion));


                     while ($reg = mysqli_fetch_array($registros)) 
                     {
                        echo "<tr>";
                        echo "<td>" . $reg['titulo'] . "</td>";
                        echo "<td>" . $reg['descripcion'] . "</td>";
                        echo "<td>" . $reg['fecha_creacion'] . "</td>";
                        echo "<td><a href='editar_tarea.php?id=" . $reg['id'] . "'>Editar</a></td>";
                        echo "<td><a href='eliminar_tarea.php?id=" . $reg['id'] ."'>Eliminar</a></td>";
                        echo "</tr>";
                     }
                     mysqli_close($conexion);
                  ?>
               </table>
         </div>
      </div>
   </body>
</html>

