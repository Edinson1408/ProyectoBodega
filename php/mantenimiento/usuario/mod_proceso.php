<?php
include('../../../conexion.php');
$id=$_REQUEST['id'];
$user=$_POST['user'];
$contra=$_POST['contra'];
$categoria=$_POST['cargo'];
$nombre=$_POST['nom'];
$apellido=$_POST['ape'];
$correo=$_POST['email'];
$telefono=$_POST['tel'];
$direccion=$_POST['dir'];
$turno=$_POST['turno'];
if (isset($_POST['modificar'])) {
mysql_query("UPDATE usuario SET user='$user', con_user='$contra', categoria='$categoria', nom_user='$nombre', ape_user='$apellido', correo='$correo', telefono='$telefono', direccion='$direccion', ID_TURNO='$turno' where con_user='$id'",$conexion);
header('location:usuario.php');
}
?>