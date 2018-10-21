<?php
include('conexion_2.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<table border="3px">
	<tr>
		<th>NRO_FACTURA</th>
		<th>FECHA_FACTURA</th>
		<th>SERIE_FACTURA</th>
		<th>RUC_CLIENTE</th>
		<TH>COD_PRODUCTO</TH>
		<TH>CANTIDAD_PRODUCTO</TH>
		<TH>PRECIO_UNITARIO</TH>
		<TH>IMPORTE</TH>
	</tr>
	<?php
	$sql_productos=mysql_query("SELECT a.*,b.FECHA_FACTURA, b.SERIE_FACTURA, b.RUC_CLIENTE  FROM DETALLE_FACTURA as a, FACTURA as b WHERE a.NRO_FACTURA=b.NRO_FACTURA ORDER BY b.FECHA_FACTURA",$conexion);
	while ($r=mysql_fetch_array($sql_productos)) {
		echo "<tr>
				<td>".$r['NRO_FACTURA']."</td>
				<td>".$r['FECHA_FACTURA']."</td>
				<td>".$r['SERIE_FACTURA']."</td>
				<td>".$r['RUC_CLIENTE']."</td>
				<td>".$r['COD_PRODUCTO']."</td>
				<td>".$r['CANTIDAD_PRODUCTO']."</td>
				<td>".$r['PRECIO_UNITARIO']."</td>
				<td>".$r['IMPORTE']."</td>
			 </tr>";
	}
	?>
</table>
</body>
</html>