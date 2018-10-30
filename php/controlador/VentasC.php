<?php
require '../Basedato/conexion.php';
require '../modelo/VentasM.php';
/*** Traer el modelo de procudto ***/
require '../modelo/ProductosM.php';

$ObjReporteV=new VentasM();
$ObjProducto=new Productos();
switch ($_POST['peticion']) {

  case 'IngresoVenta':
   $MaxId=$ObjReporteV->MaxIdVenta();
   
        require '../vista/Venta/IngresoVenta.php';
        break;  

  case 'Mreporte':
    //armara la tabla
    $Inicio=$_POST['Inicio'];
    $Final=$_POST['Final'];


    $ReRango=$ObjReporteV->RangoF($Inicio,$Final);
    
    echo "
    <table class='table table-striped' >
    <tr>
    		    <th>Boleta N°</th>
        		<th>Turno</th>
        		<th>Encargado</th>
        		<th>Fecha</th>
        		<th>Cliente</th>
        		<th>Sub_Total</th>
        		<th>Igv</th>
        		<th>Total</th>
    	</tr>";

      foreach ($ReRango as $f) {
    		echo "<tr>";
    			echo "<td>".$f['NRO_FACTURA']."</td>";
    			echo "<td>".$f['TURNO']."</td>";
    			echo "<td>".$f['ENCARGADO']."</td>";
    			echo "<td>".$f['FECHA_FACTURA']."</td>";
    			echo "<td>".$f['NOMBRE']."</td>";
    			echo "<td>".$f['SUB_TOTAL']."</td>";
    			echo "<td>".$f['IGV']."</td>";
    			echo "<td>".$f['TOTAL']."</td>";
    		echo "</tr>";
    	}
      echo '</table>';
    break;

    case 'ReporteVenta':
      $reporteVista=$ObjReporteV->SqlVista();
      require '../vista/Reportes/RepVentasF.php';
      break;

    case 'HistorialVentas':
      require '../vista/Reportes/RepVentasH.php';
     
      break;

    case 'AnularVenta':
        $reporteVista=$ObjReporteV->SqlVista();
        require '../vista/AnularDocumento/AnularVenta.php';    
        break;  
   
    case 'AutoCompletado':
    $busqueda=$_POST['keyword'];
    if(!empty($_POST["keyword"])) {
      $Consulta=$ObjProducto->AutoCompletadoProducto($busqueda);
      echo '<ul id="country-list" style="background-color:#eeeeee;text-decoration: none;list-style:none" >';
while ($country=mysqli_fetch_array($Consulta)) {  /**    background-color: #e67f7fd9; */ 
  $cantidadXd=intval($country['CANTIDAD']);
  $color=($cantidadXd>0)? '':'background-color: #e67f7fd9';
?>
       <li style="text-decoration: none;cursor: pointer;list-style:none; <?php echo  $color?>" onClick="selectCountry('<?php echo $country["NOMPRODUCTO"]; ?>','<?php echo $country["CODPRODUCTO"]; ?>');"><?php echo utf8_encode($country["NOMPRODUCTO"]); ?></li>
        <?php
        }
    }
    break;

    case 'AddGrilla':
        $ObjProducto->AddGrilla($_POST['CodProducto']);
    break;

    case 'RucCLiente':
    if(!empty($_POST["RucDni"])) {
      $Consulta=$ObjReporteV->AutoCompleteClientes($_POST["RucDni"]);
      echo '<ul id="country-list" style="background-color:#eeeeee;text-decoration: none;list-style:none" >';
      while ($country=mysqli_fetch_array($Consulta)) {
        ?>
        <li style="text-decoration: none;cursor: pointer;list-style:none;" onClick="SelectDni('<?php echo $country["NOMBRE_C"]; ?>','<?php echo $country["RUC_DNI"]; ?>');">
        <?php echo utf8_encode($country["RUC_DNI"]); ?>
        </li>
        <?php
      }
       }

    break;
  
    case 'VistaNewClient':
          require '../Vista/NuevoCliente.php';
    break;

  default:
    echo 'no se encontradron peticiones';
    break;
}

 ?>
