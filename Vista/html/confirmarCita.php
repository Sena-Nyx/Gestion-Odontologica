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
         <div id="contenido" style="position: relative;">
            <?php if (isset($_SESSION['nombre'])): ?>
               <div style="position: absolute; top: 5px; right: 10px; font-weight: bold; color: #0075ff;">
                  <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                  <a href="index.php?accion=logout" style="font-weight:normal; color:#ff3333; font-size:0.95em;">Cerrar sesion</a>
               </div>
            <?php endif; ?>

            <?php $fila = $result->fetch_object();?>
            <h2>Información Cita</h2>
            <table>
               <tr>
                  <th colspan="2">Datos del Paciente</th>
               </tr>
               <tr>
                  <td>Documento</td>
                  <td><?php echo $fila->PacIdentificacion;?></td>
               </tr>
               <tr>
                  <td>Nombre</td>
                  <td><?php echo $fila->PacNombres . " " . $fila->PacApellidos;?></td>
               </tr>
               <tr>
                  <th colspan="2">Datos del Médico</th>
               </tr>
               <tr>
                  <td>Documento</td>
                  <td><?php echo $fila->MedIdentificacion;?></td>
               </tr>
               <tr>
                  <td>Nombre</td>
                  <td><?php echo $fila->MedNombres . " " . $fila->MedApellidos;?></td>
               </tr>
               <tr>
                  <th colspan="2">Datos de la Cita</th>
               </tr>
               <tr>
                  <td>Número</td>
                  <td><?php echo $fila->CitNumero;?></td>
               </tr>
               <tr>
                  <td>Fecha</td>
                  <td><?php echo $fila->CitFecha;?></td>
               </tr>
               <tr>
                  <td>Hora</td>
                  <td><?php echo $fila->CitHora;?></td>
               </tr>
               <tr>
                  <td>Número de Consultorio</td>
                  <td><?php echo $fila->ConNombre;?></td>
               </tr>
               <tr>
                  <td>Estado</td>
                  <td><?php echo $fila->CitEstado;?></td>
               </tr>
               <tr>
                  <td>Observaciones</td>
                  <td><?php echo $fila->CitObservaciones;?></td>
               </tr>
            </table>
            <br> 
            <a href="Vista/html/descargarCitaPdf.php?numero=<?php echo $fila->CitNumero; ?>" target="_blank">
               <button>Descargar PDF</button>
            </a>  
         </div>
      </div>
   </body>
</html>