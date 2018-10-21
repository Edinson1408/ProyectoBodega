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
	<form action="reg_prove.php" method="POST">
	<div class="form-group">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com">RegistrarProveedor</i>
		<a href="proveedor.php" class="btn btn-primary" style="float: right;">Regresar</a>
	</div>
		<label for="ruc">RUC-DNI</label>
		<input type="text"  id="ruc" class="form-control input-sm" name="ruc-dni" placeholder="RUC-DNI" required>
		<label for="pro">Proveedor</label>
		<input type="text"  id="pro" class="form-control input-sm" name="prove" placeholder="Proveedor">
		<label for="eje">Numero de Ejecutivo</label>
		<input type="text"  id="eje" class="form-control input-sm" name="eje_num" placeholder="N°Ejecutivo">
		<label for="eje_nom">Nombre de Ejecutivo</label>
		<input type="text"  id="eje_nom" class="form-control input-sm" name="eje_nom" placeholder="Nombre_Ejecutivo">
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
$num_eje=$_POST['eje_num'];
$nom_eje=$_POST['eje_nom'];
$dire=$_POST['dire'];
$tel=$_POST['tel'];
$corr=$_POST['corr'];
if (isset($_POST['registrar'])) {
	$inser=mysql_query("INSERT INTO cliente VALUES('$ruc','$prove','$num_eje','$nom_eje','$dire','$tel','$corr')",$conexion);
	header('location:reg_prove.php');
}
?>
</body>
</html>