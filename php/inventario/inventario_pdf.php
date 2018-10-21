<?php
include('../../conexion.php');
require_once('../pdf/mpdf.php');
session_start();
$FECHA_HOY=date('Y-m-d');
$VAR_FE1=$_SESSION['ini'];
$VAR_FE2=$_SESSION['fin'];
$VAR_CLA=$_SESSION['cla'];
$SQL_NOMBRE=mysql_query("SELECT * FROM clasificacion_producto WHERE COD_CLASIFICACION='$VAR_CLA'",$conexion);
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
$html.="<td style='width:100%; text-align:center; font-size:22px;' ><u>Inventario de ".$r['CLASE_PRODUCTO']."</u></td>";
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
$SQL_PRODUCTO=mysql_query("SELECT * FROM producto WHERE CLASE_PRODUCTO='$VAR_CLA'  ORDER BY NOMBRE_PRODUCTO ",$conexion);
$html.='<table class="datos">';
$html.='<tr>';
$html.='<th>Producto</th>';
$html.='<th>Anterior</th>';
$html.='<th>Ingresos</th>';
$html.='<th>Salidas</th>';
$html.='<th>StockActual</th>';
$html.='</tr>';
while ($ARR_PRODU=mysql_fetch_array($SQL_PRODUCTO)) 
{

	 $VAR_PRODUCTO=$ARR_PRODU['COD_PRODUCTO'];
	 $NOMBRE_PRODUCTO=$ARR_PRODU['NOMBRE_PRODUCTO'];
	
	$SQL_ALACEN1=mysql_query("SELECT COD_PRODUCTO,SUM(CANTIDAD) AS CANTIDAD,'1' FROM CANTIDAD_INGRESO
	WHERE FECHA_FACTURA<=date_add('$VAR_FE1', INTERVAL -1 DAY) and cod_producto='$VAR_PRODUCTO'GROUP BY COD_PRODUCTO",$conexion);

	$SQL_ALACEN2=mysql_query("SELECT COD_PRODUCTO,SUM(CANTIDAD) AS CANTIDAD,'2' FROM CANTIDAD_SALIDA
	WHERE FECHA_FACTURA<=date_add('$VAR_FE1', INTERVAL -1 DAY)  and cod_producto='$VAR_PRODUCTO' GROUP BY COD_PRODUCTO",$conexion);

	$ARR1=mysql_fetch_array($SQL_ALACEN1);
	$ARR2=mysql_fetch_array($SQL_ALACEN2);
	$SALDO_A=$ARR1['CANTIDAD']-$ARR2['CANTIDAD'];
	/*echo "Producto: ".$VAR_PRODUCTO."<br>";
	echo "Saldo".$SALDO_A."<br>";*/

	$SQL_MOVIMIENTO=mysql_query("SELECT * FROM  movimiento_almacen
	where (fecha_factura BETWEEN '$VAR_FE1' and '$VAR_FE2')
	and COD_PRODUCTO='$VAR_PRODUCTO'",$conexion);
	$ENTRADA=0;
	$SALIDA=0;
	while ($ARRA_MOVI=mysql_fetch_array($SQL_MOVIMIENTO)) 
		{
			if ($ARRA_MOVI['PROCESO']==1) 
			{
				$EE=$ARRA_MOVI['CANTIDAD_PRODUCTO'];
				$ENTRADA=$ENTRADA+$EE;
			}
			if ($ARRA_MOVI['PROCESO']==2)
			{
				$SA=$ARRA_MOVI['CANTIDAD_PRODUCTO'];
				$SALIDA=$SALIDA+$SA;
			}
		}	

			$SA=$SALDO_A+$ENTRADA;
			$SA2=$SA-$SALIDA;
		$html.= "<tr>";
		$html.= "<td id='nombre' style='line-height:6pt; text-aling:left;'>".$NOMBRE_PRODUCTO."</td>";
		$html.= "<td style='line-height:6pt;'>".$SALDO_A."</td>";
		$html.= "<td style='line-height:6pt;'>".$ENTRADA."</td>";
		$html.= "<td style='line-height:6pt;'>".$SALIDA."</td>";
		$html.= "<td style='line-height:6pt;'>".$SA2."</td>";
		$html.= "</tr>";
}
$html.='</table>';
/************************CUERPO************************/
$mpdf = new mPDF('c','A4');
$css=file_get_contents('css/pdf_factura.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Cierre_general.pdf','I');
?>