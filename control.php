<?php 
include('conexion.php');
session_start();
$user=$_POST['user'];
$con=$_POST['cont'];
//SESSIONES
$_SESSION['user']=$_POST['user'];
$consulta=mysqli_query($conexion,"SELECT * from usuario WHERE user='$user' and con_user= '$con' ");
$f=mysqli_fetch_array($consulta);
$id=$f['categoria'];
echo $nombre=$f['nom_user'];
$TURNO=$f['ID_TURNO'];
$_SESSION['TURNO']=$TURNO;
$_SESSION['categoria']=$id;
$_SESSION['nom_user']=$nombre;

switch ($id) {
	case '1':
		$_SESSION['user']=$user;
		
		header("location:php/plataforma.php");
		break;

		case '2':
		$_SESSION['user']=$user;
		
		header("location:php/plataforma.php");
		break;

	default:
		header("location:index.php?v1=1");
		break;
}





 ?>
