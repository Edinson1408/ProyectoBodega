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
      $NroCompro=$ComprobantesDatos->NRO_FACTURA;
      $NomClie=utf8_decode($ComprobantesDatos->CLIENTE);
      $DniRucCli=$ComprobantesDatos->RUC_CLIENTE;
      $FCompro=$ComprobantesDatos->FECHA_FACTURA;
      $HCompro=$ComprobantesDatos->HORA_FACTURA;
      $SubCompro=$ComprobantesDatos->SUB_TOTAL;
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
