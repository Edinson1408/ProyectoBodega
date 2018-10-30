<?php 
include('conexion.php');
session_start();
$user=$_POST['user'];
$con=$_POST['cont'];
//SESSIONES
$_SESSION['user']=$_POST['user'];
$con=MD5($con);

$consulta=mysqli_query($conexion,"SELECT * from usuario WHERE NOMUSER='$user' and CONTRASENA= '$con' ");
$f=mysqli_fetch_array($consulta);
$id=$f['IDCATEGORIA'];
echo $nombre=$f['nom_user'];
$TURNO=$f['IDTURNO'];
$_SESSION['IDTURNO']=$TURNO;
$_SESSION['IDCATEGORIA']=$id;
$_SESSION['NOMUSER']=$nombre;

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
