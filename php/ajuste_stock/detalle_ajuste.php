<?php
include("../../conexion.php");
$boleta=$_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Detalle Ajuste</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<table class="table table-bordered">
	<tr>
		<th>Producto</th>
		<th>Cantidad</th>	
	</tr>
	<?php
	$sql_ajuste=mysql_query("SELECT A.*, B.NOMBRE_PRODUCTO AS PRODUCTO FROM detalle_ajuste as A, producto as B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND  NRO_FACTURA='$boleta'",$conexion);
	while ($arr=mysql_fetch_array($sql_ajuste)) {
		echo "<tr>";
			echo "<td>".$arr['PRODUCTO']."</td>";
			echo "<td>".$arr['CANTIDAD_PRODUCTO']."</td>";
		echo "</tr>";
	}
	?>
</table>
</body>
</html>