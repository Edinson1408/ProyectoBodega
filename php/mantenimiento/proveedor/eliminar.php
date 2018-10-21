<?php
include('../../../conexion.php');
$id=$_REQUEST['id'];
	mysql_query("DELETE FROM cliente where RUC_CLIENTE='$id' ",$conexion);	
	header('location:proveedor.php');
?>