<?php
	session_start();
	include ('../../conexion.php');
	$producto=$_GET['cod'];
	$inicio=$_GET['fe1'];
	$fin=$_GET['fe2'];
	$_SESSION['i']=$inicio;
	$_SESSION['f']=$fin;
	$_SESSION['pro']=$producto;
	$SQL_NOMBRE=mysql_query("SELECT * FROM PRODUCTO WHERE COD_PRODUCTO='$producto'",$conexion);
	$r=mysql_fetch_array($SQL_NOMBRE);
?>	
<!DOCTYPE html>
<html>
<head>
	<title>MovimientoAlmacen</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		td{
			text-align: center;
		}
		th{
			text-align: center;
		}
		td, .nombre{
			text-align: left;
		}
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
		#ca{
			margin-top: 10px;
			font-size: 1.3em;
		}
		.content-box-gray,
		.content-box-white{
		margin: 0 0 25px;
		overflow: hidden;
		padding: 10px;
		width: 7%;
		}
		.content-box-white {
		background-color: #ffffff;
		border: 1px solid #BDBDBD;
		float: left;
		}
		.content-box-gray {
		background-color: #e2e2e2;
		border: 1px solid #bdbdbd;
		float: left;
		}
		.btn{
			border-radius: 0;
		}
</style>
</head>
<body>
<div class="container">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com" >Movimiento - <?php echo $r['NOMBRE_PRODUCTO'];?></i>
	</div>
	<i class='fa fa-calendar' aria-hidden='true' id='ca'> Fechas:<strong> Desde : <?php echo $inicio; ?> Hasta : <?php echo $fin;?></strong></i><br><br>
	<div class="content-box-white">
	Ingresos
	</div>
	<div class="content-box-gray">
	Salidas
	</div>
	<a href="mov_almacen_pdf.php" target="T_BLANK" class="btn btn-danger btn-sm" style="float: right;">PDF</a>
	<a href="mov_almacen_excel.php" class="btn btn-success btn-sm" style="float: right;">Excel</a>

<table class="table table-bordered">
	<tr>
		<th style="line-height: 6pt; text-align: center;">Producto</th>
		<th style="line-height: 6pt; text-align: center;">Boleta</th>
		<th style="line-height: 6pt; text-align: center;">Fecha</th>
		<th style="line-height: 6pt; text-align: center;">Anterior</th>
		<th style="line-height: 6pt; text-align: center;">Ingreso</th>
		<th style="line-height: 6pt; text-align: center;">Salida</th>
		<th style="line-height: 6pt; text-align: center;">Actual</th>
	</tr>
	<?php
	$ingreso_anterior=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS INGRESO_ANTERIOR FROM movimiento_almacen WHERE COD_PRODUCTO='$producto' AND FECHA_FACTURA<'$inicio' AND PROCESO='1'",$conexion);
	$salida_anterior=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS SALIDA_ANTERIOR FROM movimiento_almacen WHERE COD_PRODUCTO='$producto' AND FECHA_FACTURA<'$inicio' AND PROCESO='2'",$conexion);
	$arr_ing_ante=mysql_fetch_array($ingreso_anterior);
	$arr_sal_ante=mysql_fetch_array($salida_anterior);


	$sql_movimiento=mysql_query("SELECT A.*, B.NOMBRE_PRODUCTO AS PRO FROM MOVIMIENTO_ALMACEN AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND  A.COD_PRODUCTO='$producto' AND A.FECHA_FACTURA BETWEEN '$inicio' AND '$fin' ORDER BY FECHA_FACTURA",$conexion);
	$SALDO_ANTERIOR=$arr_ing_ante['INGRESO_ANTERIOR']-$arr_sal_ante['SALIDA_ANTERIOR'];

	while ($arr_movi=mysql_fetch_array($sql_movimiento)){
		if ($arr_movi['PROCESO']==1) {
			$SI=$arr_movi['CANTIDAD_PRODUCTO'];
			$SALDO_ACTUAL=$SALDO_ANTERIOR+$SI;
			echo '<tr>';
				echo '<td style="line-height: 6pt; text-align: left;">'.$arr_movi['PRO'].'</td>';
				echo '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['NRO_FACTURA'].'</td>';
				echo '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['FECHA_FACTURA'].'</td>';
				echo '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ANTERIOR.'</td>';
				echo '<td style="line-height: 6pt; text-align: right;">'.$SI.'</td>';
				echo '<td style="line-height: 6pt; text-align: right;">0</td>';
				echo '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ACTUAL.'</td>';
				$SALDO_ANTERIOR=$SALDO_ACTUAL;
			echo '</tr>';
		}
		if ($arr_movi['PROCESO']==2) {
			$SS=$arr_movi['CANTIDAD_PRODUCTO'];
			$SALDO_ACTUAL=$SALDO_ANTERIOR-$SS;
			echo '<tr style="background: #E5E8E8;">';
				echo '<td style="line-height: 6pt; text-align: left;">'.$arr_movi['PRO'].'</td>';
				echo '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['NRO_FACTURA'].'</td>';
				echo '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['FECHA_FACTURA'].'</td>';
				echo '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ANTERIOR.'</td>';
				echo '<td style="line-height: 6pt; text-align: right;">0</td>';
				echo '<td style="line-height: 6pt; text-align: right;">'.$SS.'</td>';
				echo '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ACTUAL.'</td>';
				$SALDO_ANTERIOR=$SALDO_ACTUAL;
			echo '</tr>';
		}
	}
	?>	
</table>
</div>
</body>
</html>