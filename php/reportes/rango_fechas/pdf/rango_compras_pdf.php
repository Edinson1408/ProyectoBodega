<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
require_once('../../../pdf/mpdf.php');
include('../../../../conexion.php');
session_start();
$inicio=$_SESSION['i'];
$final=$_SESSION['f'];
$html.="<div class='contenedor'>
		<div class='info'>
        <img src='../../img/logo.jpeg'><b>LUGGI'S MARKET</b></img>";
$html.='</div>';
$html.='<div class="titulo">';
$html.='<h3>Reporte General de Compras</h3>';
if (isset($inicio,$final)) {	
$html.='<p>Desde: '.$inicio.'  -  Hasta: '.$final.'</p>';
}else{
$html.='<p>Todas las Compras</p>';	
}
$html.='<p>EMITIDO: '.date("d-m-Y").'</p>';
$html.='</div>';
$html.='<hr></>';
$html.='</div>';
$sql_rango=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND (FECHA_FACTURA BETWEEN '$inicio' AND '$final') AND PROCESO='1'",$conexion);
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Factura N°</th>';
$html.='<th>Fecha</th>';
$html.='<th>Cliente</th>';
$html.='<th>Sub Total</th>';
$html.='<th>Igv</th>';
$html.='<th>Total</th>';
$html.='</thead>';
if (isset($inicio,$final)) {
while ($ARR_FAC=mysql_fetch_array($sql_rango)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'.$ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr></tbody>';
}
}
if (!isset($inicio,$final)){
$sql_rango=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND PROCESO='1'",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_rango)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'.$ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr></tbody>';
}
}
$html.='</tr>';
$html.='</table>';
$html.='<hr></>';
if (isset($inicio,$final)){
$sql_rango=mysql_query("SELECT SUM(TOTAL) AS SUMA, COUNT(NRO_FACTURA) AS FILA FROM FACTURA WHERE (FECHA_FACTURA BETWEEN '$inicio' AND '$final') AND PROCESO='1'",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_rango)) {
$html.='<table><tbody><tr><td>Compras - Desde: '.$inicio.' a '.$final.'</td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">COMPRAS = '.$ARR_FAC['FILA'].'</td></tr><tbody><tr><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">TOTAL = '.$ARR_FAC['SUMA'].'</td></tr></tbody></table>';
}
}
if (!isset($inicio,$final)){
$sql_rango=mysql_query("SELECT SUM(TOTAL) AS SUMA, COUNT(NRO_FACTURA) AS FILA  FROM FACTURA WHERE PROCESO='1'",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_rango)) {
$html.='<table><tbody><tr><td>Total de Compras</td><td width="50"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">COMPRAS = '.$ARR_FAC['FILA'].'</td></tr><tbody><tr><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">TOTAL = '.$ARR_FAC['SUMA'].'</td></tr></tbody></table>';
}
}
$mpdf = new mPDF('c','A4');
$css=file_get_contents('estilo.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('rango_fechas_compras.pdf','I');
?>
</body>
</html>