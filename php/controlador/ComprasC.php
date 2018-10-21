<?php
require '../Basedato/conexion.php';
require '../modelo/ComprasM.php';

$ObjCompras=new Compras;

switch ($_POST['peticion']) {
  case 'value':
    // code...
    break;

    case 'ReporteCompra':

      require '../vista/Reportes/RepComprasF.php';
      break;

    case 'HistorialCompras':
    	require '../vista/Reportes/RepCompraH.php';
    	break;

    case 'Mantenimiento':
    	$lista_fac=$ObjCompras->MantenientoLista();
    	require '../vista/compras/Mantenimiento.php';
    	break;

  default:
    // code...
    break;
}
 ?>
