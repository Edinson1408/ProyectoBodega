<?php
session_start();
//enviar el id de usuario
$id=$_SESSION['categoria'];

function seguridad($e)
{
if ($e!=1) {
	header("location:../404/error.php");
}

}


echo seguridad($id);








?>