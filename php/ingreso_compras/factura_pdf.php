<!DOCTYPE html>
<html>
<head>
	<title>Compras</title>	
</head>
<body>
<?php
require_once('../pdf/mpdf.php');
include('../../conexion.php');
$factura=$_GET['id'];
/*===================================================================================*/
$sql_factura=mysql_query("SELECT * FROM factura WHERE NRO_FACTURA='$factura'",$conexion);
$array_factura=mysql_fetch_array($sql_factura);
$serie=$array_factura['SERIE_FACTURA'];
$fecha=$array_factura['FECHA_FACTURA'];
$cliente=$array_factura['RUC_CLIENTE'];
$subtotal=$array_factura['SUB_TOTAL'];
$igv=$array_factura['IGV'];
$total=$array_factura['TOTAL'];
/*===================================================================================*/


/*===================================================================================*/
$sql_cliente=mysql_query("SELECT * FROM cliente WHERE RUC_CLIENTE='$cliente'",$conexion);
$array_cliente=mysql_fetch_array($sql_cliente);
$nombre=$array_cliente['NOMBRE_CLIENTE'];
/*===================================================================================*/


/*===================================================================================*/
$html.='<div class="cabecera">';
$html.='<div class="imagen">';
$html.='<img src="img/logo_pdf.png"></img>';
$html.='</div>';
$html.='<div class="titulo">';
$html.='<hr>';
$html.='</div>';
$html.='<div class="emision">';
$html.='<table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">';
$html.='<tr>';
$html.='<td style="width: 50%;" class="midnight-blue">FACTURA</td>';
$DIA=date('Y-m-d');
$html.='<td style="width: 50%; text-align:right">Fecha de emision:'.$DIA.'</td>';
$html.='</tr>';
$html.='<tr>';
$html.='<td style="width: 50%; ">Factura : '.$factura.'<br>
		Serie : '.$serie.'<br>
		Fecha : '.$fecha.'<br>
		RUC   : '.$cliente.'<br>
		Proveedor : '.$nombre.'</td>';
$html.='</tr>';
$html.='</table>';
$html.='</div>';
$html.='<br>';

$html.='<table cellspacing="0" style="width: 100%; text-align: left; font-size: 10pt;">';
$html.='<tr>';
$html.='<th style="width: 10%;text-align:center" class="midnight-blue">CANT.</th>
        <th style="width: 60%" class="midnight-blue">DESCRIPCION</th>
        <th style="width: 15%;text-align: right" class="midnight-blue">PRECIO UNIT.</th>
        <th style="width: 15%;text-align: right" class="midnight-blue">PRECIO TOTAL</th>';
$html.='</tr>';
/*===================================================================================*/


/*===================================================================================*/
$sql_detalle_factura=mysql_query("SELECT a.*,b.NOMBRE_PRODUCTO AS PRODU FROM detalle_factura AS a, producto AS b WHERE a.COD_PRODUCTO=b.COD_PRODUCTO AND NRO_FACTURA='$factura'",$conexion);
while($array_detalle=mysql_fetch_array($sql_detalle_factura)){	
$html.='<tr>';
$html.='<td style="width: 10%; text-align: center">'.$array_detalle['CANTIDAD_PRODUCTO'].'</td>
        <td style="width: 60%; text-align: left">'.$array_detalle['PRODU'].'</td>
        <td style="width: 15%; text-align: right">'.$array_detalle['PRECIO_UNITARIO'].'</td>
        <td style="width: 15%; text-align: right">'.$array_detalle['IMPORTE'].'</td>';
$html.='</tr>';
}
/*===================================================================================*/


$html.='<tr>';
$html.='<td colspan="3" style="width: 85%; text-align: right">SUBTOTAL</td>';
$html.='<td style="width: 15%; text-align: right">'.$subtotal.'</td>';
$html.='</tr>';
$html.='<tr>';
$html.='<td colspan="3" style="width: 85%; text-align: right">IGV</td>';
$html.='<td style="width: 15%; text-align: right">'.$igv.'</td>';
$html.='</tr>';
$html.='<tr>';
$html.='<td colspan="3" style="width: 85%; text-align: right">TOTAL</td>';
$html.='<td style="width: 15%; text-align: right">'.$subtotal.'</td>';
$html.='</tr>';
$html.='</table>';
$mpdf = new mPDF('c','A4');
$css=file_get_contents('css/factura.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Factura.pdf','I');
?>
</body>
</html>