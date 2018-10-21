<?php
include('../../../../conexion.php');

$factura=$_REQUEST['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../../bootstrap/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<form action="" method="POST">
<div class="form-group">
	<div class="col-xs-4">
	Producto : <input list="producto" class="form-control input-sm" name="pro">
						<datalist id="producto">
						  <?php
							  	$SQL_PRODUCTO=mysql_query("SELECT * FROM PRODUCTO",$conexion);
							  	while ($ARR_PRO=mysql_fetch_array($SQL_PRODUCTO)) 
							  	{
							  		echo "<option value='".$ARR_PRO['COD_PRODUCTO']."'>".$ARR_PRO['NOMBRE_PRODUCTO']."</option>";
							  	}
						  ?>
						</datalist>
	</div>
	<div class="col-xs-4">
	cantidad : <input type="text"  class="form-control input-sm" id="cantidad" name="canti">
	</div>
	<div class="col-xs-4">
	<br><input type="submit" name="boton_agregar" class="btn btn-primary btn-sm" value="Agregar" >
	</div>
</div>
</form>
<table class="table table-bordered">
	<tr>
		<th style='line-height: 8pt;'>Factura</th>
		<th style='line-height: 8pt;'>Producto</th>
		<th style='line-height: 8pt;'>Cantidad</th>
		<th style='line-height: 8pt;'>P. Unitario</th>
		<th style='line-height: 8pt;'>Total</th>
	</tr>
	<?php
	if (!isset($_POST['boton_agregar'])) {
	$sql_factura=mysql_query("SELECT A.*, B.NOMBRE_PRODUCTO FROM DETALLE_FACTURA AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND NRO_FACTURA='$factura'",$conexion);
	while ($arr_fac=mysql_fetch_array($sql_factura)) {
		echo "<tr>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['NRO_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['NOMBRE_PRODUCTO']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['CANTIDAD_PRODUCTO']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['PRECIO_UNITARIO']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['IMPORTE']."</td>";
			echo "<td><a href='eliminar.php?id=".$arr_fac['COD_PRODUCTO']."&factura=".$arr_fac['NRO_FACTURA']."'>x</a>";
		echo "</tr>";
	}
}
error_reporting(0);
$producto=$_POST['pro'];
$cantidad=$_POST['canti'];
if (isset($_POST['boton_agregar'])) {
$SQL_PRODUCTO=mysql_query("SELECT * FROM PRODUCTO WHERE COD_PRODUCTO='$producto'",$conexion);
$ARR_PRODUCTO=mysql_fetch_array($SQL_PRODUCTO);
$precio=$ARR_PRODUCTO['PRECIO_UNITARIO'];
$SQL_FACTURA=mysql_query("SELECT * FROM FACTURA WHERE NRO_FACTURA='$factura'",$conexion);
$ARR_FACTURA=mysql_fetch_array($SQL_FACTURA);
$fecha=$ARR_FACTURA['FECHA_FACTURA'];
$total=$ARR_FACTURA['TOTAL'];

$importe=$cantidad*$precio;

$sumar=$total+$importe;
$sub_total=$sumar/1.18;
$igv=$sumar-$sub_total;

mysql_query("INSERT INTO DETALLE_FACTURA VALUES('$factura','$producto','$cantidad','$precio','$importe','1')",$conexion);
mysql_query("INSERT INTO MOVIMIENTO_ALMACEN VALUES('','$factura','$fecha','$producto','$cantidad','1')",$conexion);
mysql_query("UPDATE FACTURA SET SUB_TOTAL='$sub_total', IGV='$igv', TOTAL='$sumar' WHERE NRO_FACTURA='$factura'",$conexion);

	$sql_factura=mysql_query("SELECT A.*, B.NOMBRE_PRODUCTO FROM DETALLE_FACTURA AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND  NRO_FACTURA='$factura'",$conexion);
	while ($arr_fac=mysql_fetch_array($sql_factura)) {
		echo "<tr>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['NRO_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['NOMBRE_PRODUCTO']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['CANTIDAD_PRODUCTO']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['PRECIO_UNITARIO']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['IMPORTE']."</td>";
			echo "<td><a href='eliminar.php?id=".$arr_fac['COD_PRODUCTO']."&factura=".$arr_fac['NRO_FACTURA']."'>x</a>";
		echo "</tr>";
	}
}
?>
</table>
<a href="../index.php" class="btn btn-deafault btn-sm">Regresar</a>
</div>
</body>
	<script src='../../../../js/sweetalert.min.js'></script>
	<script src='../../../../js/jquery-3.2.1.min.js'></script>
	<script src="../../../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../../../bootstrap/js/bootstrap.js"></script>
	<script src="../../../../js/main.js"></script>
	<script src="../../../../js/jquery.mCustomScrollbar.concat.min.js"></script>
</html>