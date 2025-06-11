<?php
require_once '../fpdf/fpdf.php';
require_once '../../Modelo/Conexion.php';
require_once '../../Modelo/GestorCita.php';

$id = $_GET['numero'] ?? 0;

$gestor = new GestorCita();
$result = $gestor->consultarCitaPorId($id);
$fila = $result->fetch_object();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'Informacion de la Cita',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Datos del Paciente',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,8,'Documento:',0,0); $pdf->Cell(0,8,$fila->PacIdentificacion,0,1);
$pdf->Cell(50,8,'Nombre:',0,0); $pdf->Cell(0,8,$fila->PacNombres . " " . $fila->PacApellidos,0,1);

$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Datos del Medico',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,8,'Documento:',0,0); $pdf->Cell(0,8,$fila->MedIdentificacion,0,1);
$pdf->Cell(50,8,'Nombre:',0,0); $pdf->Cell(0,8,$fila->MedNombres . " " . $fila->MedApellidos,0,1);

$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,10,'Datos de la Cita',0,1);
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,8,'Numero:',0,0); $pdf->Cell(0,8,$fila->CitNumero,0,1);
$pdf->Cell(50,8,'Fecha:',0,0); $pdf->Cell(0,8,$fila->CitFecha,0,1);
$pdf->Cell(50,8,'Hora:',0,0); $pdf->Cell(0,8,$fila->CitHora,0,1);
$pdf->Cell(50,8,'Consultorio:',0,0); $pdf->Cell(0,8,$fila->ConNombre,0,1);
$pdf->Cell(50,8,'Estado:',0,0); $pdf->Cell(0,8,$fila->CitEstado,0,1);
$pdf->Cell(50,8,'Observaciones:',0,0); $pdf->Cell(0,8,$fila->CitObservaciones,0,1);

$pdf->Output('I', 'Cita_'.$fila->CitNumero.'.pdf');
exit;