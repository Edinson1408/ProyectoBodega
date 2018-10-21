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
$ruc=$_SESSION['p'];
$html.="<div class='contenedor'>
		<div class='info'>
        <img src='../../img/logo.jpeg'><b>LUGGI'S MARKET</b></img>";
$html.='</div>';
$html.='<div class="titulo">';
$html.='<h3>Movimientos Proveedores</h3>';
if (isset($inicio,$final,$ruc)) {	
$sql_p=mysql_query("SELECT * FROM CLIENTE WHERE RUC_CLIENTE='$ruc'",$conexion);
while ($r=mysql_fetch_array($sql_p)) {	
$html.='<p>Proveedor: '.$r["NOMBRE_CLIENTE"].'</p>';
}
$html.='<p>Desde: '.$inicio.'  -  Hasta: '.$final.'</p>';
}
else{
$html.='<p>Todos los Proveedores</p>';	
}
$html.='<p>EMITIDO: '.date("d-m-Y").'</p>';
$html.='</div>';
$html.='<hr></>';
$html.='</div>';
$sql_proveedor=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND (FECHA_FACTURA BETWEEN '$inicio' AND '$final') AND A.RUC_CLIENTE='$ruc' AND PROCESO='1'");
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Proveedores</th>';
$html.='<th>Factura N°</th>';
$html.='<th>Fecha</th>';
$html.='<th>Sub Total</th>';
$html.='<th>Igv</th>';
$html.='<th>Total</th>';
$html.='</thead>';
if (isset($inicio,$final,$ruc)) {
while ($ARR_FAC=mysql_fetch_array($sql_proveedor)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['NOMBRE'].'</td><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'.$ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr></tbody>';
}
}
if (!isset($inicio,$final)){
$sql_proveedor=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND PROCESO='1'");
while ($ARR_FAC=mysql_fetch_array($sql_proveedor)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['NOMBRE'].'</td><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['SUB_TOTAL'].'</td><td>'.$ARR_FAC['IGV'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr></tbody>';
}
}
$html.='</tr>';
$html.='</table>';
$html.='<hr></>';
if (isset($inicio,$final,$ruc)){
$sql_proveedor=mysql_query("SELECT SUM(TOTAL) AS SUMA, COUNT(NRO_FACTURA) AS FILA FROM FACTURA WHERE (FECHA_FACTURA BETWEEN '$inicio' AND '$final') AND RUC_CLIENTE='$ruc' AND PROCESO='1'",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_proveedor)) {
$html.='<table><tbody><tr><td>Compras - Desde: '.$inicio.' a '.$final.'</td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">COMPRAS = '.$ARR_FAC['FILA'].'</td></tr><tbody><tr><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">TOTAL = '.$ARR_FAC['SUMA'].'</td></tr></tbody></table>';
}
}
if (!isset($inicio,$final,$ruc)){
$sql_proveedor=mysql_query("SELECT SUM(TOTAL) AS SUMA, COUNT(NRO_FACTURA) AS FILA  FROM FACTURA WHERE PROCESO='1'",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_proveedor)) {
$html.='<table><tbody><tr><td>Total de Compras</td><td width="50"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">COMPRAS = '.$ARR_FAC['FILA'].'</td></tr><tbody><tr><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1"></td><td CLASS="td1">TOTAL = '.$ARR_FAC['SUMA'].'</td></tr></tbody></table>';
}
}
$mpdf = new mPDF('c','A4');
$css=file_get_contents('estilo.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('rango_fechas_ventas.pdf','I');
?>
</body>
</html>