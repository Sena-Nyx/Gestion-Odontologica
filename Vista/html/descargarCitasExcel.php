<?php
require_once '../../Modelo/Conexion.php';
require_once '../../Modelo/GestorCita.php';

$doc = $_GET['doc'] ?? '';

$gestor = new GestorCita();
$result = $gestor->consultarCitasPorDocumento($doc);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=CitasPaciente_$doc.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1'>";
echo "<tr><th>Número</th><th>Fecha</th><th>Hora</th></tr>";
while($fila = $result->fetch_object()) {
    echo "<tr>";
    echo "<td>{$fila->CitNumero}</td>";
    echo "<td>{$fila->CitFecha}</td>";
    echo "<td>{$fila->CitHora}</td>";
    echo "</tr>";
}
echo "</table>";
exit;