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
$tipo=$_SESSION['t'];
$html.="<div class='contenedor'>
		<div class='info'>
        <img src='../../img/logo.jpeg'><b>LUGGI'S MARKET</b></img>";
$html.='</div>';
$html.='<div class="titulo">';
$html.='<h3>General - STOCK</h3>';
if (isset($tipo)) {	
$sql_p=mysql_query("SELECT * FROM CLASIFICACION_PRODUCTO WHERE COD_CLASIFICACION='$tipo'",$conexion);
while ($r=mysql_fetch_array($sql_p)) {
$html.='<p>Stock de '.$r["CLASE_PRODUCTO"].'</p>';
}
}else{
$html.='<p>Todos los productos</p>';	
}
$html.='<p>EMITIDO: '.date("d-m-Y").'</p>';
$html.='</div>';
$html.='<hr></>';
$html.='</div>';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Tipo</th>';
$html.='<th>Producto</th>';
$html.='<th>Cantidad</th>';
$html.='<th>P.U</th>';
$html.='<th>P.Estimado</th>';
$html.='</thead>';
if (isset($tipo)) {	
$sql_tipo=mysql_query("SELECT a.PRODUCTO, IFNULL(a.STOCK, 0) AS STOCK, b.CLASE_PRODUCTO AS CLASI,c.PRECIO_VENTA, IFNULL(a.STOCK,0)*C.PRECIO_VENTA AS ESTIMADO
		FROM stock as a, CLASIFICACION_PRODUCTO as b, producto as c
		WHERE a.CLASIFICACION=b.COD_CLASIFICACION AND a.COD_PRODUCTO=c.COD_PRODUCTO AND a.CLASIFICACION='$tipo' ORDER BY a.PRODUCTO",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_tipo)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['CLASI'].'</td><td>'.$ARR_FAC['PRODUCTO'].'</td><td>'.$ARR_FAC['STOCK'].'</td><td>S/.'.$ARR_FAC['PRECIO_VENTA'].'</td><td>S/.'.$ARR_FAC['ESTIMADO'].'</td></tr></tbody>';
}
}
if (!isset($tipo)){
$sql_tipo=mysql_query("SELECT a.PRODUCTO, IFNULL(a.STOCK, 0) AS STOCK, b.CLASE_PRODUCTO AS CLASI,c.PRECIO_VENTA, IFNULL(a.STOCK,0)*C.PRECIO_VENTA AS ESTIMADO
		FROM stock as a, CLASIFICACION_PRODUCTO as b, producto as c
		WHERE a.CLASIFICACION=b.COD_CLASIFICACION AND a.COD_PRODUCTO=c.COD_PRODUCTO ORDER BY a.CLASIFICACION",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_tipo)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['CLASI'].'</td><td>'.$ARR_FAC['PRODUCTO'].'</td><td>'.$ARR_FAC['STOCK'].'</td><td>S/.'.$ARR_FAC['PRECIO_VENTA'].'</td><td>S/.'.$ARR_FAC['ESTIMADO'].'</td></tr></tbody>';
}
}
$html.='</tr>';
$html.='</table>';
$html.='<hr></>';
$mpdf = new mPDF('c','A4');
$css=file_get_contents('estilo.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('rango_fechas_ventas.pdf','I');
?>
</body>
</html>