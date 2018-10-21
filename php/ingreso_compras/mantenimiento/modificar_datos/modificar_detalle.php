<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="" method="POST">
<table>
	<th>nro_factura</th>
	<th>producto</th>
	<th>Cantidad</th>
<?php
include('../../../../conexion.php');
$factura=$_REQUEST['id'];
$sql=mysql_query("SELECT * FROM DETALLE_FACTURA WHERE NRO_FACTURA='$factura'",$conexion);
$auto=1;
while ($arr=mysql_fetch_array($sql)) {
	$auto++;
	echo "<tr>";
		echo "<td>".$arr['NRO_FACTURA']."</td>";
		echo "<td>".$arr['COD_PRODUCTO']."</td>";
		echo "<td><input type='text' name='b".$auto."' value='".$arr['CANTIDAD_PRODUCTO']."'></td><br>";
	echo "</tr>";
}
?>
</table>
</form>
<?php
$sql_factura=mysql_query("SELECT COUNT(*) AS FILAS FROM DETALLE_FACTURA WHERE NRO_FACTURA='$factura'",$conexion);
$arr_sql=mysql_fetch_array($sql_factura);
$fila=$arr_sql['FILAS'];
for ($i=0; $i <= $filas ; $i++) { 
	$var='b'.$i;
	$cantidad=$_POST[$var];
	mysql_query("UPDATE DETALLE_FACTURA SET CANTIDAD_PRODUCTO='$cantidad' WHERE NRO_FACTURA='' ",$conexion);
}
?>
</body>
</html>