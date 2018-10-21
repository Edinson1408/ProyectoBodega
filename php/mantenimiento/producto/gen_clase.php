<?php
include('../../seguridad1.php');
function gen_id()
{
	include('../../../conexion.php');
$cod1=mysql_query("SELECT max(COD_CLASIFICACION+1) AS ID FROM CLASIFICACION_PRODUCTO",$conexion);
$r2=mysql_fetch_array($cod1);
return $r2['ID'];
}
?>