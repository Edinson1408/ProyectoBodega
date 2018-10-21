<!DOCTYPE html>

<html>
<head>
  <title>Ventas</title>
</head>
<body>
<?php

require_once('../pdf/mpdf.php');
include('../../conexion.php');
session_start();
$mes=$_SESSION['mes'];
$año=$_SESSION['ano'];
$meses = array(1 =>'Enero', 2 =>'Febrero',3 =>'Marzo' ,4 =>'Abril',5 =>'Mayo',6 =>'Junio',7 =>'Julio',8 =>'Agosto',9 =>'Septiembre',10 =>'octubre',11 =>'Noviembre',12 =>'Diciembre' );
$html.="<div class='contenedor'>
		<div class='info'>
        <img src='img/logo.jpeg'><b>LUGGI'S MARKET</b></img>";
$html.='</div>';

$html.='<div class="titulo">';
$html.='<h3>Detalle de Ventas Mensuales</h3>';
$html.='<h4>Mes: '.$meses[$mes].'  -  Año: '.$año.'</h4>';
$html.='<p>EMITIDO: '.date("d-m-Y").'</p>';
$html.='</div>';
$html.='<hr></>';
$html.='</div>';
$SQL_FAC=mysql_query("SELECT a.*,b.NOMBRE_CLIENTE,c.NOMBRE_ESTADO AS ES FROM  factura as a, cliente as b, estado as c WHERE a.RUC_CLIENTE=b.RUC_CLIENTE AND a.ESTADO=c.ID_ESTADO AND MONTH(a.FECHA_FACTURA)='$mes' and  YEAR(a.FECHA_FACTURA)='$año' ",$conexion);
$html.='<div class="table">';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Factura</th>';
$html.='<th>Serie</th>';
$html.='<th>Fecha</th>';
$html.='<th>Proveedor</th>';
$html.='<th>Estado</th>';
$html.='<th>Sub Total</th>';
$html.='<th>Igv</th>';
$html.='<th>Total</th>';
$html.='</thead>';
while ($ARR_FAC=mysql_fetch_array($SQL_FAC)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['SERIE_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE_CLIENTE'].'</td><td>'.$ARR_FAC['ES'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'.$ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr></tbody>';
}
$html.='</tr>';
$html.='</table>';
$mpdf = new mPDF('c','A4');
$css=file_get_contents('css/estilo.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('compras.pdf','I');


?>
</body>
</html>