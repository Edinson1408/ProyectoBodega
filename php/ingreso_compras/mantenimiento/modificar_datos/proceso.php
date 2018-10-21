<?php
include('../../../../conexion.php');
$FAC=$_REQUEST['id'];
$ser=$_POST['serie'];
$factura =$_POST['factura']; 
$fecha=$_POST['fecha'];
$cliente=$_POST['cliente'];
$estado=$_POST['estado'];
mysql_query("UPDATE FACTURA SET SERIE_FACTURA='$ser', NRO_FACTURA='$factura', FECHA_FACTURA='$fecha', RUC_CLIENTE='$cliente', ESTADO='$estado' WHERE NRO_FACTURA='$FAC'",$conexion);
mysql_query("UPDATE DETALLE_FACTURA SET NRO_FACTURA='$factura' WHERE NRO_FACTURA='$FAC'",$conexion);
mysql_query("UPDATE MOVIMIENTO_ALMACEN SET NRO_FACTURA='$factura',FECHA_FACTURA='$fecha' WHERE NRO_FACTURA='$FAC'",$conexion);
header('location:../index.php');
?>