<?php
require '../Basedato/conexion.php';
require '../modelo/VentasM.php';
/*** Traer el modelo de procudto ***/
require '../modelo/ProductosM.php';
//correlativos modelo
require '../modelo/CorrelativosM.php';

$ObjReporteV=new VentasM();
$ObjProducto=new Productos();

$ObjCorrelativo= new Correlativos();
switch ($_POST['peticion']) {

  case 'IngresoVenta':
   $MaxId=$ObjReporteV->MaxIdVenta();
   
        require '../vista/Venta/IngresoVenta.php';
        break;  

  case 'Mreporte':
    //armara la tabla
    
    //Reporte
    $Inicio=$_POST['mes'];
    $Final=$_POST['ano'];
    $ListaHistorial=$ObjReporteV->HistorialVentasRango($Inicio,$Final);
    require '../vista/Reportes/RepVentasR.php';
    break;

    case 'ReporteVenta':
      $reporteVista=$ObjReporteV->SqlVista();
      require '../vista/Reportes/RepVentasF.php';
      break;

    case 'HistorialVentas':
    //formulario
      require '../vista/Reportes/RepVentasH.php';
      break;
    case 'MostrarHistorial':
      //Reporte
      $mes=$_POST['mes'];
      $año=$_POST['ano'];
      $ListaHistorial=$ObjReporteV->HistorialVentasR($mes,$año);
      require '../vista/Reportes/RepVentasHR.php';
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
      echo '<ul id="country-list" style="background-color:#eeeeee;text-decoration: none;list-style:none;position: absolute;z-index: 1;width: 30%;">';
      while ($country=mysqli_fetch_array($Consulta)) {
        ?>
        <li style="text-decoration: none;cursor: pointer;list-style:none;" onClick="SelectDni('<?php echo $country["NOMBRE_C"]; ?>','<?php echo $country["RUC_DNI"];?>','<?php echo $country["IDPERSONA"];?>');">
        <?php echo utf8_encode($country["RUC_DNI"]); ?>
        </li>
        <?php
      }
       }

    break;
  
    case 'ValidaStock':
       echo  $ObjProducto->ValidaStockP($_POST["CodProducto"]);
    break;

    case 'VistaNewClient':
          require '../Vista/NuevoCliente.php';
    break;
    
    case 'GuardarVenta':
        //modelo ingreso cabecera 
             
       $UltimoId=$ObjReporteV->InsertaComprobantev($_POST);//regresara su id generado
       //insertando el detalle XD
       echo $UltimoId;
       $ObjReporteV->InsertaDetalle($UltimoId,$_POST); 
       //actualiza Correlativos
       $TipoDoc=$_POST['TipoDoc'];
       $Numero=$_POST['NumCompro'];
       $ObjCorrelativo->ActualizaUltimoC($TipoDoc,$Numero);
    break;

    case 'AnularComprobante':
      $ObjReporteV->AnularVenta($_POST['IdComprobante']);
      break;
    
    case 'CambiaCorrelativo':
      $TipoDoc=$_POST['TipoDoc'];
       $SerieCorre=$ObjCorrelativo->UltimoCorrelativo($TipoDoc);
       echo $SerieCorre;
    break;
    case 'AnularComprobanteBusqueda':
    $IdBusqueda=$_POST['IdBusqueda'];
    $Busqueda=$_POST['Busqueda'];
    $busquedaF=$_POST['busquedaF'];
    $reporteVista2=$ObjReporteV->AnularVentaBusqueda($IdBusqueda,$Busqueda,$busquedaF);

    foreach ($reporteVista2 as $f)
    {
        echo "<tr>";
          echo "<td>".$f['IDCOMPROBANTE']."</td>";
          echo "<td>".$f['ENCARGADO']."</td>";
          echo "<td>".$f['FECHACOMPROBANTE']."</td>";
          echo "<td></td>";
          echo "<td>S/".$f['TOTAL']."</td>";
          ?>
      <td style='line-height: 8pt;'><a onclick="AnularDoc('<?php echo $f['IDCOMPROBANTE'] ?>');" style='cursor: pointer;'>Cancelar</a></td>
      <?php
        echo "</tr>";

    }

    break;
  default:
    echo 'no se encontradron peticiones';
    break;
}

 ?>
