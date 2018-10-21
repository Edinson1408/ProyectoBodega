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
	<script language=JavaScript>
		function disableEnterKey(e){
		var key; 
		if(window.event){
		key = window.event.keyCode; //IE
		}else{
		key = e.which; //firefox 
		}
		if(key==13){
		return false;
		}else{
		return true;
		}
		}
	</script>
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
	<form action="reg_produ.php" method="POST" name="for" onKeyPress="return disableEnterKey(event)">
	<div class="form-group">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com">RegistrarProductos</i>
		<a href="index.html" class="btn btn-primary" style="float: right;">Regresar</a>
	</div>
		<label for="cod">Codigo</label>
		<input type="text"  id="cod" class="form-control input-sm" name="cod" placeholder="Codigo de Barra" required>
		<label for="nombre">Producto</label>
		<input type="text"  id="nombre" class="form-control input-sm" name="nom" placeholder="Descripción" required>
		<label for="pre">Precio Compra</label>
		<input type="text"  id="pre" class="form-control input-sm" name="precio" placeholder="Precio Compra">
		<label for="prev">Precio venta</label>
		<input type="text"  id="prev" class="form-control input-sm" name="precio_ve" placeholder="Precio Venta">
		<label for="ti">Tipo de Producto</label>
		<select name="tipo" id='ti' class="form-control input-sm" required>
			<option value="">Tipo</option>
			<?php
				$sql_tipo=mysql_query("SELECT * FROM CLASIFICACION_PRODUCTO",$conexion);
				while ($f=mysql_fetch_array($sql_tipo)) {
					echo "<option value='".$f['COD_CLASIFICACION']."'>".$f['CLASE_PRODUCTO']."</option>";
				}
			?>
		</select>
		<input type="submit" name="registrar" class="btn btn-primary" style="float: right;" value="Registrar">
	</div>
	</form>
</div>
<?php
error_reporting(0);
$codigo=$_POST['cod'];
$nombre=$_POST['nom'];
$precio=$_POST['precio'];
$venta=$_POST['precio_ve'];
$tipo=$_POST['tipo'];
if (isset($_POST['registrar'])) {
	mysql_query("INSERT INTO producto VALUES('$codigo','$nombre','$precio','$venta','$tipo')",$conexion);
	mysql_query("INSERT INTO almacen VALUES('','$tipo','$codigo','')",$conexion);
	header('location:reg_produ.php');
}
?>
</body>
</html>