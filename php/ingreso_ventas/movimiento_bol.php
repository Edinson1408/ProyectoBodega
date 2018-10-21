<!DOCTYPE html>
<html>
<head>
	<title>
		
	</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<style type="text/css">
		blockquote{
			border-left: 5px solid #b54848;
		}
	</style>
</head>
<body>
<?php
	$id=$_GET['ID'];
?>
<div class="container">
<BLOCKQUOTE>
<h3>Documento <?php echo $id; ?></h3><br>
</BLOCKQUOTE>
<table class="table table-bordered" >
	<tr>
		<th>Boleta</th>
		<th>Producto</th>
		<th>Cantidad</th>
		<th>P.U</th>
		<th>Importe</th>
<?php
	include("../../conexion.php");
	$consulta=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO AS PRODUCTO FROM  detalle_boleta AS A, producto AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND  NRO_FACTURA='$id'",$conexion);
		while ($f=mysql_fetch_array($consulta)) {
			echo "<tr>";
				echo "<td>".$f['NRO_FACTURA']."</td>";
				echo "<td>".$f['PRODUCTO']."</td>";
				echo "<td>".$f['CANTIDAD_PRODUCTO']."</td>";
				echo "<td>".$f['PRECIO_UNITARIO']."</td>";
				echo "<td>".$f['IMPORTE']."</td>";
			echo "</tr>";
			}
?>
</tr>
</table>
</div>
	<script src='../../js/sweetalert.min.js'></script>
	<script src='../../js/jquery-3.2.1.min.js'></script>
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../bootstrap/js/bootstrap.js"></script>
	<script src="../../js/main.js"></script>
	<script src="../../js/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>