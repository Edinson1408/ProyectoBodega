<!DOCTYPE html>

<html>
<head>
	<title></title>
</head>
<body >
<?php
session_start();
require_once('pdf/mpdf.php');
include('../../conexion.php');
$html.='<div class="cabecera">';
$html.='<img src="img/imprimir.jpeg"></img><BR>';
$html.="<p class='ti'>LUIGGI'S MARKET<BR></p>";
$html.="<p class='in'>INVERSIONES VITTERI ORTIZ S.A.C<br>";
$html.="<p>R.U.C.:20601965420<br>";
$html.="Cal. 30 B Mza. U2 Lote 01 Urb. Ciudad del Pescador<BR>";
$html.="Bellavista, Callao </p><BR>";
$html.='</div>';
$html.='BOLETA DE VENTA<br>';
$BOLETA=$_SESSION['numero_fac'];
$html.='N° BOLETA: '.$BOLETA.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SERIE:001<BR>';
//cliente
$html.='Cliente: '.$_SESSION['N_CLIENTE'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$html.='Dni: '.$_SESSION['cliente'].'<br>';
$html.='Fecha de Emision: '.$_SESSION['fecha'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$SQL_HORA=mysql_query("SELECT * FROM BOLETA WHERE NRO_FACTURA='$BOLETA'",$conexion);
$r=mysql_fetch_array($SQL_HORA);
$html.='Hora: '.$r['HORA_FACTURA'].'<br>';
$html.='************************************************';
$html.='<TABLE><tr><td>Can.</td><td>Descripción</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P.U</td>';
$SQL_DETALLE=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS CANTIDAD, SUM(IMPORTE) AS IMPO, COD_PRODUCTO FROM DETALLE_BOLETA WHERE NRO_FACTURA='$BOLETA' GROUP BY COD_PRODUCTO ",$conexion);
while ($ARR_DETA=mysql_fetch_array($SQL_DETALLE)) 
{	$PORDUC=$ARR_DETA['COD_PRODUCTO'];
	$SQL_PRODUCTO=mysql_query("SELECT NOMBRE_PRODUCTO, PRECIO_VENTA FROM PRODUCTO WHERE COD_PRODUCTO='$PORDUC' ",$conexion);
	$ARR_PRO=mysql_fetch_array($SQL_PRODUCTO);
	$html.='<tr><td>'.$ARR_DETA['CANTIDAD'].'</td><td>'.$ARR_PRO['NOMBRE_PRODUCTO'].'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ARR_PRO['PRECIO_VENTA'].'</td></tr>';	
}

$SQL_FAC=mysql_query("SELECT * FROM BOLETA WHERE NRO_FACTURA='$BOLETA'",$conexion);
$ARR_FACTURA=mysql_fetch_array($SQL_FAC);
//$ARR_FACTURA['IMPORTE'];
//$ARR_FACTURA['IGV'];
//$ARR_FACTURA['TOTAL'];
$html.='</TABLE>************************************************<Br>';
$html.='<div class="cal">';
$html.='<p class="d"> IGV: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ARR_FACTURA['IGV'].'<br>';
$html.='Sub Total: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ARR_FACTURA['SUB_TOTAL'].'</p>';
$html.='<p class="to">TOTAL: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ARR_FACTURA['TOTAL'].'</p><br><br>';
$html.='</div>';
$html.='<div class="footer">';
$html.="¡Gracias por su compra en LUIGGI'S MARKET!<br>";
$html.="******************************<br>";
$html.="Vuelva Pronto";
$html.='</div>';

$mpdf = new mPDF('c','B6');
$css=file_get_contents('css/estilos.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Boleta.pdf','I');
?>
</body>
</html>