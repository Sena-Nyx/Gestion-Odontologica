<?php
if (!isset($_SESSION['correo']) || $_SESSION['rol'] != 2) {
   header("Location: ../../index.php?accion=login");
   exit;
}
$rol = $_SESSION['rol'];
?>

<?php
if (isset($_GET['pos'])) {
   $inicio = intval($_GET['pos']);
} else {
   $inicio = 0;
}
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
         <h2>Información Cita</h2>
         <?php $cita = $result->fetch_object();
         if ($cita) {
         ?>
         <span><b>Numero de Cita</b></span>
         <br>
         <td><?php echo $cita->CitNumero;?></td>
         <br> <br>
         <table>
            <tr>
               <th colspan="3">Datos del Médico</th>
            </tr>
            <tr>
               <td>Documento</td>
               <td><?php echo $cita->MedIdentificacion;?></td>
            </tr>
            <tr>
               <td>Nombre</td>
               <td><?php echo $cita->MedNombres . " " . $cita->MedApellidos;?></td>
            </tr>
            <tr>
               <th colspan="3">Datos de la Cita</th>
            </tr>
            <tr>
               <td>Número</td>
               <td><?php echo $cita->CitNumero;?></td>
            </tr>
            <tr>
               <td>Fecha</td>
               <td><?php echo $cita->CitFecha;?></td>
            </tr>
            <tr>
               <td>Hora</td>
               <td><?php echo $cita->CitHora;?></td>
            </tr>
            <tr>
               <td>Número de Consultorio</td>
               <td><?php echo $cita->ConNombre;?></td>
            </tr>
            <tr>
               <td>Estado</td>
               <td><?php echo $cita->CitEstado;?></td>
            </tr>
            <tr>
               <td>Observaciones</td>
               <td><?php echo $cita->CitObservaciones;?></td>
            </tr>
         </table>
         <br> 
         <a href="Vista/html/descargarCitaPdf.php?numero=<?php echo $cita->CitNumero; ?>" target="_blank">
            <button>Descargar PDF</button>
         </a>
         <br> <br>
         <?php
         // Paginacion
         if ($inicio == 0)
            echo "Anteriores ";
         else {
            $anterior = $inicio - 1;
            echo "<a href=\"index.php?accion=verCitasPac&pos=$anterior\">Anteriores</a> ";
         }
         if ($inicio < $totalCitas - 1)
         {
            $proximo = $inicio + 1;
            echo "<a href=\"index.php?accion=verCitasPac&pos=$proximo\">Siguientes</a>";
         } else
            echo "Siguientes";
         } 
         
         else {
            echo "<p>No tienes citas asignadas</p>";
         }
         ?>
      </div>
   </div>
</body>
</html>