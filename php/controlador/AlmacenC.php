
<!--<li class="NavLateralDivider"></li>
                            <li><a href="almacenes/almacen.php" target="tiframe"  class="waves-effect waves-light">STOCK</a></li>-->
<?php 
switch ($_POST['peticion']) {
	case 'STOCK':
		require '../vista/Almacen/AlmacenVista.php'; 		
		break;
	
	default:
		# code...
		break;
}

?>