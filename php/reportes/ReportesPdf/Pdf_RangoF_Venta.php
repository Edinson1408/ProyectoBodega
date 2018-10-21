<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
require_once('../../pdf/mpdf.php');
include('../../../conexion.php');
session_start();
$inicio=$_GET['Inicio'];
$final=$_GET['Final'];
$html.="<div class='contenedor'>
		<div class='info'>
        <img src='../img/logo.jpeg'><b>LUGGI'S MARKET</b></img>";
$html.='</div>';
$html.='<div class="titulo">';
$html.='<h3>Reporte General de Ventas</h3>';
if (isset($inicio,$final)) {
$html.='<p>Desde: '.$inicio.'  -  Hasta: '.$final.'</p>';
}else{
$html.='<p>Todas las Ventas</p>';
}
$html.='<p>EMITIDO: '.date("d-m-Y").'</p>';
$html.='</div>';
$html.='<hr></>';
$html.='</div>';
$sql_rango=mysqli_query($conexion,"SELECT A.*, B.NOMBRE_C AS NOMBRE FROM BOLETA AS A,
  CLIENTE_1 AS B WHERE A.RUC_CLIENTE=B.RUC_DNI AND (FECHA_FACTURA BETWEEN '$inicio' AND '$final')");
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Boleta N°</th>';
$html.='<th>Fecha</th>';
$html.='<th>Cliente</th>';
$html.='<th>Sub Total</th>';
$html.='<th>Igv</th>';
$html.='<th>Total</th>';
$html.='</thead>';
if (isset($inicio,$final)) {
while ($ARR_FAC=mysqli_fetch_array($sql_rango)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'.$ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr></tbody>';
}
}
if (!isset($inicio,$final)){
$sql_rango=mysqli_query($conexion,"SELECT A.*, B.NOMBRE_C AS NOMBRE FROM BOLETA AS A, CLIENTE_1 AS B WHERE
  A.RUC_CLIENTE=B.RUC_DNI");
while ($ARR_FAC=mysqli_fetch_array($sql_rango)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'.$ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr></tbody>';
}
}
$html.='</tr>';
$html.='</table>';
$html.='<hr></>';
if (isset($inicio,$final)){
$sql_rango=mysql_query($conexion,"SELECT SUM(TOTAL) AS SUMA, COUNT(NRO_FACTURA) AS FILA
FROM BOLETA WHERE (FECHA_FACTURA BETWEEN '$inicio' AND '$final')");
while ($ARR_FAC=mysql_fetch_array($sql_rango)) {
$html.='<table><tbody><tr><td>Compras - Desde: '.$inicio.' a '.$final.'</td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">VENTAS = '.$ARR_FAC['FILA'].'</td></tr><tbody><tr><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">TOTAL = '.$ARR_FAC['SUMA'].'</td></tr></tbody></table>';
}
}
if (!isset($inicio,$final)){
$sql_rango=mysql_query($conexion,"SELECT SUM(TOTAL) AS SUMA, COUNT(NRO_FACTURA) AS FILA  FROM BOLETA ");
while ($ARR_FAC=mysql_fetch_array($sql_rango)) {
$html.='<table><tbody><tr><td>Total de Ventas</td><td width="50"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">VENTAS = '.$ARR_FAC['FILA'].'</td></tr><tbody><tr><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">TOTAL = '.$ARR_FAC['SUMA'].'</td></tr></tbody></table>';
}
}
$mpdf = new mPDF('c','A4');
$css=file_get_contents('Rcss/CssRangoFVPdf.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('rango_fechas_ventas.pdf','I');
?>
</body>
</html>
