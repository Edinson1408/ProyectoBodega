<?php
include('../../seguridad1.php');
include('../../../conexion.php');
error_reporting(0);
$user=$_POST['user'];
$contra=$_POST['contra'];
$categoria=$_POST['cargo'];
$nombre=$_POST['nom'];
$apellido=$_POST['ape'];
$correo=$_POST['email'];
$telefono=$_POST['tel'];
$direccion=$_POST['dir'];
$turno=$_POST['turno'];
if (isset($_POST['registrar'])) {
	mysql_query("INSERT INTO usuario VALUES('$user','$contra','$nombre','$apellido','$correo','$telefono','$direccion','$categoria','$turno')",$conexion);
	header('location:usuario.php');
}
?>