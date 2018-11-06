<?php
require '../Basedato/conexion.php';
require '../modelo/HomeM.php';

$ObjHome = new Home();

switch ($_POST['peticion']) {
  case 'lista':
    $ArrTotales=$ObjHome->Cajas();
    $ultimasV=$ObjHome->UltimasVentas();
    $dia=date('Y-m-d');
    $ProMasVen=$ObjHome->ProductoMasVendidos($dia);

    require '../vista/home/HomeIndex.php';
    break;

    case 'PreviewComprobante':
      $CodComprobante=$_POST['codigo'];
      //datos principales del comprobante
      $ComprobantesDatos=$ObjHome->PreviewComprobante($CodComprobante);
      $NroCompro=$ComprobantesDatos->NUMCOMPROBANTE;
      $NomClie=utf8_decode($ComprobantesDatos->NOMCLIENTE);
      $DniRucCli=$ComprobantesDatos->NUMDOC;
      $FCompro=$ComprobantesDatos->FECHACOMPROBANTE;
      $HCompro='';
      $SubCompro=$ComprobantesDatos->SUBTOTAL;
      $IgvCompro=$ComprobantesDatos->IGV;
      $TotCompro=$ComprobantesDatos->TOTAL;

      //detalle del comprobante XD
        $DetCom=$ObjHome->PreviewComprobanteDe($CodComprobante);
      require '../vista/home/PreviewComprobante.php';
    break;
  default:
    // code...
    break;
}
?>
