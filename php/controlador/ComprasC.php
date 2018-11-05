<?php
require '../Basedato/conexion.php';
require '../modelo/ComprasM.php';

/*** Traer el modelo de procudto ***/
require '../modelo/ProductosM.php';

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
    case 'IngresoCompras':
      $MaxId=$ObjCompras->MaxIdCompra();
      require '../vista/Compras/IngresoCompra.php';
      break;

      case 'RucProveedor':
      if(!empty($_POST["RucDni"])) {
        $Consulta=$ObjCompras->AutoCompleteProveedores($_POST["RucDni"]);
        echo '<ul id="country-list" style="background-color:#eeeeee;text-decoration: none;list-style:none" >';
        while ($country=mysqli_fetch_array($Consulta)) {
          ?>
          <li style="text-decoration: none;cursor: pointer;list-style:none;" onClick="SelectDni('<?php echo $country["NOMBRE_C"]; ?>','<?php echo $country["RUC_DNI"];?>','<?php echo $country["IDPERSONA"];?>');">
          <?php echo utf8_encode($country["RUC_DNI"]); ?>
          </li>
          <?php
        }
         }
  
      break;

  default:
    // code...
    break;
}
 ?>
