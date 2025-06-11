<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title></title>
   </head>
   <body>
      <?php
      $docPaciente = '';
      if($result->num_rows > 0){
         $result->data_seek(0); // Asegura que el puntero esté al inicio
         $primerFila = $result->fetch_object();
         $docPaciente = $primerFila->CitPaciente;
         $result->data_seek(0); // Regresa el puntero para el while
      ?>
      <table>
         <caption> <b>Citas del Paciente</b> </caption>
         <br> <br>
         <tr>
            <th>Número</th><th>Fecha</th><th>Hora</th>
         </tr>
         <?php
         while($fila=$result->fetch_object()){
         ?>
         <tr>
            <td><?php echo $fila->CitNumero;?></td>
            <td><?php echo $fila->CitFecha;?></td>
            <td><?php echo $fila->CitHora;?></td>
            <td><a href="index.php?accion=verCita&numero=<?php echo $fila->CitNumero; ?>">Ver</a></td>
         </tr>
         <?php
            }
         ?>
      </table>
      <br>
      <button type="button" onclick="window.open('Vista/html/descargarCitasExcel.php?doc=<?php echo htmlspecialchars($docPaciente); ?>', '_blank')">Descargar Excel</button>
      <?php
      }
      else {
      ?>
         <p>El paciente no tiene citas asignadas</p>
      <?php
      }
      ?>
   </body>
</html>