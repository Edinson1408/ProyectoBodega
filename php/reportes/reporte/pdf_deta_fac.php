<?php
include('../../conexion.php');
require_once('../pdf/mpdf.php');
session_start();
$ID_TURNO=$_SESSION['TURNO'];
$FECHA_HOY=$_SESSION['HOY'];
$SQL_FACTURA=mysql_query("SELECT * FROM FACTURA WHERE FECHA_FACTURA='$FECHA_HOY' AND ID_TURNO='TUR1'",$conexion);

$html.='<table class="table table-bordered">';
$html.='<tr>';
$html.='<td>Boleta</td>';
$html.='<td>Fecha</td>';
$html.='<td>Cliente</td>';
$html.='<td>sub Total</td>';
$html.='<td>Igv</td>';
$html.='<td>Total</td>';
$html.='</tr>';
while ($ARR_FAC=mysql_fetch_array($SQL_FACTURA)) {
$html.='<tr><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['RUC_CLIENTE'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'. $ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr>';
$n_fac=$ARR_FAC['NRO_FACTURA'];
$html.='<tr>';
$html.='<td>Detalle boleta'.$n_fac.'</td>';
$html.='</tr>';
//
$html.='<tr>';
$html.='<td>Boleta</td>';
$html.='<td>Producto</td>';
$html.='<td>Cantidad</td>';
$html.='<td>Precio Unitario</td>';
$html.='<td>Importe</td>';
$html.='</tr>';
//
// el detalle
$SQL_DETALLE=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO FROM DETALLE_FACTURA A , PRODUCTO B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND A.NRO_FACTURA='$n_fac'",$conexion);
while ($ARR_DETALLE=mysql_fetch_array($SQL_DETALLE)) 
			{
				$html.='<tr><td>'.$ARR_DETALLE['NRO_FACTURA'].'</td><td>'.$ARR_DETALLE['NOMBRE_PRODUCTO'].'</td><td>'.$ARR_DETALLE['CANTIDAD_PRODUCTO'].'</td><td>'.$ARR_DETALLE['PRECIO_UNITARIO'].'</td><td>'. $ARR_DETALLE['IMPORTE'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr>';

			}

}
$html.='</tr>';
$html.='</table>';
$mpdf = new mPDF('c','A4');
$css=file_get_contents('css/style.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Sierre_general.pdf','I');
?>