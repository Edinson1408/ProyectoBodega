<?php
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
	<script type="text/javascript" src='js/verificar_2.js'></script>
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
</head>
<body>
<?php
//NUEVO CODIGO DE BOLETA 
function gen_id()
{
include('../../conexion.php');
$cod1=mysql_query("SELECT IFNULL(max(NRO_FACTURA+1),1) AS ID FROM BOLETA WHERE PROCESO='2'",$conexion);
$r2=mysql_fetch_array($cod1);
return $r2['ID'];
}
$VAR_NUEVA_BOLETA=gen_id();
?>
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">AJUSTE DE STOCK</i>
</div>
<div class="container">
<div class="form-group">
<div class="col-xs-2">
fecha : <input type="date" class="form-control input-sm" name="" value="<?php date_default_timezone_set('America/Bogota'); echo date('Y-m-d')?>" id="fe">
</div>
<div class="col-xs-2">
Nro Serie: <input type="text" name="" class="form-control input-sm" id="n_ser" value="00<?php echo $VAR_NUEVA_BOLETA?>">
</div>
<div class="col-xs-2">
Nro Documento: <input type="text" name="" class="form-control input-sm" id="nro_bol" value="<?php echo 'AJUS'.$VAR_NUEVA_BOLETA; ?>">
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