<?php
if (!isset($_SESSION['correo']) || $_SESSION['rol'] != 2) {
   header("Location: ../../index.php?accion=login");
   exit;
}
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html>
<head>
   <title>Mis Tratamientos</title>
   <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
   <script src="Vista/jquery/jquery-3.7.1.js"></script>
   <script>
      var rolUsuario = <?php echo json_encode($rol); ?>;
   </script>
   <script src="Vista/js/menu.js"></script>
</head>
<body>
   <div id="contenedor">
      <div id="encabezado">
         <h1>Sistema de Gestión Odontológica</h1>
      </div>
      <ul id="menu"></ul>
      <div id="contenido">
         <h2>Mis Tratamientos</h2>
         <table border="1" cellpadding="3">
            <tr>
               <th>Número</th>
               <th>Fecha Asignado</th>
               <th>Descripción</th>
               <th>Fecha Inicio</th>
               <th>Fecha Fin</th>
               <th>Observaciones</th>
            </tr>
            <?php while($trat = $result->fetch_object()) { ?>
            <tr>
               <td><?php echo $trat->TraNumero; ?></td>
               <td><?php echo $trat->TraFechaAsignado; ?></td>
               <td><?php echo $trat->TraDescripcion; ?></td>
               <td><?php echo $trat->TraFechaInicio; ?></td>
               <td><?php echo $trat->TraFechaFin; ?></td>
               <td><?php echo $trat->TraObservaciones; ?></td>
            </tr>
            <?php } ?>
         </table>
      </div>
   </div>
</body>
</html>