<?php
include('../../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<link href="../../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../../css/select2.min.css" >
	<link rel="stylesheet" type="text/css" href="../../../css/select2.bootstrap.min.css" >
	<style type="text/css">
	    html, body{
	        background: rgb(236,240,245);
	    }
		.form-control{
			border-radius: 0;
		}
		.btn{
			border-radius: 0;
		}
	    .panel-default{
	        margin-top: 15px;
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
<form action="proveedores.php" method="POST">
	<div class="form-group">
	<div class="col-xs-3">
	<select name="prov" class="form-control input-sm">
		<option>Proveedores</option>
		<?php
		$sql_prove=mysql_query("SELECT * FROM CLIENTE",$conexion);
		while ($r=mysql_fetch_array($sql_prove)) {
		echo "<option value='".$r['RUC_CLIENTE']."'>".$r['NOMBRE_CLIENTE']."</option>";
		}
		?>
	</select>
	</div>
	</div>
	<div class="form-group">
	<div class="col-xs-2">
	<input type="date" name="inicio" class="form-control input-sm">
	</div>
	</div>
	<div class="form-group">
	<div class="col-xs-2">
	<input type="date" name="final" class="form-control input-sm">
	</div>
	</div>
	<input type="submit" name="buscar" value="Buscar" class="btn btn-default btn-sm">
	<a href="#" class="btn btn-default btn-sm" >General</a>
	<a href="pdf/proveedor_pdf.php" target="T_BLANK" class="btn btn-danger btn-sm">PDF</a>
	<a href="excel/proveedor_excel.php" class="btn btn-success btn-sm">Excel</a>
</form>
<div class="panel panel-default" id="panel1">
<div class="row">
<div class="col-md-12">
<div class="titulo" style="margin-left: 10px;">
    <h4>Proveedores</h4>
</div>
<table class="table table-striped">
	<tr>
		<th>Proveedor</th>
		<th>Factura</th>
		<th>Fecha</th>
		<th>SubTotal</th>
		<th>Igv</th>
		<th>Total</th>
	</tr>
	<?php
	error_reporting(0);
	session_start();
	$inicio=$_POST['inicio'];
	$final=$_POST['final'];
	$ruc=$_POST['prov'];
	$_SESSION['i']=$_POST['inicio'];
	$_SESSION['f']=$_POST['final'];
	$_SESSION['p']=$_POST['prov'];
	$sql_proveedor=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND (FECHA_FACTURA BETWEEN '$inicio' AND '$final') AND A.RUC_CLIENTE='$ruc' AND PROCESO='1'");
	if (isset($_POST['buscar'])) {
	while ($f=mysql_fetch_array($sql_proveedor)) {
		echo "<tr>";
			echo "<td>".$f['NOMBRE']."</td>";
			echo "<td>".$f['NRO_FACTURA']."</td>";
			echo "<td>".$f['FECHA_FACTURA']."</td>";
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
			echo "<td>".$f['NOMBRE']."</td>";
			echo "<td>".$f['NRO_FACTURA']."</td>";
			echo "<td>".$f['FECHA_FACTURA']."</td>";
			echo "<td>".$f['SUB_TOTAL']."</td>";
			echo "<td>".$f['IGV']."</td>";
			echo "<td>".$f['TOTAL']."</td>";
		echo "</tr>";
	}
	}
	?>
</table>
</body>
<script src='../../../js/jquery-3.2.1.min.js'></script>
<script src="../../../js/bootstrap.min.js"></script>
<script src="../../../js/select2.min.js"></script>
<script type="text/javascript">
	$('select').select2();
</script>
</html>