<?php
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="css/estilos.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/">
 </script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
 </script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
</head>
<body>
<?php   
$servidor="localhost";
$usuario="root";
$clave="";
$bdd="tecnologico";
$conexion=mysqli_connect($servidor,$usuario,$clave,$bdd);
$tabla="SELECT * FROM cursos WHERE codcur like 'FA%'";
$conectar=mysqli_query($conexion,$tabla);
$cursos=array();
while($filas=mysqli_fetch_array($conectar))
{
	$cursos[]=$filas;
}
	
?>
<div class="container">
	<table class="table table-bordered">
		<tr>
			<td>Nro</td><td>CÓDIGO</td><td>NOMBRE</td><td>CRÉDITOS</td><td>HORAS</td>
		</tr> <br>
		<tbody>
			<?php  
				$x=0;
				foreach($cursos as $curso)
				{
					++$x;
			?>
				<tr>
					<td><?php echo $x; ?></td>
					<td><?php echo $curso["codcur"]; ?></td>
					<td><?php echo $curso["nombre"];?></td>
					<td><?php echo $curso["cred"];?></td>
					<td><?php echo $curso["horas"];?></td>
					<td><?php echo $curso["codigo"];?></td>
				</tr>
			<?php		
				}
			?>

		</tbody>
	</table>
    <br>
	<form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
		<button type="submit" id="exportar" name='exportar'
value="Export to excel" class="btn btn-danger">Exportar a Excel</button>
	</form>
<?php  
	if(isset($_POST["exportar"])) 
	{
		 if(!empty($cursos)) 
		 {
		 	$filename ="cursos.xls";
		 	header("Content-Type: application/vnd.ms-excel; name='excel'");
		 	header("Content-Disposition: attachment; filename=".$filename);
			header('Pragma: public');
			header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1 
			header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1 
			header('Pragma: no-cache');
			header('Expires: 0');
			header('Content-Transfer-Encoding: none');
			//header('Content-type: application/vnd.ms-excel;charset=utf-8');// This should work for IE & Opera 
			header('Content-type: application/x-msexcel; charset=utf-8'); // This should work for the rest 
			header("Content-Disposition: attachment; filename=".$filename);
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");

		 }
		 else
		 {
		 	echo 'No hay datos a exportar';
		 }
		 exit;
	}

?>
</div>
</body>
</html>
<?php
ob_end_flush();
?>
<?php
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
