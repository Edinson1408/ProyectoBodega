<?php
require '../Basedato/conexion.php';
//require '../modelo/VentasM.php';



switch ($_POST['peticion']) {
  case 'value':
    // code...
    break;

    case 'ReporteStock':

      require '../vista/Reportes/RepStockF.php';
      break;

  default:
    // code...
    break;
}

 ?>
