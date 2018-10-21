<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="clasi_producto.php" method="POST">
	<div>
		<input type="text" name="clasi">
		<input type="submit" name="registrar">
	</div>
</form>
<?php
include('../../seguridad1.php');
include('../../../conexion.php');
include('gen_clase.php');
$nom=$_POST['clasi'];
if ($_POST['registrar']) {
	$codigo=gen_id('clasificacion_producto');
	mysql_query("INSERT INTO clasificacion_producto VALUES ('$codigo','$nom')",$conexion);
	header('location:clasi_producto.php');
}
?>
</body>
</html>