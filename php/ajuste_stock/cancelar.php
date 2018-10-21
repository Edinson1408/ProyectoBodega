<?php
include ('../../conexion.php');
$boleta=$_GET['id'];
$sql_boleta=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS CANTI,COD_PRODUCTO FROM detalle_ajuste WHERE NRO_FACTURA='$boleta' GROUP BY COD_PRODUCTO ",$conexion);
while ($array_boleta=mysql_fetch_array($sql_boleta)) {
 $PRODUCTO_BOLETA=$array_boleta['COD_PRODUCTO'];
 $CANTIDAD_BOLETA=$array_boleta['CANTI'];
 $sql_almacen=mysql_query("SELECT * FROM  almacen WHERE COD_PRODUCTO='$PRODUCTO_BOLETA'",$conexion);
 $array_almacen=mysql_fetch_array($sql_almacen);
 $CANTIDAD_ALMACEN=$array_almacen['CANTIDAD'];
 $CANTIDAD_REAL=$CANTIDAD_ALMACEN+$CANTIDAD_BOLETA;
mysql_query("UPDATE almacen SET CANTIDAD='$CANTIDAD_REAL' WHERE COD_PRODUCTO='$PRODUCTO_BOLETA'",$conexion);
}
mysql_query("DELETE FROM ajuste WHERE NRO_FACTURA='$boleta'",$conexion);
mysql_query("DELETE FROM detalle_ajuste WHERE NRO_FACTURA='$boleta'",$conexion);
mysql_query("DELETE FROM movimiento_almacen WHERE NRO_FACTURA='$boleta'",$conexion);
header("location:reporte_ajuste.php");
?>