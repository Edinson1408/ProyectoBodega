<?php
include('../../seguridad1.php');
include('../../../conexion.php');
$id=$_REQUEST['id'];
	mysql_query("DELETE FROM producto where COD_PRODUCTO='$id' ",$conexion);
	mysql_query("DELETE FROM almacen where COD_PRODUCTO='$id' ",$conexion);	
	header('location:index.html');
?>