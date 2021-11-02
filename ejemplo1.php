<?php

$servidor="localhost";
$usuario="root";
$clave="";
$bdd="tecnologico";
$conectar=mysqli_connect($servidor,$usuario,$clave,$bdd);
$tabla="SELECT * FROM cursos WHERE codcur like 'FA%'";
$conexion=mysqli_query($conectar,$tabla);
require('fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,10,'TECNICA EN FARMACIA',0,0,'C');
$nro=0;
while($fila=mysqli_fetch_array($conexion))
{
    $codcur=$fila["codcur"];
    $nombre=$fila["nombre"];
    $cred=$fila["cred"];
    $horas=$fila["horas"];
    $codigo=$fila["codigo"];
    ++$nro;
    $pdf->Ln(2);
    $pdf->Cell($nro,10+$nro*16,$codcur." ".$nombre." ".$cred." ".$horas." ".$codigo);
}

$pdf->Output();
?>
