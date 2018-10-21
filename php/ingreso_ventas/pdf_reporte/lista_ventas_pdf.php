<!DOCTYPE html>
<html>
<head>
  <title>Compras</title>
</head>
<?php
require_once('../pdf/mpdf.php');
include('../../../conexion.php');
session_start();
$mes=$_SESSION['mes'];
$año=$_SESSION['ano'];
$meses = array(1 =>'Enero', 2 =>'Febrero',3 =>'Marzo' ,4 =>'Abril',5 =>'Mayo',6 =>'Junio',7 =>'Julio',8 =>'Agosto',9 =>'Septiembre',10 =>'octubre',11 =>'Noviembre',12 =>'Diciembre' );
//===========================================

$html.="<div class='contenedor'>
		<div class='info'>
        <img src='../img/logo.jpeg'></img>";
$html.='</div>';

$html.='<div class="titulo">';
$html.='<h3>Ventas Mensuales</h3>';
$html.='<h4>Mes: '.$meses[$mes].'  -  Año: '.$año.'</h4>';
$html.='</div>';
$html.='<hr></>';
$html.='</div>';

$SQL_FAC=mysql_query("SELECT a.*,b.NOMBRE_C AS NOMBRE,c.DES_TUR AS TURNO, d.NOMBRE_ESTADO AS ES FROM  boleta as a, cliente_1 as b, turno as c, estado as d WHERE a.RUC_CLIENTE=b.RUC_DNI AND a.ID_TURNO=c.ID_TURNO AND a.ESTADO=d.ID_ESTADO AND MONTH(a.FECHA_FACTURA)='$mes' and  YEAR(a.FECHA_FACTURA)='$año'",$conexion);
$html.='<div class="table">';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Boleta</th>';
$html.='<th>Serie</th>';
$html.='<th>Turno</th>';
$html.='<th>Encargado</th>';
$html.='<th>Fecha</th>';
$html.='<th>Hora</th>';
$html.='<th>Cliente</th>';
$html.='<th>Estado</th>';
$html.='<th>Total</th>';
$html.='</thead>';
while ($ARR_FAC=mysql_fetch_array($SQL_FAC)) {
	$html.='<tr><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['SERIE_FACTURA'].'</td><td>'.$ARR_FAC['TURNO'].'</td><td>'.$ARR_FAC['ENCARGADO'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['HORA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE'].'</td><td>'.$ARR_FAC['ES'].'</td><td>'.$ARR_FAC['TOTAL'].'</td></tr>';
}
$html.='</tr>';
$html.='</table>';
$html.='</div>';
$mpdf = new mPDF('c','A4');
$css=file_get_contents('../css/estilo.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('ventas.pdf','I');


?>
</html>