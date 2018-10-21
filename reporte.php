<?php
include('conexion_2.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table>
	<tr>
	</tr>
	<?php
	$sql_compra_anterior=mysql_query("
		SELECT COD_PRODUCTO,SUM(CANTIDAD_PRODUCTO) AS CANTIDAD
		FROM MOVIMIENTO_ALMACEN 
		WHERE FECHA_FACTURA BETWEEN '2017-10-11' AND '2017-10-15' AND PROCESO='1' AND COD_PRODUCTO='7750520000099' 	
		GROUP BY COD_PRODUCTO",$conexion);
		$array_com_ante=mysql_fetch_array($sql_compra_anterior);
		echo $array_com_ante['CANTIDAD']."<br>";

	$sql_venta_anterior=mysql_query("
		SELECT COD_PRODUCTO,SUM(CANTIDAD_PRODUCTO) AS CANTIDAD
		FROM MOVIMIENTO_ALMACEN 
		WHERE FECHA_FACTURA BETWEEN '2017-10-11' AND '2017-10-15' AND PROCESO='2' AND COD_PRODUCTO='7750520000099' 	
		GROUP BY COD_PRODUCTO",$conexion);
		$array_ven_ante=mysql_fetch_array($sql_venta_anterior);
		echo $array_ven_ante['CANTIDAD']."<br>";

		$calculo_anterior=$array_com_ante['CANTIDAD']-$array_ven_ante['CANTIDAD'];
		echo $calculo_anterior."<br>";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$sql_compra=mysql_query("
		SELECT COD_PRODUCTO, SUM(CANTIDAD_PRODUCTO)  AS CANTIDAD
		FROM MOVIMIENTO_ALMACEN 
		WHERE FECHA_FACTURA BETWEEN '2017-10-15' AND '2017-10-29' AND PROCESO='1' AND COD_PRODUCTO='7750520000099' 	
		GROUP BY COD_PRODUCTO",$conexion);
		$array_compra=mysql_fetch_array($sql_compra);
		echo $array_compra['CANTIDAD']."<br>";

	$sql_venta=mysql_query("
		SELECT COD_PRODUCTO,SUM(CANTIDAD_PRODUCTO) AS CANTIDAD
		FROM MOVIMIENTO_ALMACEN 
		WHERE FECHA_FACTURA BETWEEN '2017-10-15' AND '2017-10-29' AND PROCESO='2' AND COD_PRODUCTO='7750520000099' 	
		GROUP BY COD_PRODUCTO",$conexion);
		$array_venta=mysql_fetch_array($sql_venta);
		echo $array_venta['CANTIDAD']."<br>";	

		$calculo_ingreso=$array_compra['CANTIDAD']+$calculo_anterior;
		$stock_actual=$calculo_ingreso-$array_venta['CANTIDAD'];

		echo $stock_actual;
	?>
</table>
</body>
</html>