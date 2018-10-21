
<?php

require '../../Basedato/conexion.php'; //hago lo del contrador
require '../../modelo/HomeM.php'; //solo necito el modelo por que no usare ajax XD
$ObjRepor=new home();
$CodComprobante=$_GET['id'];
$ComprobantesDatos=$ObjRepor->PreviewComprobante($CodComprobante);
$NroCompro=$ComprobantesDatos->NRO_FACTURA;
$NomClie=utf8_decode($ComprobantesDatos->CLIENTE);
$DniRucCli=$ComprobantesDatos->RUC_CLIENTE;
$FCompro=$ComprobantesDatos->FECHA_FACTURA;
$HCompro=$ComprobantesDatos->HORA_FACTURA;
$SubCompro=$ComprobantesDatos->SUB_TOTAL;
$IgvCompro=$ComprobantesDatos->IGV;
$TotCompro=$ComprobantesDatos->TOTAL;

//detalle del comprobante XD
$DetCom=$ObjRepor->PreviewComprobanteDe($CodComprobante);

require_once('../../pdf/mpdf.php');
$html='<div class="cabecera">';
$html.='<img src="../img/imprimir.jpeg"></img><BR>';
$html.="<p class='ti'>LUIGGI'S MARKET<BR></p>";
$html.="<p class='in'>INVERSIONES VITTERI ORTIZ S.A.C<br>";
$html.="R.U.C.:20601965420</p><br>";
$html.="Cal. 30 B Mza. U2 Lote 01 Urb. Ciudad del Pescador<BR>";
$html.="Bellavista, Callao <BR>";
$html.="R.U.C.:70944692 N/S:88-88888888</p><br>";
$html.='</div>';
$html.='BOLETA DE VENTA<br>';
$html.='N° BOLETA: '.$NroCompro.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SERIE:001<BR>';
//cliente
$html.='Cliente: '.$NomClie.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$html.='Dni: '.$DniRucCli.'<br>';
$html.='Fecha de Emision: '.$FCompro.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$html.='Hora: '.$HCompro.'<br>';
$html.='************************************************';
$html.='<TABLE><tr><td>Can.</td><td>Descripción</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P.U</td>';

foreach ($DetCom as $Detalle ) {
	$html.='<tr><td>'.$Detalle['CANTIDAD'].'</td><td>'.$Detalle['NOMBRE_PRODUCTO'].'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Detalle['PRECIO_VENTA'].'</td></tr>';
}
$html.='</TABLE>************************************************<Br>';
$html.='<div class="cal">';
$html.='<p class="d"> IGV: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$IgvCompro.'<br>';
$html.='Sub Total: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$SubCompro.'</p>';
$html.='<p class="to">TOTAL: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$TotCompro.'</p><br><br>';
$html.='</div>';
$html.='<div class="footer">';
$html.="¡Gracias por su compra en LUIGGI'S MARKET!<br>";
$html.="******************************<br>";
$html.="Vuelva Pronto";
$html.='</div>';
$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

$mpdf = new mPDF('c','B6');
$css=file_get_contents('../../css/PdfImpresion.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Boleta.pdf','I');

?>
