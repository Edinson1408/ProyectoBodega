<?php
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=Compras.xls');

include_once '../../../Classes/PHPExcel.php';
include('../../../../conexion.php');
/*conexion a la base*/
session_start();
$inicio=$_SESSION['i'];
$final=$_SESSION['f'];
$objXLS= new PHPExcel();
$objSheet = $objXLS->setActiveSheetIndex(0);
$objSheet->setCellValue('A5', 'Factura N°');
$objSheet->setCellValue('B5', 'Fecha');
$objSheet->setCellValue('C5', 'Proveedor');
$objSheet->setCellValue('D5', 'Sub_Total');
$objSheet->setCellValue('E5', 'Igv');
$objSheet->setCellValue('F5', 'Total');

$objSheet->getStyle('A5:F5')->getFont()->setBold(true);
$objSheet->getStyle('A5:F5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');
if (isset($inicio,$final)){
$c=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND (FECHA_FACTURA BETWEEN '$inicio' AND '$final') AND PROCESO='1'",$conexion);
$numero=5;
while ($dato=mysql_fetch_array($c)) {
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['NRO_FACTURA']);
	$objSheet->setCellValue('B'.$numero, $dato['FECHA_FACTURA']);
	$objSheet->setCellValue('C'.$numero, $dato['NOMBRE']);
	$objSheet->setCellValue('D'.$numero, $dato['SUB_TOTAL']);
	$objSheet->setCellValue('E'.$numero, $dato['IGV']);
	$objSheet->setCellValue('F'.$numero, $dato['TOTAL']);
}
}
if (!isset($inicio,$final)){
$c=mysql_query("SELECT A.*, B.NOMBRE_CLIENTE AS NOMBRE FROM FACTURA AS A, CLIENTE AS B WHERE A.RUC_CLIENTE=B.RUC_CLIENTE AND PROCESO='1' ",$conexion);
$numero=5;
while ($dato=mysql_fetch_array($c)) {
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['NRO_FACTURA']);
	$objSheet->setCellValue('B'.$numero, $dato['FECHA_FACTURA']);
	$objSheet->setCellValue('C'.$numero, $dato['NOMBRE']);
	$objSheet->setCellValue('D'.$numero, $dato['SUB_TOTAL']);
	$objSheet->setCellValue('E'.$numero, $dato['IGV']);
	$objSheet->setCellValue('F'.$numero, $dato['TOTAL']);
}
}
$borders= array(
	'bold'  => true,
	'padding' => 10,
	'borders' => array(
	'allborders' => array(
	'style' =>PHPExcel_Style_Border::BORDER_THIN,
	'color' => array('argb' => 'FF000000'),
		)
		),
	'font'  => array(
        'color' => array('argb' => 'FF0000'),
        'size'  => 11,
        'name'  => 'Verdana',
    )
	);
$objSheet->getStyle('A5:F'.$numero)
		->applyFromArray($borders);
/*Par que las columnas salgan  del tamaño del nombre*/
foreach(range('A', 'F') as $column){
		$objSheet->getColumnDimension($column)->setAutoSize(true);
}
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$logo = '../../img/excel.jpeg'; 
$objDrawing->setPath($logo); 
$objDrawing->setCoordinates('A1','A2','A3');
$objDrawing->setHeight(50);

$objDrawing->setWorksheet($objXLS->getActiveSheet()); 
$objXLS->getActiveSheet()->setTitle('Compras');
$objXLS->setActiveSheetIndex(0);
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');