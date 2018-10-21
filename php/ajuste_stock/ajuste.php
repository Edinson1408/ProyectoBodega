<?php
include("../../conexion.php")
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src='js/jquery.js'></script>
    <script type="text/javascript" src='js/verificar.js'></script>
	<script>
		function sf(ID){
		document.getElementById(ID).focus();
		}
	</script>
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
			border-bottom: 3px solid #566573;
		}
		.form-control{
			border-radius: 0px;
		}
	</style>
		<?php
		//NUEVO CODIGO DE BOLETA 
		function gen_id()
		{
		include('../../conexion.php');
		$cod1=mysql_query("SELECT max(SERIE_FACTURA+1) AS ID FROM AJUSTE",$conexion);
		$r2=mysql_fetch_array($cod1);
		return $r2['ID'];
		}
		$VAR_NUEVA_BOLETA=gen_id();
		?>
<body onload="sf('btn');">
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Salidas de ajustes</i>
</div>
<div class="container">
<div class="form-group">
<div class="col-xs-2">
Fecha : <input type="date" name="" class="form-control input-sm"  id="fecha" value="<?php date_default_timezone_set('America/Bogota'); echo date('Y-m-d')?>">
</div>
<div class="col-xs-2">
Nro Serie : <input type="text" name="" class="form-control input-sm"  id="n_ser" value="00<?php echo $VAR_NUEVA_BOLETA; ?>">
</div>
<div class="col-xs-2">
Nro Ajuste : <input type="text" name="" class="form-control input-sm"  id="n_bol" value="AJU<?php echo $VAR_NUEVA_BOLETA; ?>">
</div>
<div class="col-xs-2">
<input type="submit" name="" class="btn btn-primary btn-sm" id="btn" onclick="verificar();">
</div>
<div id="div_ajax">
</div>
</div>
</div>
</body>
</html>