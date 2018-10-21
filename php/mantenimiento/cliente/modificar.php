<?php
	include('../../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
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
	<?php
		$id=$_REQUEST['id'];
		$sql_pro=mysql_query("SELECT * FROM cliente_1 WHERE RUC_DNI='$id'",$conexion);

		$r=mysql_fetch_array($sql_pro);
	?>
	<form action="mod_proceso.php?id=<?php echo $r['RUC_DNI']?>" method="POST">
	<div class="form-group">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com">RegistrarProveedor</i>
		<a href="proveedor.php" class="btn btn-primary" style="float: right;">Regresar</a>
	</div>
		<label for="ruc">RUC-DNI</label>
		<input type="text"  id="ruc" class="form-control input-sm" name="ruc-dni" value="<?php echo $r['RUC_DNI'];?>" >
		<label for="pro">Proveedor</label>
		<input type="text"  id="pro" class="form-control input-sm" name="prove" value="<?php echo $r['NOMBRE_C'];?>" >
		<label for="di">Dirección</label>
		<input type="text"  id="di" class="form-control input-sm" name="dire" value="<?php echo $r['DIR_CLI'];?>" >
		<label for="te">Telefono</label>
		<input type="text"  id="te" class="form-control input-sm" name="tel" value="<?php echo $r['TEL_CLIE'];?>" >
		<label for="co">Correo</label>
		<input type="text"  id="co" class="form-control input-sm" name="corr" value="<?php echo $r['CORRE_CLI'];?>">
		<input type="submit" name="registrar" class="btn btn-primary" style="float: right;" value="Registrar">
	</div>
	</form>
</div>
</body>
</html>