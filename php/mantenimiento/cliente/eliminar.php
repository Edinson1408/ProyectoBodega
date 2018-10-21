<?php
include('../../../conexion.php');
$id=$_REQUEST['id'];
	mysql_query("DELETE FROM cliente_1 where RUC_DNI='$id' ",$conexion);	
	header('location:cliente.php');
?>