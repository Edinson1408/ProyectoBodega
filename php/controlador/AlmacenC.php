
<!--<li class="NavLateralDivider"></li>
                            <li><a href="almacenes/almacen.php" target="tiframe"  class="waves-effect waves-light">STOCK</a></li>-->
<?php 
require '../Basedato/conexion.php';
require '../modelo/AlmacenM.php';
$ObjAlmacen=new Almacenes();
switch ($_POST['peticion']) {
	case 'STOCK':
	$DatosStock=$ObjAlmacen->DatosAlmace(1);
		require '../vista/Almacen/AlmacenVista.php';
		break;
	case 'DetalleAlmacen':
		$NomClasificacion=$_POST['NomClasificacion'];
		$CodClasificacion=$_POST['CodClasificacion'];
		$DatosDetalle=$ObjAlmacen->DetalleAlmacenP($CodClasificacion);
		require '../vista/Almacen/DetalleAlmacenP.php';
		break;
	case 'ProductoAlmacen':
		require '../vista/Almacen/ProductoAlmacen.php';
		break;
	case 'VerMovimientos':
	$CodProducto=$_POST['CodProducto'];
		$res=$ObjAlmacen->MovimientosP($CodProducto);
		require '../vista/Almacen/MovimientoProducto.php';
	
		break;
	default:
		# code...
		break;
}

?>