<?php
if (!isset($_SESSION['correo'])) {
   header("Location: index.php?accion=login");
   exit;
}
$rol = $_SESSION['rol'];
?>

<!DOCTYPE html>
<html>
<head>
   <title>Interfaz Principal</title>
   <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
   <link rel="stylesheet" type="text/css" href="Vista/css/estilos2.css">
   
   <script>
      var rolUsuario = <?php echo json_encode($rol); ?>;
   </script>      
   <script src="Vista/jquery/jquery-3.7.1.js" type="text/javascript" ></script>
   <script src="Vista/jquery/jquery-ui-1.14.1.custom/jquery-ui.js" type="text/javascript"></script>
   <script src="Vista/js/menu.js"></script>
</head>
<body>
   <div id="contenedor">
      <div id="encabezado">
         <h1>Sistema de Gestión Odontológica</h1>
      </div>
      <ul id="menu"></ul>
      <div id="contenido">
         <h2>Bienvenido</h2>
         <div id="vista-dinamica"></div>
      </div>
   </div>
</body>
</html>