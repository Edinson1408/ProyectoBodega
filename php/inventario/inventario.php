<!DOCTYPE html>
<html>
<head>
	<title></title>
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
		.btn{
			border-radius: 0;
			float: right;
		}

	</style>
</head>
<body>
<?php
include('../../conexion.php');
//$VAR_FE1=$_POS['fe1'];
//$VAR_FE2=$_POS['fe2'];
session_start();
$VAR_FE1=$_POST['fec_ini'];
$VAR_FE2=$_POST['fec_fin'];
$VAR_CLA=$_POST['clase'];

$_SESSION['ini']=$VAR_FE1;
$_SESSION['fin']=$VAR_FE2;
$_SESSION['cla']=$VAR_CLA;
$SQL_NOMBRE=mysql_query("SELECT * FROM clasificacion_producto WHERE COD_CLASIFICACION='$VAR_CLA'",$conexion);
$r=mysql_fetch_array($SQL_NOMBRE);
?>
<div class="container">
	<div class="nota">
		<i class="fa fa-pencil-square-o" id="com" >Inventario - <?php echo $r['CLASE_PRODUCTO'];?></i>
		<i class="fa fa-reply" aria-hidden="true" style="float: right; color: black;"><a href="seleccionar_fecha.php">Regresar</a></i>
	</div>
	<a href="inventario_pdf.php" target="T_Blank" class="btn btn-danger btn-sm">PDF</a>
	<a href="inventario_excel.php" class="btn btn-success btn-sm">Excel</a>
<?php
echo "<i class='fa fa-calendar' aria-hidden='true' id='ca'> Fechas:<strong> Desde : ".$VAR_FE1." Hasta : ".$VAR_FE2."</strong></i><BR>";
echo "<hr>";
//enviaremos producto porproducto XD
$SQL_PRODUCTO=mysql_query("SELECT * FROM producto WHERE CLASE_PRODUCTO='$VAR_CLA'  ORDER BY NOMBRE_PRODUCTO ",$conexion);

	echo "<table class='table table-bordered'>";
	echo "<tr>";
	echo "<th style='line-height:6pt;'>Producto</td>";
	echo "<th style='line-height:6pt;'>Saldo Anterior</td>";
	echo "<th style='line-height:6pt;'>Ingreso</td>";
	echo "<th style='line-height:6pt;'>Salida</td>";
	echo "<th style='line-height:6pt;'>Stock_Actual</td>";
	echo "</tr>";

while ($ARR_PRODU=mysql_fetch_array($SQL_PRODUCTO)) 
{

	 $VAR_PRODUCTO=$ARR_PRODU['COD_PRODUCTO'];
	 $NOMBRE_PRODUCTO=$ARR_PRODU['NOMBRE_PRODUCTO'];
	
	$SQL_ALACEN1=mysql_query("SELECT COD_PRODUCTO,SUM(CANTIDAD) AS CANTIDAD,'1' FROM CANTIDAD_INGRESO
	WHERE FECHA_FACTURA<=date_add('$VAR_FE1', INTERVAL -1 DAY) and cod_producto='$VAR_PRODUCTO'GROUP BY COD_PRODUCTO",$conexion);

	$SQL_ALACEN2=mysql_query("SELECT COD_PRODUCTO,SUM(CANTIDAD) AS CANTIDAD,'2' FROM CANTIDAD_SALIDA
	WHERE FECHA_FACTURA<=date_add('$VAR_FE1', INTERVAL -1 DAY)  and cod_producto='$VAR_PRODUCTO' GROUP BY COD_PRODUCTO",$conexion);

	$ARR1=mysql_fetch_array($SQL_ALACEN1);
	$ARR2=mysql_fetch_array($SQL_ALACEN2);
	$SALDO_A=$ARR1['CANTIDAD']-$ARR2['CANTIDAD'];
	/*echo "Producto: ".$VAR_PRODUCTO."<br>";
	echo "Saldo".$SALDO_A."<br>";*/

	$SQL_MOVIMIENTO=mysql_query("SELECT * FROM  movimiento_almacen
	where (fecha_factura BETWEEN '$VAR_FE1' and '$VAR_FE2')
	and COD_PRODUCTO='$VAR_PRODUCTO'",$conexion);
	$ENTRADA=0;
	$SALIDA=0;
	while ($ARRA_MOVI=mysql_fetch_array($SQL_MOVIMIENTO)) 
		{
			if ($ARRA_MOVI['PROCESO']==1) 
			{
				$EE=$ARRA_MOVI['CANTIDAD_PRODUCTO'];
				$ENTRADA=$ENTRADA+$EE;
			}
			if ($ARRA_MOVI['PROCESO']==2)
			{
				$SA=$ARRA_MOVI['CANTIDAD_PRODUCTO'];
				$SALIDA=$SALIDA+$SA;
			}
		}	

			$SA=$SALDO_A+$ENTRADA;
			$SA2=$SA-$SALIDA;

		echo "<tr>";
		echo "<td id='nombre' style='line-height:6pt; text-aling:left;'><a href='movimiento_almacen.php?cod=".$VAR_PRODUCTO."&fe1=".$VAR_FE1."&fe2=".$VAR_FE2."'>".$NOMBRE_PRODUCTO."</td>";
		echo "<td style='line-height:6pt;'>".$SALDO_A."</td>";
		echo "<td style='line-height:6pt;'>".$ENTRADA."</td>";
		echo "<td style='line-height:6pt;'>".$SALIDA."</td>";
		echo "<td style='line-height:6pt;'>".$SA2."</td>";
		echo "</tr>";




}
	echo "</table>";

?>
</div>
</body>
</html>