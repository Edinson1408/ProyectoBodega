<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
	<i class="fa fa-pencil-square-o" id="com">Boletas por cobrar</i>
	<a href="pago_venta.php" class="btn btn-default" style="float: right;">Cancelar pago</a>
</div>
<form action="cuentas_cobrar.php" method="POST">
<div class="form-group">
  <div class="col-xs-4">
	<select class="form-control" name="mes">
	    <option>Mes</option>
	    <?php
	    $meses = array(1 =>'Enero', 2 =>'Febrero',3 =>'Marzo' ,4 =>'Abril',5 =>'Mayo',6 =>'Junio',7 =>'Julio',8 =>'Agosto',9 =>'Septiembre',10 =>'octubre',11 =>'Noviembre',12 =>'Diciembre' );
	    for ($i=1; $i <=12  ; $i++) { 
	      echo "<option value='".$i."'>".$meses[$i]."</option>";

	     } 
	    ?>
	</select>
  </div>
  <div class="col-xs-4">
       <select class="form-control" name="año">
           <option>Año</option>
           <?php
           $año=2030; 
           for ($i=2016; $i <$año ; $i++) { 
                	echo "<option value='".$i."'>".$i."</option>";
           }
           ?>
       </select>
   </div>
   <div class="col-xs-2">
	<input type="submit" name="enviar" class="btn btn-default">
   </div>
</form>
</div>

<div class="container-fluid">
<table class="table table-bordered">
	<tr>
		<th style="line-height: 5pt;">DNI</th>
		<th style="line-height: 5pt;">Cliente</th>
		<th style="line-height: 5pt;">Boleta</th>
		<th style="line-height: 5pt;">Fecha Boleta</th>
		<th style="line-height: 5pt;">Monto</th>
		<th style="line-height: 5pt;">Debe</th>
	</tr>
	<?php
	include('../../conexion.php');
	error_reporting(0);
	$mes=$_POST['mes'];
	$año=$_POST['año'];
	if (!isset($_POST['enviar'])) {
		$sql_debe=mysql_query("SELECT a.*,b.NOMBRE_C AS NOMBRE FROM boleta as a , cliente_1 as b WHERE a.RUC_CLIENTE=b.RUC_DNI AND ESTADO='P'",$conexion);
		while ($array_debe=mysql_fetch_array($sql_debe)) {
			echo "<tr>
				<td style='line-height: 5pt;' >".$array_debe['RUC_CLIENTE']."</td>
				<td style='line-height: 5pt;' >".$array_debe['NOMBRE']."</td>
				<td style='line-height: 5pt;' >".$array_debe['NRO_FACTURA']."</td>
				<td style='line-height: 5pt;' >".$array_debe['FECHA_FACTURA']."</td>
				<td style='line-height: 5pt;' >".$array_debe['TOTAL']."</td>
				<td style='line-height: 5pt;' >".$array_debe['SALDO']."</td>
				</tr>";
		}
	}
	if (isset($_POST['enviar'])) {
		$sql_debe=mysql_query("SELECT a.*,b.NOMBRE_C AS NOMBRE FROM boleta as a , cliente_1 as b WHERE a.RUC_CLIENTE=b.RUC_DNI AND ESTADO='P' AND MONTH(FECHA_FACTURA)='$mes' and YEAR(FECHA_FACTURA)='$año'",$conexion);
		while ($array_debe=mysql_fetch_array($sql_debe)) {
			echo "<tr>
				<td style='line-height: 5pt;' >".$array_debe['RUC_CLIENTE']."</td>
				<td style='line-height: 5pt;' >".$array_debe['NOMBRE']."</td>
				<td style='line-height: 5pt;' >".$array_debe['NRO_FACTURA']."</td>
				<td style='line-height: 5pt;' >".$array_debe['FECHA_FACTURA']."</td>
				<td style='line-height: 5pt;' >".$array_debe['TOTAL']."</td>
				<td style='line-height: 5pt;' >".$array_debe['SALDO']."</td>
				</tr>";
		}
	}
	?>
</table>
</div>
	<script src='../../js/sweetalert.min.js'></script>
	<script src='../../js/jquery-3.2.1.min.js'></script>
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../bootstrap/js/bootstrap.js"></script>
	<script src="../../js/main.js"></script>
	<script src="../../js/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>