<?php
include('../../../../conexion.php');
$factura=$_REQUEST['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../../bootstrap/css/bootstrap.min.css">
	<link href="../../../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		html{
			padding: 15px;
		}
		.btn{
			border-radius: 0px;
		}
		.container{
			width: 100%;
			padding: 10px;
		}
		#com{
			font-size: 2em;
		}
		.nota{
			padding-top: 10px;
			height: 50px;
		}
		.form-control{
			border-radius: 0px;
		}
	</style>
</head>
<body>
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Modificar datos</i>
	<hr></hr>
</div>
<div class="container">

<?php
$SQL_DETALLE=mysql_query("SELECT  A.*, B.NOMBRE_ESTADO, C.NOMBRE_CLIENTE FROM FACTURA AS A, ESTADO AS B, CLIENTE AS C WHERE A.ESTADO=B.ID_ESTADO AND A.RUC_CLIENTE=C.RUC_CLIENTE AND A.NRO_FACTURA='$factura'",$conexion);
while ($ARR_DETA=mysql_fetch_array($SQL_DETALLE)) {
?>
<form action="proceso.php?id=<?php echo $ARR_DETA['NRO_FACTURA']?>" method="POST">
<div class="form-group">
<div class="col-xs-2">
	<input type="text" class="form-control input-sm" name="serie" value="<?php echo $ARR_DETA['SERIE_FACTURA'];?>">
</div>
<div class="col-xs-2">
	<input type="text" class="form-control input-sm" name="factura" value="<?php echo $ARR_DETA['NRO_FACTURA'];?>">
</div>
<div class="col-xs-2">
	<input type="date" class="form-control input-sm" name="fecha" value="<?php echo $ARR_DETA['FECHA_FACTURA'];?>">
</div>
<div class="col-xs-2">
	<input list="cliente" class="form-control input-sm" name="cliente" value="<?php echo $ARR_DETA['RUC_CLIENTE'];?>">
		<datalist id="cliente">
				<?php
					$SQL_CLIENTE=mysql_query("SELECT * FROM CLIENTE",$conexion);
					while ($ARR_CLI=mysql_fetch_array($SQL_CLIENTE)) {
						echo "<option value='".$ARR_CLI['RUC_CLIENTE']."'>".$ARR_CLI['NOMBRE_CLIENTE']."</option>";
					}
				?>
		</datalist>
</div>
<div class="col-xs-2">
	<select class="form-control input-sm" name="estado" id="pago">
				<option value="<?php echo $ARR_DETA['ESTADO'];?>"><?php echo $ARR_DETA['NOMBRE_ESTADO'];?></option>
				<?php
				$sql_estado=mysql_query("SELECT * FROM estado",$conexion);
				while ($r=mysql_fetch_array($sql_estado)) {
					echo "<option value='".$r['ID_ESTADO']."'>".$r['NOMBRE_ESTADO']."</option>";
				}
				?>
				</select>
</div>
<div class="col-xs-2">
	<input type="submit" name="modificar" class="btn btn-primary btn-sm" value="Procesar">
</div>
<?php
}
?>
</form>
<!--a href="modificar_detalle.php?id=<?php //echo $factura;?>">Modificar Detalle</a-->
</body>
	<script src='../../../../js/sweetalert.min.js'></script>
	<script src='../../../../js/jquery-3.2.1.min.js'></script>
	<script src="../../../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../../../bootstrap/js/bootstrap.js"></script>
	<script src="../../../../js/main.js"></script>
	<script src="../../../../js/jquery.mCustomScrollbar.concat.min.js"></script>
</html>