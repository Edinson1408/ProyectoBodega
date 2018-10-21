<?php
	include('../../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<link href="../../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	html{
		padding: 15px;
	}
	.nota{
		padding-top: 10px;
		height: 50px;
		border-bottom: 3px solid #337ab7;
	}
	#com{
		font-size: 2em;
	}
	.form-group{
		width: 70%;
		margin: auto;
	}
	</style>
</head>
<body>
<div class="container">
	<form action="reg_cli.php" method="POST">
	<div class="form-group">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com">RegistrarCliente</i>
		<a href="cliente.php" class="btn btn-primary" style="float: right;">Regresar</a>
	</div>
		<label for="ruc">RUC-DNI</label>
		<input type="text"  id="ruc" class="form-control input-sm" name="ruc-dni" placeholder="RUC-DNI" required>
		<label for="pro">Cliente</label>
		<input type="text"  id="pro" class="form-control input-sm" name="prove" placeholder="Cliente">
		<label for="di">Dirección</label>
		<input type="text"  id="di" class="form-control input-sm" name="dire" placeholder="Dirección">
		<label for="te">Telefono</label>
		<input type="text"  id="te" class="form-control input-sm" name="tel" placeholder="Telefono">
		<label for="co">Correo</label>
		<input type="text"  id="co" class="form-control input-sm" name="corr" placeholder="Correo">
		<input type="submit" name="registrar" class="btn btn-primary" style="float: right;" value="Registrar">
	</div>
	</form>
</div>
<?php
error_reporting(0);
$ruc=$_POST['ruc-dni'];
$prove=$_POST['prove'];
$dire=$_POST['dire'];
$tel=$_POST['tel'];
$corr=$_POST['corr'];
if (isset($_POST['registrar'])) {
	$inser=mysql_query("INSERT INTO cliente_1 VALUES('$ruc','$prove','$dire','$tel','$corr')",$conexion);
	header('location:reg_cli.php');
}
?>
</body>
</html>