<?php
include('../../conexion.php');
require_once('../pdf/mpdf.php');
session_start();
$ID_TURNO=$_SESSION['TURNO'];
$FECHA_HOY=$_SESSION['HOY'];
$sql_turno=mysql_query("SELECT a.*, b.DES_TUR as TUR FROM BOLETA AS a, TURNO AS b WHERE a.ID_TURNO=b.ID_TURNO AND FECHA_FACTURA='$FECHA_HOY' and A.ID_TURNO='$ID_TURNO'",$conexion);
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
$html.="<td style='width:100%; text-align:center; font-size:22px;' ><u>Movimiento de Cierre de caja</u></td>";
$html.='</tr>';
$html.='<tr>';
$html.="<td style='width:50%; text-align:left; font-size:14PX;;' ><strong>Encargado: </strong>".$encargado." </td>";
$html.='</tr>';
$html.='<tr>';
$html.="<td style='width:50%; text-align:left; font-size:14PX;;' ><strong>Turno : </strong>".$turno."</td>";
$html.='</tr>';
$html.='</table>';
/************************TITULO************************/
/************************CUERPO************************/
$html.='<table class="datos">';
$html.='<tr>';
$html.='<th>Boleta</th>';
$html.='<th>Producto</th>';
$html.='<th>Cantidad</th>';
$html.='<th>P.U</th>';
$html.='<th>Importe</th>';
$html.='<th>Fecha</th>';
$html.='</tr>';
$SQL_FACTURA=mysql_query("SELECT a.*, b.NOMBRE_PRODUCTO, c.FECHA_FACTURA FROM  detalle_boleta as a, producto as b, boleta as c WHERE a.COD_PRODUCTO=b.COD_PRODUCTO AND a.NRO_FACTURA=c.NRO_FACTURA AND c.FECHA_FACTURA='$FECHA_HOY' order by a.NRO_FACTURA ",$conexion);
while ($ARR_FAC=mysql_fetch_array($SQL_FACTURA)) {
$html.='<tr>
			<td>'.$ARR_FAC['NRO_FACTURA'].'</td>
			<td>'.$ARR_FAC['NOMBRE_PRODUCTO'].'</td>
			<td>'.$ARR_FAC['CANTIDAD_PRODUCTO'].'</td>
			<td>'.$ARR_FAC['PRECIO_UNITARIO'].'</td>
			<td>'.$ARR_FAC['IMPORTE'].'</td>
			<td>'.$ARR_FAC['FECHA_FACTURA'].'</td>
		</tr>';
}
$html.='</table>';
$mpdf = new mPDF('c','A4');
$css=file_get_contents('pdf_factura.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('cierre_general.pdf','I');
?>