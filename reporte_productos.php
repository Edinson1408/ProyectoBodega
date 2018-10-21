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
		$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='1'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>1.- ".$r['TOTAL']."</td>
			 </tr>";
	}
		$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='2'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>2.- ".$r['TOTAL']."</td>
			 </tr>";
	}
		$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='3'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>3.- ".$r['TOTAL']."</td>
			 </tr>";
	}
		$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='4'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>4.- ".$r['TOTAL']."</td>
			 </tr>";
	}
		$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='5'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>5.- ".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='6'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>6.- ".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='7'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>7.- ".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='8'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>8.- ".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='9'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>9.-".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='10'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>10.- ".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='11'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>11.- ".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='12'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>12.-".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='13'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td> 13-. ".$r['TOTAL']."</td>
			 </tr>";
	}
			$sql_pro=mysql_query("SELECT COUNT(COD_PRODUCTO) AS TOTAL FROM PRODUCTO WHERE  CLASE_PRODUCTO='14'",$conexion);
	while ($r=mysql_fetch_array($sql_pro)) {
		echo "<tr>
				<td>14 .- ".$r['TOTAL']."</td>
			 </tr>";
	}
	$sql_productos=mysql_query("SELECT A.*, B.CLASE_PRODUCTO as clas FROM PRODUCTO AS A, CLASIFICACION_PRODUCTO AS B WHERE A.CLASE_PRODUCTO=B.COD_CLASIFICACION AND A.CLASE_PRODUCTO='1' ORDER BY NOMBRE_PRODUCTO ",$conexion);
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