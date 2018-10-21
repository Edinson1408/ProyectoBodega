<?php
include('../../../conexion.php');
session_start();
$COD_PRODUCTO=$_GET['id'];
$FACTURA=$_SESSION['factura'];
$sql_almacen=mysql_query("SELECT * FROM ALMACEN WHERE COD_PRODUCTO='$COD_PRODUCTO'",$conexion);
$ARRAY_ALMACEN=mysql_fetch_array($sql_almacen);

$sql_detalle=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS TOTAL_DETA, PRECIO_UNITARIO FROM DETALLE_FACTURA WHERE NRO_FACTURA='$FACTURA' AND COD_PRODUCTO='$COD_PRODUCTO'",$conexion);
$ARRAY_DETALLE=mysql_fetch_array($sql_detalle);

$sumar=$ARRAY_ALMACEN['CANTIDAD']-$ARRAY_DETALLE['TOTAL_DETA'];
$calculo=$ARRAY_DETALLE['PRECIO_UNITARIO']*$ARRAY_DETALLE['TOTAL_DETA'];


$sql_boleta=mysql_query("SELECT * FROM FACTURA WHERE NRO_FACTURA='$FACTURA'",$conexion);
$ARRAY_BOLETA=mysql_fetch_array($sql_boleta);

$RESTAR=$ARRAY_BOLETA['TOTAL']-$calculo;
$SUB_TOTAL=$RESTAR/1.18;
$IGV=$RESTAR-$SUB_TOTAL;

mysql_query("UPDATE almacen SET CANTIDAD='$sumar' WHERE COD_PRODUCTO='$COD_PRODUCTO'",$conexion);
mysql_query("UPDATE FACTURA SET TOTAL='$RESTAR', SUB_TOTAL='$SUB_TOTAL', IGV='$IGV' WHERE NRO_FACTURA='$FACTURA'",$conexion);

mysql_query("DELETE FROM DETALLE_FACTURA WHERE NRO_FACTURA='$FACTURA' AND COD_PRODUCTO='$COD_PRODUCTO'",$conexion);
mysql_query("DELETE FROM MOVIMIENTO_ALMACEN WHERE NRO_FACTURA='$FACTURA' AND COD_PRODUCTO='$COD_PRODUCTO'",$conexion);
header('location:../ingresar_datos.php');

?>