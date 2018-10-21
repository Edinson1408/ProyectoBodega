<?php
include('../../seguridad1.php');
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
	<?php
		$id=$_REQUEST['id'];
		$sql_pro=mysql_query("SELECT A.*,B.CLASE_PRODUCTO AS TIPO FROM producto AS A, clasificacion_producto AS B WHERE A.CLASE_PRODUCTO=B.COD_CLASIFICACION AND A.COD_PRODUCTO='$id'",$conexion);
		$r=mysql_fetch_array($sql_pro);
	?>
	<form action="mod_proceso.php?id=<?php echo $r['COD_PRODUCTO']?>" method="POST" name='modi' onKeyPress="return disableEnterKey(event)">
	<div class="form-group">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com">RegistrarProductos</i>
		<a href="index.html" class="btn btn-primary" style="float: right;">Regresar</a>
	</div>
		<label for="cod">Codigo</label>
		<input type="text"  id="cod" class="form-control input-sm" name="cod" value="<?php echo $r['COD_PRODUCTO'];?>" placeholder="Descripción">
		<label for="nombre">Producto</label>
		<input type="text"  id="nombre" class="form-control input-sm" name="nom" value="<?php echo $r['NOMBRE_PRODUCTO'];?>" placeholder="Descripción">
		<label for="pre">Precio Compra</label>
		<input type="text"  id="pre" class="form-control input-sm" name="precio" value="<?php echo $r['PRECIO_UNITARIO'];?>" placeholder="Precio Compra">
		<label for="prev">Precio venta</label>
		<input type="text"  id="prev" class="form-control input-sm" name="precio_ve" value="<?php echo $r['PRECIO_VENTA'];?>" placeholder="Precio Venta">
		<label for="ti">Tipo de Producto</label>
		<select name="tipo" id='ti' class="form-control input-sm">
			<option value="<?php echo $r['CLASE_PRODUCTO'];?>"><?php echo $r['TIPO'];?></option>
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
</body>
</html>