<?php 
include('conexion.php');
session_start();
$user=$_POST['user'];
$con=$_POST['cont'];
//SESSIONES
$_SESSION['user']=$_POST['user'];
$cone=MD5($_POST['cont']);
echo "SELECT * from usuario WHERE NOMUSER='$user' and CONUSUARIO= '$cone' ";
$consulta=mysqli_query($conexion,"SELECT * from usuario WHERE NOMUSER='$user' and CONUSUARIO= '$cone' ");
$f=mysqli_fetch_array($consulta);
echo $id=$f['IDCATEGORIA'];
echo $nombre=$f['NOMUSER'];
///sessiones
$_SESSION['IdUsuario']=$f['IDUSUARIO'];
$TURNO=$f['IDTURNO'];
$_SESSION['IDTURNO']=$TURNO;
$_SESSION['categoria']=$id;
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
	header("location:php/plataforma.php");
		//header("location:index.php?v1=1");
		break;
}





 ?>
