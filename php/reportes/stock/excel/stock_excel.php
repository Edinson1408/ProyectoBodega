<?php
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=Stock_general.xls');

include_once '../../../Classes/PHPExcel.php';
include('../../../../conexion.php');
/*conexion a la base*/
session_start();
$tipo=$_SESSION['t'];
$objXLS= new PHPExcel();

$objSheet = $objXLS->setActiveSheetIndex(0);
$objSheet->setCellValue('A5', 'Tipo');
$objSheet->setCellValue('B5', 'Producto');
$objSheet->setCellValue('C5', 'Cantidad');
$objSheet->setCellValue('D5', 'P.U');
$objSheet->setCellValue('E5', 'P.Estimado');

$objSheet->getStyle('A5:E5')->getFont()->setBold(true);
$objSheet->getStyle('A5:E5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');

if (isset($tipo)) {
$c=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO AS PRO, B.PRECIO_VENTA,B.PRECIO_VENTA * A.CANTIDAD AS RESULTADO, C.CLASE_PRODUCTO AS CLA
		FROM ALMACEN AS A, PRODUCTO AS B, CLASIFICACION_PRODUCTO AS C   
		WHERE A.COD_PRODUCTO=B.COD_PRODUCTO 
		AND A.COD_CLASIFICACION=C.COD_CLASIFICACION AND A.COD_CLASIFICACION='$tipo'",$conexion);
$numero=5;
while ($dato=mysql_fetch_array($c)) {
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['CLA']);
	$objSheet->setCellValue('B'.$numero, $dato['PRO']);
	$objSheet->setCellValue('C'.$numero, $dato['CANTIDAD']);
	$objSheet->setCellValue('D'.$numero, $dato['PRECIO_VENTA']);
	$objSheet->setCellValue('E'.$numero, $dato['RESULTADO']);
}
}
if (!isset($tipo)){
$c=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO AS PRO, B.PRECIO_VENTA,B.PRECIO_VENTA * A.CANTIDAD AS RESULTADO, C.CLASE_PRODUCTO AS CLA
		FROM ALMACEN AS A, PRODUCTO AS B, CLASIFICACION_PRODUCTO AS C   
		WHERE A.COD_PRODUCTO=B.COD_PRODUCTO 
		AND A.COD_CLASIFICACION=C.COD_CLASIFICACION",$conexion);
$numero=5;
while ($dato=mysql_fetch_array($c)) {
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['CLA']);
	$objSheet->setCellValue('B'.$numero, $dato['PRO']);
	$objSheet->setCellValue('C'.$numero, $dato['CANTIDAD']);
	$objSheet->setCellValue('D'.$numero, $dato['PRECIO_VENTA']);
	$objSheet->setCellValue('E'.$numero, $dato['RESULTADO']);
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
$objSheet->getStyle('A5:E'.$numero)
		->applyFromArray($borders);
/*Par que las columnas salgan  del tamaño del nombre*/
foreach(range('A', 'E') as $column){
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
$objXLS->getActiveSheet()->setTitle('almacen');
$objXLS->setActiveSheetIndex(0);
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');