<?php
include('../../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>stock</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../../../css/bootstrap.css">
	<link rel="stylesheet" href="../../../css/bootstrap.min.css">
	<link href="../../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../../css/select2.min.css" >
	<link rel="stylesheet" type="text/css" href="../../../css/select2.bootstrap.min.css" >
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
<form action="stock.php" method="POST">
	<div class="form-group">
	<div class="col-xs-3">
	<select name="tipo" class="form-control input-sm">
		<option>Tipo de producto</option>
		<?php
		$sql_tipo=mysql_query("SELECT * FROM CLASIFICACION_PRODUCTO",$conexion);
		while ($r=mysql_fetch_array($sql_tipo)) {
		echo "<option value='".$r['COD_CLASIFICACION']."'>".$r['CLASE_PRODUCTO']."</option>";
		}
		?>
	</select>
	</div>
	</div>
	<input type="submit" name="buscar" value="Buscar" class="btn btn-default btn-sm">
	<a href="#" class="btn btn-default btn-sm">General</a>
	<a href="pdf/stock_pdf.php" target="T_BLANK" class="btn btn-danger btn-sm">PDF</a>
	<a href="excel/stock_excel.php" class="btn btn-success btn-sm">Excel</a>
</form>
<div class="panel panel-default" id="panel1">
<div class="row">
<div class="col-md-12">
<div class="titulo" style="margin-left: 10px;">
    <h4>Stock</h4>
</div>
<table class="table table-striped">
	<tr>
		<th>Tipo</th>
		<th>Producto</th>
		<th>Cantidad</th>
		<th>P.U</th>
		<th>P.Estimado</th>
	</tr>
	<?php
	session_start();
	error_reporting(0);
	$tipo=$_POST['tipo'];
	$_SESSION['t']=$_POST['tipo'];
	$sql_stock=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO AS PRO, B.PRECIO_VENTA,B.PRECIO_VENTA * A.CANTIDAD AS RESULTADO, C.CLASE_PRODUCTO AS CLA
		FROM ALMACEN AS A, PRODUCTO AS B, CLASIFICACION_PRODUCTO AS C   
		WHERE A.COD_PRODUCTO=B.COD_PRODUCTO 
		AND A.COD_CLASIFICACION=C.COD_CLASIFICACION
		AND A.COD_CLASIFICACION='$tipo'",$conexion);
	if (isset($_POST['buscar'])) {
	while ($r=mysql_fetch_array($sql_stock)) {
		echo "<tr>";
			echo "<td>".$r['CLA']."</td>";
			echo "<td>".$r['PRO']."</td>";
			echo "<td>".$r['CANTIDAD']."</td>";
			echo "<td>".$r['PRECIO_VENTA']."</td>";
			echo "<td>".$r['RESULTADO']."</td>";
		echo "</tr>";	
	}
	}
	if (!isset($_POST['buscar'])) {
	$sql_stock=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO AS PRO, B.PRECIO_VENTA,B.PRECIO_VENTA * A.CANTIDAD AS RESULTADO, C.CLASE_PRODUCTO AS CLA
		FROM ALMACEN AS A, PRODUCTO AS B, CLASIFICACION_PRODUCTO AS C   
		WHERE A.COD_PRODUCTO=B.COD_PRODUCTO 
		AND A.COD_CLASIFICACION=C.COD_CLASIFICACION",$conexion);
	while ($r=mysql_fetch_array($sql_stock)) {
		echo "<tr>";
			echo "<td>".$r['CLA']."</td>";
			echo "<td>".$r['PRO']."</td>";
			echo "<td>".$r['CANTIDAD']."</td>";
			echo "<td>".$r['PRECIO_VENTA']."</td>";
			echo "<td>".$r['RESULTADO']."</td>";
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
<script src='../../../js/jquery-3.2.1.min.js'></script>
<script src="../../../js/bootstrap.min.js"></script>
<script src="../../../js/select2.min.js"></script>
<script type="text/javascript">
	$('select').select2();
</script>
</html>