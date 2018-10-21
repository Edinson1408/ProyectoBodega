<?php
include('../../conexion.php');
require_once('../pdf/mpdf.php');
session_start();
$ID_TURNO=$_SESSION['TURNO'];
$FECHA_HOY=$_SESSION['HOY'];
$sql_turno=mysql_query("SELECT a.*, b.DES_TUR as TUR FROM BOLETA AS a, TURNO AS b WHERE a.ID_TURNO=b.ID_TURNO AND FECHA_FACTURA='$FECHA_HOY'",$conexion);
$ARRAY_TURNO=mysql_fetch_array($sql_turno);
$turno=$ARRAY_TURNO['TUR'];
$encargado=$ARRAY_TURNO['ENCARGADO'];

/************************CABECERA************************/
$html.='<table cellspacing="0" style="widht:100%;" class="cabecera">';
$html.='<tr>';
$html.="<td style='width:15%;'><img src='img/pdf.jpeg' style='widht:100%;'></img></td>";
$html.="<td style='text-align:center;  padding-top: 10px; width: 70%; font-size:15px;'>
			Luiggi's Market<br>
			Inversiones Vitteri Ortiz S.A.C<br>
			renatovitteri123@gmail.com
		</td>";
$html.="<td style='text-align:right; width: 15%;'>Emitido:".$FECHA_HOY."</td>";
$html.='</tr>';
$html.='</table>';
/************************CABECERA************************/

/************************TITULO************************/
$html.='<table cellspacing="0" style="widht:100%;" class="titulo">';
$html.='<tr>';
$html.="<td style='width:100%; text-align:center; font-size:22px;' ><u>Cierre de caja</u></td>";
$html.='</tr>';
$html.='<tr>';
$html.="<td style='width:50%; text-align:left; font-size:14PX;;' ><strong>REPORTES: </strong> Todos los turnos </td>";
$html.='</tr>';
$html.='</table>';
/************************TITULO************************/

/************************CUERPO************************/
$html.='<table class="datos">';
$html.='<tr>';
$html.='<th>Encargado</th>';
$html.='<th>Boleta</th>';
$html.='<th>Fecha</th>';
$html.='<th>Hora</th>';
$html.='<th>Cliente</th>';
$html.='<th>Total</th>';
$html.='<th>Estado</th>';
$html.='</tr>';
$SQL_FACTURA=mysql_query("SELECT a.*, b.NOMBRE_C AS CLIENTE, c.NOMBRE_ESTADO AS ESTA FROM BOLETA as a , CLIENTE_1 as b, ESTADO AS c WHERE a.RUC_CLIENTE=b.RUC_DNI AND a.ESTADO=c.ID_ESTADO AND FECHA_FACTURA='$FECHA_HOY'",$conexion);
while ($ARR_FAC=mysql_fetch_array($SQL_FACTURA)) {
$html.='<tr>
			<td>'.$ARR_FAC['ENCARGADO'].'</td>
			<td>'.$ARR_FAC['NRO_FACTURA'].'</td>
			<td>'.$ARR_FAC['FECHA_FACTURA'].'</td>
			<td>'.$ARR_FAC['HORA_FACTURA'].'</td>
			<td>'.$ARR_FAC['CLIENTE'].'</td>
			<td>'.$ARR_FAC['TOTAL'].'</td>
			<td>'.$ARR_FAC['ESTA'].'</td>
		</tr>';
}
$html.='</table>';
$html.='<table class="datos">';
$SQL_TOTAL=mysql_query("SELECT SUM(TOTAL) AS TOTAL FROM BOLETA WHERE FECHA_FACTURA='$FECHA_HOY' AND ESTADO='C'",$conexion);
while ($ARR_TOTAL=mysql_fetch_array($SQL_TOTAL)) {
$html.='<tr>
			<td style="font-size=25px;">TOTAL DE VENTAS</td>
			<td style="font-size=25px;">'.$ARR_TOTAL['TOTAL'].'</td>
		</tr>';
}
$html.='</table>';
/************************CUERPO************************/

/************************TOTALES Y OBSERVACIONES************************/
$html.='<table class="totales">';
$html.='<tr>';
$html.='<th>Boletas Canceladas</th>';
$html.='<th>Total</th>';
$html.='</tr>';
$SQL_BC=mysql_query("SELECT COUNT(NRO_FACTURA) AS BC, SUM(TOTAL) AS TC FROM BOLETA WHERE ESTADO='C' and FECHA_FACTURA='$FECHA_HOY' ",$conexion);
while ($ARR_BC=mysql_fetch_array($SQL_BC)) {
$html.='<tr>
			<td>'.$ARR_BC['BC'].'</td>
			<td>s/. '.$ARR_BC['TC'].'</td>
		</tr>';
}

$html.='<tr>';
$html.='<th>Boletas Pendientes</th>';
$html.='<th>Total</th>';
$html.='</tr>';
$SQL_BP=mysql_query("SELECT COUNT(NRO_FACTURA) AS BP, SUM(TOTAL) AS TP FROM BOLETA WHERE ESTADO='P' and FECHA_FACTURA='$FECHA_HOY'",$conexion);
while ($ARR_BP=mysql_fetch_array($SQL_BP)) {
$html.='<tr>
		<td>'.$ARR_BP['BP'].'</td> 
		<td>s/. '.$ARR_BP['TP'].'</td>
		</tr>';
}

$SQL_TOTAL=mysql_query("SELECT SUM(TOTAL) AS TOTAL FROM BOLETA WHERE FECHA_FACTURA='$FECHA_HOY'",$conexion);
while ($ARR_TOTAL=mysql_fetch_array($SQL_TOTAL)) {
$html.='<tr>
		<th>TOTAL ESTIMADO</th>
		<th>s/. '.$ARR_TOTAL['TOTAL'].'</th>	
		</tr>';
}

$html.='</table>';
/************************TOTALES Y OBSERVACIONES************************/

/************************CREDITO Y AL CONTADO************************/
$html.='<table class="credito">';
$html.='<tr>';
$html.='<th>Boletas a credito</th>';
$html.='<th>Boletas al contado</th>';
$html.='</tr>';
$html.='<tr>';
$html.='<td>0</td>';
/*$SQL_CREDITO=mysql_query("SELECT COUNT(NRO_FACTURA) AS CREDITO FROM BOLETA WHERE FECHA_FACTURA='$FECHA_HOY' AND ID_TURNO='$ID_TURNO' AND TIPO_PAGO='CREDITO'",$conexion);
while ($ARR_CREDI=mysql_fetch_array($SQL_CREDITO)) {
$html.='<tr>
		<td>'.$ARR_CREDI['CREDITO'].'</td>';
}*/
$SQL_CONTADO=mysql_query("SELECT COUNT(NRO_FACTURA) AS CONTADO FROM BOLETA WHERE FECHA_FACTURA='$FECHA_HOY' ",$conexion);
while ($ARR_CONTA=mysql_fetch_array($SQL_CONTADO)) {
$html.='<td>'.$ARR_CONTA['CONTADO'].'</td>	
		</tr>';
}
$html.='</table>';
/************************CREDITO Y AL CONTADO************************/


$mpdf = new mPDF('c','A4');
$css=file_get_contents('pdf_factura.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Cierre_general.pdf','I');
?>