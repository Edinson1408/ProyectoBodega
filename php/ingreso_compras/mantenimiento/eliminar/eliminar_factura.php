<?php
include ('../../../../conexion.php');
$factura=$_GET['id'];
mysql_query("DELETE FROM detalle_factura WHERE NRO_FACTURA='$factura'",$conexion);
mysql_query("DELETE FROM factura WHERE NRO_FACTURA='$factura'",$conexion);
mysql_query("DELETE FROM movimiento_almacen WHERE NRO_FACTURA='$factura'",$conexion);
header("location:../index.php");
?>