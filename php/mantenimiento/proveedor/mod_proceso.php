<?php
include('../../../conexion.php');
$id=$_REQUEST['id'];
$a=$_POST['ruc-dni'];
$b=$_POST['prove'];
$f=$_POST['eje_num'];
$g=$_POST['eje_nom'];
$c=$_POST['dire'];
$d=$_POST['tel'];
$e=$_POST['corr'];
mysql_query("UPDATE cliente SET RUC_CLIENTE='$a', NOMBRE_CLIENTE='$b', NUM_EJE='$f', NOM_EJE='$g', DIRECCION_CLIENTE='$c', TELEFONO_CLIENTE='$d', CORREO_CLIENTE='$e' where RUC_CLIENTE='$id'",$conexion);
header('location:proveedor.php');
?>