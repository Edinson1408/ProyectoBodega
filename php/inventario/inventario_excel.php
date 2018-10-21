<?php
session_start();
$VAR_FE1=$_SESSION['ini'];
$VAR_FE2=$_SESSION['fin'];
$VAR_CLA=$_SESSION['cla'];

include_once '../Classes/PHPExcel.php';
include('../../conexion.php');
$SQL_NOMBRE=mysql_query("SELECT * FROM clasificacion_producto WHERE COD_CLASIFICACION='$VAR_CLA'",$conexion);
$r=mysql_fetch_array($SQL_NOMBRE);
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=Inventario de '.$r['CLASE_PRODUCTO'].'/'.$VAR_FE1.' hasta '.$VAR_FE2.'.xls');
$objXLS= new PHPExcel();


$objSheet = $objXLS->setActiveSheetIndex(0);
$objSheet->setCellValue('A1', 'INVERSIONES VITTERI ORTIZ S.A.C');
$objSheet->mergeCells('A1:E2');
$objSheet->getStyle('A1')->getFont()->setSize(18);

//negrita
$negrita = array(
    'font' => array(
        'bold' => true
    )
);
$objSheet->getStyle('A1')->applyFromArray($negrita);

//titutlo
$objSheet->setCellValue('A4', 'Inventario De '.$r['CLASE_PRODUCTO'].'');
$objSheet->getStyle('A4')->getFont()->setSize(16);
$objSheet->mergeCells('A4:E4');
$objSheet->getStyle('A4')->applyFromArray($negrita);
//centrar texto array
$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
/*aplicar a las celdas el sentrado
$objSheet->getStyle("A1:J1")->applyFromArray($style);
*/

$objSheet->setCellValue('A5', 'Producto');
$objSheet->setCellValue('B5', 'Anterior');
$objSheet->setCellValue('C5', 'Ingreso');
$objSheet->setCellValue('D5', 'Salida');
$objSheet->setCellValue('E5', 'StockActual');

$objSheet->getStyle('A5:E5')->getFont()->setBold(true);
$objSheet->getStyle('A5:E5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');

$SQL_PRODUCTO=mysql_query("SELECT * FROM producto WHERE CLASE_PRODUCTO='$VAR_CLA'  ORDER BY NOMBRE_PRODUCTO ",$conexion);
$numero=5;
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

	$numero++;
	$objSheet->setCellValue('A'.$numero, $NOMBRE_PRODUCTO);
	$objSheet->setCellValue('B'.$numero, $SALDO_A);
	$objSheet->setCellValue('C'.$numero, $ENTRADA);
	$objSheet->setCellValue('D'.$numero, $SALIDA);
	$objSheet->setCellValue('E'.$numero, $SA2);
}

$borders= array(
	'borders' => array(
	'allborders' => array(
	'style' =>PHPExcel_Style_Border::BORDER_THIN,
	'color' => array('argb' => 'FF000000'),
		)

		),
	);

$objSheet->getStyle('A5:E'.$numero)
		->applyFromArray($borders);

/*Par que las columnas salgan  del tamaño del nombre*/
foreach(range('A', 'E') as $column){
		$objSheet->getColumnDimension($column)->setAutoSize(true);
}

$objSheet->getStyle("A4:E".$numero)->applyFromArray($style);

$objXLS->createSheet();
$objXLS->setActiveSheetIndex(0);
$objSheet = $objXLS->getActiveSheet()->setTitle('Inventario');
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');
?>