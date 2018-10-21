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
		<th>CODIGO_BARRAS</th>
		<TH>NOMBRE DE PRODUCTO</TH>
		<TH>PRECIO_COMPRA</TH>
		<TH>PRECIO_vENTA</TH>
		<TH>CLASE DE PRODUCTO</TH>
	</tr>
	<?php
		$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>".$r['TOTAL']."</td>
			 </tr>";
	}
	$sql_productos=mysql_query("SELECT A.*, B.CLASE_PRODUCTO as clas FROM PRODUCTO AS A, CLASIFICACION_PRODUCTO AS B WHERE A.CLASE_PRODUCTO=B.COD_CLASIFICACION",$conexion);
	while ($r=mysql_fetch_array($sql_productos)) {
		echo "<tr>
				<td>".$r['COD_PRODUCTO']."</td>
				<td>".$r['NOMBRE_PRODUCTO']."</td>
				<td>".$r['PRECIO_UNITARIO']."</td>
				<td>".$r['PRECIO_VENTA']."</td>
				<td>".$r['clas']."</td>
			 </tr>";
	}


	


	?>
</table>
</body>
</html>