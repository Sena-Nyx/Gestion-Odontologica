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
   <title>Mis Citas</title>
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
         <h2>Mis Citas</h2>
         <table border="1" cellpadding="5">
            <tr>
               <th>Número</th>
               <th>Fecha</th>
               <th>Hora</th>
               <th>Estado</th>
               <th>Observaciones</th>
            </tr>
            <?php while($cita = $result->fetch_object()) { ?>
            <tr>
               <td><?php echo $cita->CitNumero; ?></td>
               <td><?php echo $cita->CitFecha; ?></td>
               <td><?php echo $cita->CitHora; ?></td>
               <td><?php echo $cita->CitEstado; ?></td>
               <td><?php echo $cita->CitObservaciones; ?></td>
            </tr>
            <?php } ?>
         </table>
      </div>
   </div>
</body>
</html>