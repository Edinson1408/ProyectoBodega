<?php
include('../../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Rango de fechas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<link href="../../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		.form-control{
			border-radius: 0;
		}
		.btn{
			border-radius: 0;
		}
	    .panel-default{
	        margin-top: 15px;
	    }
	    html, body{
	        background: rgb(236,240,245);
	    }
	    .titulo{
	        border-bottom: 2px solid #F2F2F2; 
	        margin-bottom: 5px;
	    }
	    .container{
	        width: 100%;
	    }
	    .table{
	      width: 98%;
	      margin:auto; 
	    }
	    a.btn{
	    	float: right;
	    	margin-left: 5px;
	    }
	</style>
</head>
<body>
<div class="container">
<form action="rang_fec_compras.php" method="POST">
	<div class="form-group">
	<div class="col-xs-3">
	<input type="date" name="inicio" class="form-control input-sm" >
	</div>
	</div>
	<div class="form-group">
	<div class="col-xs-3">
	<input type="date" name="final" class="form-control input-sm" >
	</div>
	</div>
	<input type="submit" name="buscar" class="btn btn-default btn-sm"  value="Buscar">
	<a href="#" class="btn btn-default btn-sm">General</a>
	<a href="pdf/rango_compras_pdf.php" target="T_BLANK" class="btn btn-danger btn-sm">PDF</a>
	<a href="excel/rango_compras_excel.php" class="btn btn-success btn-sm">Excel</a>
</form>
<div class="panel panel-default" id="panel1">
<div class="row">
<div class="col-md-12">
<div class="titulo" style="margin-left: 10px;">
    <h4>Compras - Rango de Fechas</h4>
</div>
<table class="table table-striped">
	<tr>
		<th>Factura N°</th>
		<th>Fecha</th>
		<th>Proveedor</th>
		<th>Sub_Total</th>
		<th>Igv</th>
		<th>Total</th>
	</tr>
	<?php
	error_reporting(0);
	session_start();
	$inicio=$_POST['inicio'];
	$final=$_POST['final'];
	$_SESSION['i']=$_POST['inicio'];
	$_SESSION['f']=$_POST['final'];
	$sql_rango=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND (FECHA_FACTURA BETWEEN '$inicio' AND '$final') AND PROCESO='1'",$conexion);
	if (isset($_POST['buscar'])) {
	while ($f=mysql_fetch_array($sql_rango)) {
		echo "<tr>";
			echo "<td>".$f['NRO_FACTURA']."</td>";
			echo "<td>".$f['FECHA_FACTURA']."</td>";
			echo "<td>".$f['NOMBRE']."</td>";
			echo "<td>".$f['SUB_TOTAL']."</td>";
			echo "<td>".$f['IGV']."</td>";
			echo "<td>".$f['TOTAL']."</td>";
		echo "</tr>";
	}
	}
	if (!isset($_POST['buscar'])) {
	$sql_proveedor=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND PROCESO='1'");
	while ($f=mysql_fetch_array($sql_proveedor)) {
		echo "<tr>";
			echo "<td>".$f['NRO_FACTURA']."</td>";
			echo "<td>".$f['FECHA_FACTURA']."</td>";
			echo "<td>".$f['NOMBRE']."</td>";
			echo "<td>".$f['SUB_TOTAL']."</td>";
			echo "<td>".$f['IGV']."</td>";
			echo "<td>".$f['TOTAL']."</td>";
		echo "</tr>";
	}
	}
	?>
</table>
</div>
</div>
</div>
</div>
</body>
</html>