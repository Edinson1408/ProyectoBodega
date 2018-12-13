<?php
require '../Basedato/conexion.php';
require '../modelo/RStockM.php';



switch ($_POST['peticion']) {
    case 'ReporteStock':

      require '../vista/Reportes/RepStockF.php';
      break;

  default:
    // code...
    break;
}

 ?>
