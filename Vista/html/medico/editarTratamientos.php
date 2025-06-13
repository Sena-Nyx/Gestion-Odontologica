<?php
if (!isset($_SESSION['correo']) || $_SESSION['rol'] != 3) {
   header("Location: ../../index.php?accion=login");
   exit;
}
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
   <title>Editar Tratamiento</title>
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
         <?php if (isset($_SESSION['nombre'])): ?>
            <div style="text-align:right; font-weight: bold; color: #0075ff;">
               <?php echo htmlspecialchars($_SESSION['nombre']); ?>
               <a href="index.php?accion=logout" style="font-weight:normal; color:#ff3333; font-size:0.95em; margin-left:10px;">Cerrar sesión</a>
            </div>
         <?php endif; ?>
         <h2>Editar Tratamiento</h2>
         <form method="POST" action="index.php?accion=procesarEditarTratamiento">
            <input type="hidden" name="TraNumero" value="<?php echo $tratamiento->TraNumero; ?>">
            <table>
               <tr>
                  <td><b>Descripción:</b></td>
                  <td><input type="text" name="TraDescripcion" value="<?php echo $tratamiento->TraDescripcion; ?>" required></td>
               </tr>
               <tr>
                  <td><b>Fecha Inicio:</b></td>
                  <td><input type="date" name="TraFechaInicio" value="<?php echo $tratamiento->TraFechaInicio; ?>" required></td>
               </tr>
               <tr>
                  <td><b>Fecha Fin:</b></td>
                  <td><input type="date" name="TraFechaFin" value="<?php echo $tratamiento->TraFechaFin; ?>" required></td>
               </tr>
               <tr>
                  <td><b>Observaciones:</b></td>
                  <td><textarea name="TraObservaciones" rows="3"><?php echo $tratamiento->TraObservaciones; ?></textarea></td>
               </tr>
               <tr>
                  <td colspan="2" style="text-align:center;">
                     <button type="submit">Guardar Cambios</button>
                  </td>
               </tr>
            </table>
         </form>
      </div>
   </div>
</body>
</html>