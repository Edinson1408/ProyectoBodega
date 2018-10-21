<?php
include_once '../Classes/PHPExcel.php';
include('../../conexion.php');
session_start();
$FECHA_HOY=date('Y-m-d');
$VAR_FE1=$_SESSION['i'];
$VAR_FE2=$_SESSION['f'];
$VAR_PRO=$_SESSION['pro'];
$SQL_NOMBRE=mysql_query("SELECT * FROM PRODUCTO WHERE COD_PRODUCTO='$VAR_PRO'",$conexion);
$r=mysql_fetch_array($SQL_NOMBRE);
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=INVENTARIO DE '.$r['NOMBRE_PRODUCTO'].'/'.$VAR_FE1.' hasta '.$VAR_FE2.'.xls');

$objXLS= new PHPExcel();

$objSheet = $objXLS->setActiveSheetIndex(0);
$objSheet->setCellValue('A1', 'INVERSIONES VITTERI ORTIZ S.A.C');
$objSheet->mergeCells('A1:F2');
$objSheet->getStyle('A1')->getFont()->setSize(18);

//negrita
$negrita = array(
    'font' => array(
        'bold' => true
    )
);
$objSheet->getStyle('A1')->applyFromArray($negrita);

//titutlo
$objSheet->setCellValue('A4', 'MOVIMIENTO DE '.$r['NOMBRE_PRODUCTO'].'');
$objSheet->getStyle('A4')->getFont()->setSize(16);
$objSheet->mergeCells('A4:F4');
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

$objSheet->setCellValue('A5', 'Boleta');
$objSheet->setCellValue('B5', 'Fecha');
$objSheet->setCellValue('C5', 'Anterior');
$objSheet->setCellValue('D5', 'Ingreso');
$objSheet->setCellValue('E5', 'Salida');
$objSheet->setCellValue('F5', 'StockActual');

$objSheet->getStyle('A5:F5')->getFont()->setBold(true);
$objSheet->getStyle('A5:F5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');

$ingreso_anterior=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS INGRESO_ANTERIOR FROM movimiento_almacen WHERE COD_PRODUCTO='$VAR_PRO' AND FECHA_FACTURA<'$VAR_FE1' AND PROCESO='1'",$conexion);
	$salida_anterior=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS SALIDA_ANTERIOR FROM movimiento_almacen WHERE COD_PRODUCTO='$VAR_PRO' AND FECHA_FACTURA<'$VAR_FE1' AND PROCESO='2'",$conexion);
	$arr_ing_ante=mysql_fetch_array($ingreso_anterior);
	$arr_sal_ante=mysql_fetch_array($salida_anterior);

	$sql_movimiento=mysql_query("SELECT A.*, B.NOMBRE_PRODUCTO AS PRO FROM MOVIMIENTO_ALMACEN AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND  A.COD_PRODUCTO='$VAR_PRO' AND A.FECHA_FACTURA BETWEEN '$VAR_FE1' AND '$VAR_FE2' ORDER BY FECHA_FACTURA",$conexion);
	$SALDO_ANTERIOR=$arr_ing_ante['INGRESO_ANTERIOR']-$arr_sal_ante['SALIDA_ANTERIOR'];
	$numero=5;
	$espacio=0;
	while ($arr_movi=mysql_fetch_array($sql_movimiento)){
		if ($arr_movi['PROCESO']==1) {
			$SI=$arr_movi['CANTIDAD_PRODUCTO'];
			$SALDO_ACTUAL=$SALDO_ANTERIOR+$SI;
			$numero++;
				$objSheet->setCellValue('A'.$numero, $arr_movi['NRO_FACTURA']);
				$objSheet->setCellValue('B'.$numero, $arr_movi['FECHA_FACTURA']);
				$objSheet->setCellValue('C'.$numero, $SALDO_ANTERIOR);
				$objSheet->setCellValue('D'.$numero, $SI);
				$objSheet->setCellValue('E'.$numero, $espacio);
				$objSheet->setCellValue('F'.$numero, $SALDO_ACTUAL);
				$SALDO_ANTERIOR=$SALDO_ACTUAL;
		}
		if ($arr_movi['PROCESO']==2) {
			$SS=$arr_movi['CANTIDAD_PRODUCTO'];
			$SALDO_ACTUAL=$SALDO_ANTERIOR-$SS;
			$numero++;
				$objSheet->setCellValue('A'.$numero, $arr_movi['NRO_FACTURA']);
				$objSheet->setCellValue('B'.$numero, $arr_movi['FECHA_FACTURA']);
				$objSheet->setCellValue('C'.$numero, $SALDO_ANTERIOR);
				$objSheet->setCellValue('D'.$numero, $espacio);
				$objSheet->setCellValue('E'.$numero, $SS);
				$objSheet->setCellValue('F'.$numero, $SALDO_ACTUAL);
				$SALDO_ANTERIOR=$SALDO_ACTUAL;
		}
	}

$borders= array(
	'borders' => array(
	'allborders' => array(
	'style' =>PHPExcel_Style_Border::BORDER_THIN,
	'color' => array('argb' => 'FF000000'),
		)

		),
	);

$objSheet->getStyle('A5:F'.$numero)
		->applyFromArray($borders);

/*Par que las columnas salgan  del tamaño del nombre*/
foreach(range('A', 'F') as $column){
		$objSheet->getColumnDimension($column)->setAutoSize(true);
}

$objSheet->getStyle("A4:F".$numero)->applyFromArray($style);

$objXLS->createSheet();
$objXLS->setActiveSheetIndex(0);
$objSheet = $objXLS->getActiveSheet()->setTitle('Inventario');
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');
?>