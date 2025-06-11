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
   <title>Asignar Tratamiento</title>
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
         <h2>Asignar Tratamiento a Paciente</h2>
         <form method="POST" action="index.php?accion=guardarTratamiento">
            <table>
               <tr>
                  <td><b>Número de Tratamiento:</b></td>
                  <td> </td>
               </tr>
               <tr>
                  <td><b>Fecha Asignado:</b></td>
                  <td><?php echo date('Y-m-d'); ?></td>
               </tr>
               <tr>
                  <td><b>Descripción:</b></td>
                  <td><input type="text" name="TraDescripcion" required></td>
               </tr>
               <tr>
                  <td><b>Fecha Inicio:</b></td>
                  <td><input type="date" name="TraFechaInicio" required></td>
               </tr>
               <tr>
                  <td><b>Fecha Fin:</b></td>
                  <td><input type="date" name="TraFechaFin" required></td>
               </tr>
               <tr>
                  <td><b>Observaciones:</b></td>
                  <td><textarea name="TraObservaciones" rows="3"></textarea></td>
               </tr>
               <tr>
                  <td><b>Paciente:</b></td>
                  <td>
                     <select name="TraPaciente" required>
                        <option value="">Seleccione un paciente</option>
                        <?php
                        while($paciente = $pacientes->fetch_object()) {
                           echo "<option value='{$paciente->PacIdentificacion}'>";
                           echo "{$paciente->PacIdentificacion} - {$paciente->PacNombres} {$paciente->PacApellidos}";
                           echo "</option>";
                        }
                        ?>
                     </select>
                  </td>
               </tr>
               <tr>
                  
                  <td colspan="2">
                     <br>
                     <button type="submit">Asignar Tratamiento</button>
                  </td>
               </tr>
            </table>
         </form>
      </div>
   </div>
</body>
</html>