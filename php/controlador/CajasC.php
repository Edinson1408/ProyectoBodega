<!--<li><a href="caja/cierre_caja.php" target="tiframe" class="waves-effect waves-light">Ventas diarias</a></li>-->
<?php
require '../Basedato/conexion.php';
require '../modelo/CajasM.php';

//por el momento la iniciaremos aqui , esto tiene que salirse de aqui 
session_start();
$ObjCaja=new Cajas();
$usuario=$_SESSION['user'];
$ObjCaja->ObtenDatosUser($usuario);

$_SESSION['Turno'];
$categoria=$_SESSION['Categoria'];

switch ($_POST['peticion']) {

	case 'VentasDiarias':
		
		require '../vista/Caja/VentasDiarias.php';
		break;

	case 'CierreDeCaja':
	/*<li><a href="reportes/caja.php" target="tiframe"  class="waves-effect waves-light">Cierre de caja</a></li>*/
		require '../vista/Reportes/RepCaja.php';
		break;
	default:
		# code...
		break;
}

?>