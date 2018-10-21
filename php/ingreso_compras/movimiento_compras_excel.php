<?php
/*conexion a la base*/
session_start();
$mes=$_SESSION['mes'];
$año=$_SESSION['ano'];
$meses = array(1 =>'ENERO', 2 =>'FEBRERO',3 =>'MARZO' ,4 =>'ABRIL',5 =>'MAYO',6 =>'JUNIO',7 =>'JULIO',8 =>'AGOSTO',9 =>'SEPTIEMBRE',10 =>'OCTUBRE',11 =>'NOVIEMBRE',12 =>'DICIEMBRE' );
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=MOVIMIENTO_COMPRAS_'.$meses[$mes].'_'.$año.'.xls');

include_once '../Classes/PHPExcel.php';
include('../../conexion.php');

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
$objSheet->setCellValue('A4', 'MOVIMIENTO DE COMPRAS DEL MES '.$meses[$mes].'');
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

$objSheet->setCellValue('A5', 'Factura');
$objSheet->setCellValue('B5', 'Producto');
$objSheet->setCellValue('C5', 'Cantidad');
$objSheet->setCellValue('D5', 'P.U');
$objSheet->setCellValue('E5', 'Importe');
$objSheet->setCellValue('F5', 'Fecha');

$objSheet->getStyle('A5:F5')->getFont()->setBold(true);
$objSheet->getStyle('A5:F5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');

$SQL_VENTAS=mysql_query("SELECT a.*, b.NOMBRE_PRODUCTO, c.FECHA_FACTURA FROM  detalle_factura as a, producto as b, factura as c WHERE a.COD_PRODUCTO=b.COD_PRODUCTO AND a.NRO_FACTURA=c.NRO_FACTURA AND MONTH(c.FECHA_FACTURA)='$mes' and  YEAR(c.FECHA_FACTURA)='$año' order by a.NRO_FACTURA ",$conexion);
$numero=5;
while ($dato=mysql_fetch_array($SQL_VENTAS)) {
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['NRO_FACTURA']);
	$objSheet->setCellValue('B'.$numero, $dato['NOMBRE_PRODUCTO']);
	$objSheet->setCellValue('C'.$numero, $dato['CANTIDAD_PRODUCTO']);
	$objSheet->setCellValue('D'.$numero, $dato['PRECIO_UNITARIO']);
	$objSheet->setCellValue('E'.$numero, $dato['IMPORTE']);
	$objSheet->setCellValue('F'.$numero, $dato['FECHA_FACTURA']);
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
$objSheet = $objXLS->getActiveSheet()->setTitle('Compras');
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');