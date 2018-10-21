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
$sql_tipo=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO AS PRO, B.PRECIO_VENTA,B.PRECIO_VENTA * A.CANTIDAD AS RESULTADO, C.CLASE_PRODUCTO AS CLA
		FROM ALMACEN AS A, PRODUCTO AS B, CLASIFICACION_PRODUCTO AS C   
		WHERE A.COD_PRODUCTO=B.COD_PRODUCTO 
		AND A.COD_CLASIFICACION=C.COD_CLASIFICACION 
		AND A.COD_CLASIFICACION='$tipo'",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_tipo)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['CLA'].'</td><td>'.$ARR_FAC['PRO'].'</td><td>'.$ARR_FAC['CANTIDAD'].'</td><td>S/.'.$ARR_FAC['PRECIO_VENTA'].'</td><td>S/.'.$ARR_FAC['RESULTADO'].'</td></tr></tbody>';
}
}
if (!isset($tipo)){
$sql_tipo=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO AS PRO, B.PRECIO_VENTA,B.PRECIO_VENTA * A.CANTIDAD AS RESULTADO, C.CLASE_PRODUCTO AS CLA
		FROM ALMACEN AS A, PRODUCTO AS B, CLASIFICACION_PRODUCTO AS C   
		WHERE A.COD_PRODUCTO=B.COD_PRODUCTO 
		AND A.COD_CLASIFICACION=C.COD_CLASIFICACION",$conexion);
while ($ARR_FAC=mysql_fetch_array($sql_tipo)) {
	$html.='<tbody><tr><td>'.$ARR_FAC['CLA'].'</td><td>'.$ARR_FAC['PRO'].'</td><td>'.$ARR_FAC['CANTIDAD'].'</td><td>S/.'.$ARR_FAC['PRECIO_VENTA'].'</td><td>S/.'.$ARR_FAC['RESULTADO'].'</td></tr></tbody>';
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