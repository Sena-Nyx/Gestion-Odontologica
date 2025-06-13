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
   <link rel="stylesheet" type="text/css" href="Vista/css/estilos2.css">

   <script src="Vista/jquery/jquery-3.7.1.js"></script>
   <script>
      var rolUsuario = <?php echo json_encode($rol); ?>;
   </script> 
   <script src="Vista/js/menu.js"></script>
   <script src="Vista/jquery/jquery-ui-1.14.1.custom/jquery-ui.js" type="text/javascript"></script>
   <link href="Vista/jquery/jquery-ui-1.14.1.custom/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
   <script src="Vista/js/admin.js" type="text/javascript"></script>
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

         <h2>Editar Pacientes</h2>
         <div class="form-box">
            <form class="register-form" method="POST" action="index.php?accion=procesarEditarPaciente">
               <input type="hidden" name="identificacion" value="<?php echo $paciente->PacIdentificacion; ?>" required />
               <input type="text" name="nombres" value="<?php echo $paciente->PacNombres; ?>" required />
               <input type="text" name="apellidos" value="<?php echo $paciente->PacApellidos; ?>" required />
               <input type="date" name="fechaNacimiento" value="<?php echo $paciente->PacFechaNacimiento; ?>" required />
               <select name="sexo" required>
                  <option value="M" <?php if($paciente->PacSexo == "M") echo "selected"; ?>>Masculino</option>
                  <option value="F" <?php if($paciente->PacSexo == "F") echo "selected"; ?>>Femenino</option>
               </select>
               <br> <br>
               <input type="text" name="correo" value="<?php echo $paciente->pacCorreo; ?>" required />
               <br> <br>
               <button type="submit">Guardar</button>
            </form>
         </div>
      </div>
   </div>