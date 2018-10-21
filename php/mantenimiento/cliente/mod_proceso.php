<?php
include('../../../conexion.php');
$id=$_REQUEST['id'];
$a=$_POST['ruc-dni'];
$b=$_POST['prove'];
$c=$_POST['dire'];
$d=$_POST['tel'];
$e=$_POST['corr'];
mysql_query("UPDATE cliente_1 SET RUC_DNI='$a', NOMBRE_C='$b', DIR_CLI='$c', TEL_CLIE='$d', CORRE_CLI='$e' where RUC_DNI='$id'",$conexion);
header('location:cliente.php');
?>