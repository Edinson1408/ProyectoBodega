<?php
include('../../seguridad1.php');
include('../../../conexion.php');
$id=$_REQUEST['id'];
	mysql_query("DELETE FROM usuario where con_user='$id' ",$conexion);
	header('location:usuario.php');
?>