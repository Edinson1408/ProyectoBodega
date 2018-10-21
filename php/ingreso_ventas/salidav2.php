<?php
//hay que hacer las validaciones de los vacios
include("../../conexion.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src='js/jquery-3.2.1.min.js'></script>
	<script type="text/javascript" src='js/verifica_1.js'></script>
		<style type="text/css">
		html{
			padding: 15px;
		}
		.btn{
			margin-top: 18px;
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
			border-bottom: 3px solid #337ab7;
		}
		.form-control{
			border-radius: 0px;
		}
	</style>
	<script>
function sf(ID){
document.getElementById(ID).focus();
}
</script>
</head>

</head>
<body onload="sf('btn');">
<?php
//NUEVO CODIGO DE BOLETA 
function gen_id()
{
include('../../conexion.php');
$cod1=mysqli_query($conexion,"SELECT max(NRO_FACTURA+1) AS ID FROM BOLETA WHERE PROCESO='2'");
$r2=mysqli_fetch_array($cod1);
return $r2['ID'];
}
$VAR_NUEVA_BOLETA=gen_id();
?>
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Agregar nueva venta</i>
	<a href="salidav2.php" class="btn btn-default" style="float: right;">Nueva venta</a>
</div>
<div class="container">
<div class="form-group">
<div class="col-xs-2">
fecha : <input type="date" class="form-control input-sm" name="" value="<?php date_default_timezone_set('America/Bogota'); echo date('Y-m-d')?>" id="fe">
</div>
<div class="col-xs-2">
Tipo Documento:	<select class="form-control input-sm" id="doc" disabled>
				<option>BOLETA</option>
				</select>
</div>
<div class="col-xs-2">
Nro Documento: <input type="text" name="" class="form-control input-sm" id="nro_bol" value="<?php echo $VAR_NUEVA_BOLETA; ?>">
</div>

<div class="col-xs-2">
<?php
	$SQL_CLIENTE=mysqli_query($conexion,"SELECT * FROM CLIENTE_1  ORDER BY RUC_DNI DESC ");
$ARR_CLI=mysqli_fetch_array($SQL_CLIENTE)
?>
Cliente: <input list="cliente" id="clie" class="form-control input-sm" name="" value="<?php echo $ARR_CLI['RUC_DNI'];?>">
					<datalist id="cliente">
					  <?php
					  	$SQL_CLIENTE=mysqli_query($conexion,"SELECT * FROM CLIENTE_1");
					  	while ($ARR_CLI=mysqli_fetch_array($SQL_CLIENTE)) {
					  		echo "<option value='".$ARR_CLI['RUC_DNI']."'>".$ARR_CLI['NOMBRE_C']."</option>";
					  	}
					  ?>
					</datalist>
</div>
<div class="col-xs-2">
<?php
$SQL_PAGO=mysqli_query($conexion,"SELECT * FROM ESTADO  ORDER BY ID_ESTADO ASC ");
$ARR_CLI=mysqli_fetch_array($SQL_PAGO)
?>
Pago:<select class="form-control input-sm" id="pago" >
				<option value="<?php echo $ARR_CLI['ID_ESTADO'];?>"><?php echo $ARR_CLI['NOMBRE_ESTADO'];?></option>
				<?php
				$sql_estado=mysqli_query($conexion,"SELECT * FROM estado");
				while ($r=mysqli_fetch_array($sql_estado)) {
					echo "<option value='".$r['ID_ESTADO']."'>".$r['NOMBRE_ESTADO']."</option>";
				}
				?>
				</select>
</div>
<div class="col-xs-2">
<input type="submit" name="" id="btn" class="btn btn-primary" value="Verificar" onclick="verificar();">
</div>
<div id="div_ajax">
</div>
</div>
</div>
</body>
</html>