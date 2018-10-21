<!DOCTYPE html>
<html>
<head>
  <title>Ventas</title>
  <meta charset="utf-8">
</head>
<?php
require_once('../../pdf/mpdf.php');
include('../../../conexion.php');
session_start();
$fecha=$_SESSION['fecha'];
$usuario=$_SESSION['user'];
$sql_usuario=mysql_query("SELECT A.*, B.DES_TUR AS TUR FROM usuario AS A , TURNO AS B WHERE A.ID_TURNO=B.ID_TURNO AND user='$usuario'",$conexion);
$array_user=mysql_fetch_array($sql_usuario);
$turno=$array_user['ID_TURNO'];
$categoria=$array_user['categoria'];
$nom_tur=$array_user['TUR'];
$tur_d=strtoupper($nom_tur);
$html.="<div class='contenedor'>
		<div class='info'>
        <img src='../img/logo.jpeg'></img>";
$html.='</div>';
$html.='<div class="titulo">';
$html.='<h3>Ventas diarias</h3>';
switch ($categoria) {
	case '1':
$html.='<h4>Dia: '.$fecha.'</h4>';
$html.='<p>Emitido: '.strftime("%A, %d de %B de %Y").'</p>';
$html.='<hr></>';
$html.='</div>';
$html.="<p>REPORTE DIARIO</p>";
$html.='<hr></>';
$html.='</div>';

$SQL_FAC=mysql_query("SELECT A.*, B.NOMBRE_C AS NOMBRE, C.DES_TUR AS TURNO, D.NOMBRE_ESTADO AS ESTADO FROM BOLETA AS A, CLIENTE_1 AS B, TURNO AS C, ESTADO AS D WHERE A.RUC_CLIENTE=B.RUC_DNI AND A.ESTADO=D.ID_ESTADO AND A.ID_TURNO=C.ID_TURNO AND FECHA_FACTURA='$fecha' ORDER BY A.ID_TURNO",$conexion);
$html.='<div class="table">';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Turno</th>';
$html.='<th>Encargado</th>';
$html.='<th>Boleta</th>';
$html.='<th>Fecha</th>';
$html.='<th>Hora</th>';
$html.='<th>Cliente</th>';
$html.='<th>Total</th>';
$html.='<th>Estado</th>';
$html.='</tr>';
$html.='</thead>';
while ($ARR_FAC=mysql_fetch_array($SQL_FAC)) {
	$html.='<tr><td>'.$ARR_FAC['TURNO'].'</td><td>'.$ARR_FAC['ENCARGADO'].'</td><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['HORA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE'].'</td><td>S/.'.$ARR_FAC['TOTAL'].'</td><td>'.$ARR_FAC['ESTADO'].'</td></tr>';
}
$html.='</table>';
$html.='</div>';
$html.='<hr></>';
$html.='<p>-  Total de saldos por turno</p>';
$html.='<div class="table">';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Mañana</th>';
$html.='<th>Tarde</th>';
$html.='<th>Noche</th>';
$html.='<th>Total diario</th>';
$html.='</tr>';
$html.='</thead>';
$sql_dia=mysql_query("SELECT SUM(TOTAL) AS DIA FROM BOLETA WHERE FECHA_FACTURA='$fecha' AND ID_TURNO='TUR1'",$conexion);
$d=mysql_fetch_array($sql_dia);
$html.='<tr>';
$html.='<td>S/.'.$d['DIA'].'</td>';
$sql_tarde=mysql_query("SELECT SUM(TOTAL) AS TARDE FROM BOLETA WHERE FECHA_FACTURA='$fecha' AND ID_TURNO='TUR2'",$conexion);
$t=mysql_fetch_array($sql_tarde);
$html.='<td>S/.'.$t['TARDE'].'</td>';
$sql_noche=mysql_query("SELECT SUM(TOTAL) AS NOCHE FROM BOLETA WHERE FECHA_FACTURA='$fecha' AND ID_TURNO='TUR3'",$conexion);
$n=mysql_fetch_array($sql_noche);
$html.='<td>S/.'.$n['NOCHE'].'</td>';
$sql_turno=mysql_query("SELECT SUM(TOTAL) AS TOTALES FROM BOLETA WHERE FECHA_FACTURA='$fecha'",$conexion);
$r=mysql_fetch_array($sql_turno);
$html.='<td>S/.'.$r['TOTALES'].'</td>';
$html.='</tr>';
$html.='</table>';
$html.='</div>';
		break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	case '2':
$html.='<h4>Dia: '.$fecha.'</h4>';
$html.='<p>Emitido: '.strftime("%A, %d de %B de %Y").'</p>';
$html.='<hr></>';
$html.='</div>';
$html.="<p>REPORTE DEL TURNO ".$tur_d."</p>";
$html.='<hr></>';
$html.='</div>';

$SQL_FAC=mysql_query("SELECT A.*, B.NOMBRE_C AS NOMBRE, C.DES_TUR AS TURNO, D.NOMBRE_ESTADO AS ESTADO FROM BOLETA AS A, CLIENTE_1 AS B, TURNO AS C, ESTADO AS D WHERE A.RUC_CLIENTE=B.RUC_DNI AND A.ESTADO=D.ID_ESTADO AND A.ID_TURNO=C.ID_TURNO AND FECHA_FACTURA='$fecha' and A.ID_TURNO='$turno' ORDER BY A.ID_TURNO",$conexion);
$html.='<div class="table">';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Turno</th>';
$html.='<th>Encargado</th>';
$html.='<th>Boleta</th>';
$html.='<th>Fecha</th>';
$html.='<th>Hora</th>';
$html.='<th>Cliente</th>';
$html.='<th>Total</th>';
$html.='<th>Estado</th>';
$html.='</tr>';
$html.='</thead>';
while ($ARR_FAC=mysql_fetch_array($SQL_FAC)) {
	$html.='<tr><td>'.$ARR_FAC['TURNO'].'</td><td>'.$ARR_FAC['ENCARGADO'].'</td><td>'.$ARR_FAC['NRO_FACTURA'].'</td><td>'.$ARR_FAC['FECHA_FACTURA'].'</td><td>'.$ARR_FAC['HORA_FACTURA'].'</td><td>'.$ARR_FAC['NOMBRE'].'</td><td>S/.'.$ARR_FAC['TOTAL'].'</td><td>'.$ARR_FAC['ESTADO'].'</td></tr>';
}
$html.='</table>';
$html.='</div>';
$html.='<hr></>';
$html.='<p>-  Total de saldos del turno</p>';
$html.='<div class="table">';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>Total de ITEMS vendidos</th>';
$html.='<th>Total diario</th>';
$html.='</tr>';
$html.='</thead>';
$sql_turno=mysql_query("SELECT SUM(TOTAL) AS TOTALES, COUNT(NRO_FACTURA) AS ITEMS FROM BOLETA WHERE FECHA_FACTURA='$fecha' AND ID_TURNO='$turno'",$conexion);
$r=mysql_fetch_array($sql_turno);
$html.='<tr>';
$html.='<td>'.$r['ITEMS'].'</td>';
$html.='<td>S/.'.$r['TOTALES'].'</td>';
$html.='</tr>';
$html.='</table>';
$html.='</div>';		
		break;
}

$mpdf = new mPDF('c','A4');
$css=file_get_contents('../css/estilo.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('ventas.pdf','I');
?>
</html>