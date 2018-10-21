<?php
include('../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Fecha de inventario</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
		.form-control, .btn{
			border-radius: 0;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com">Inventario</i>
	</div>
<form action="inventario.php" method="POST">
	<div class="form-group">
  		<div class="col-xs-3">
			<input type="date" name="fec_ini" class="form-control input-sm">
		</div>
	</div>

	<div class="form-group">
  		<div class="col-xs-3">
			<input type="date" name="fec_fin" class="form-control input-sm">
		</div>
	</div>

	<div class="form-group">
		<div class="col-xs-3">
			<select name="clase" class="form-control input-sm">
				<option>Tipo de Producto</option>
				<?php
				$sql_clase=mysql_query("SELECT * FROM CLASIFICACION_PRODUCTO",$conexion);
				while ($array_clase=mysql_fetch_array($sql_clase)) {
					echo "<option value='".$array_clase['COD_CLASIFICACION']."'>".$array_clase['CLASE_PRODUCTO']."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<input type="submit" name="filtrar" value="Consultar" class="btn btn-primary btn-sm">
</form>
</div>
</body>
</html>