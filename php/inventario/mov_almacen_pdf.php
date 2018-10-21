<?php
include('../../conexion.php');
require_once('../pdf/mpdf.php');
session_start();
$FECHA_HOY=date('Y-m-d');
$VAR_FE1=$_SESSION['i'];
$VAR_FE2=$_SESSION['f'];
$VAR_PRO=$_SESSION['pro'];
$SQL_NOMBRE=mysql_query("SELECT * FROM producto WHERE COD_PRODUCTO='$VAR_PRO'",$conexion);
$r=mysql_fetch_array($SQL_NOMBRE);
/************************CABECERA************************/
$html.=		"<table cellspacing='0' style='widht:100%;' class='cabecera'>";
$html.=		"<tr>";
$html.=		"<td style='width:15%;'><img src='img/pdf.jpeg' style='widht:100%;'></img></td>";
$html.=		"<td style='text-align:center;  padding-top: 10px; width: 70%; font-size:15px;'>
			Luiggi's Market<br>
			Inversiones Vitteri Ortiz S.A.C<br>
			renatovitteri123@gmail.com
		</td>";
$html.=		"<td style='text-align:right; width: 15%;'>Emitido:".$FECHA_HOY."</td>";
$html.=		"</tr>";
$html.=		"</table>";
/************************CABECERA************************/


/************************TITULO************************/
$html.='<table cellspacing="0" style="widht:100%;" class="titulo">';
$html.='<tr>';
$html.="<td style='width:100%; text-align:center; font-size:22px;' ><u>Movimiento de ".$r['NOMBRE_PRODUCTO']."</u></td>";
$html.='</tr>';
$html.='<tr>';
$html.="<td style='width:50%; text-align:left; font-size:14PX;;' ><strong>Desde : </strong>".$VAR_FE1."</td>";
$html.='</tr>';
$html.='<tr>';
$html.="<td style='width:50%; text-align:left; font-size:14PX;;' ><strong>Hasta : </strong>".$VAR_FE2."</td>";
$html.='</tr>';
$html.='</table>';
/************************TITULO************************/


/************************CUERPO************************/
$html.='<table class="datos">';
$html.='<tr>';
$html.='<th>Boleta</th>';
$html.='<th>Fecha</th>';
$html.='<th>Anterior</th>';
$html.='<th>Ingresos</th>';
$html.='<th>Salidas</th>';
$html.='<th>StockActual</th>';
$html.='</tr>';
$ingreso_anterior=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS INGRESO_ANTERIOR FROM movimiento_almacen WHERE COD_PRODUCTO='$VAR_PRO' AND FECHA_FACTURA<'$VAR_FE1' AND PROCESO='1'",$conexion);
	$salida_anterior=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS SALIDA_ANTERIOR FROM movimiento_almacen WHERE COD_PRODUCTO='$VAR_PRO' AND FECHA_FACTURA<'$VAR_FE1' AND PROCESO='2'",$conexion);
	$arr_ing_ante=mysql_fetch_array($ingreso_anterior);
	$arr_sal_ante=mysql_fetch_array($salida_anterior);

	$sql_movimiento=mysql_query("SELECT A.*, B.NOMBRE_PRODUCTO AS PRO FROM MOVIMIENTO_ALMACEN AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND  A.COD_PRODUCTO='$VAR_PRO' AND A.FECHA_FACTURA BETWEEN '$VAR_FE1' AND '$VAR_FE2' ORDER BY FECHA_FACTURA",$conexion);
	$SALDO_ANTERIOR=$arr_ing_ante['INGRESO_ANTERIOR']-$arr_sal_ante['SALIDA_ANTERIOR'];

	while ($arr_movi=mysql_fetch_array($sql_movimiento)){
		if ($arr_movi['PROCESO']==1) {
			$SI=$arr_movi['CANTIDAD_PRODUCTO'];
			$SALDO_ACTUAL=$SALDO_ANTERIOR+$SI;
			$html.= '<tr>';
				$html.= '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['NRO_FACTURA'].'</td>';
				$html.= '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['FECHA_FACTURA'].'</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ANTERIOR.'</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">'.$SI.'</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">0</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ACTUAL.'</td>';
				$SALDO_ANTERIOR=$SALDO_ACTUAL;
			$html.= '</tr>';
		}
		if ($arr_movi['PROCESO']==2) {
			$SS=$arr_movi['CANTIDAD_PRODUCTO'];
			$SALDO_ACTUAL=$SALDO_ANTERIOR-$SS;
			$html.= '<tr style="background: #E5E8E8;">';
				$html.= '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['NRO_FACTURA'].'</td>';
				$html.= '<td style="line-height: 6pt; text-align: center;">'.$arr_movi['FECHA_FACTURA'].'</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ANTERIOR.'</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">0</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">'.$SS.'</td>';
				$html.= '<td style="line-height: 6pt; text-align: right;">'.$SALDO_ACTUAL.'</td>';
				$SALDO_ANTERIOR=$SALDO_ACTUAL;
			$html.= '</tr>';
		}
	}
$html.='</table>';
/************************CUERPO************************/
$mpdf = new mPDF('c','A4');
$css=file_get_contents('css/pdf_factura.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Cierre_general.pdf','I');
?>