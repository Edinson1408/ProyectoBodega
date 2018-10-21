<?php
/*conexion a la base*/
session_start();
$mes=$_SESSION['mes'];
$año=$_SESSION['ano'];
$meses = array(1 =>'ENERO', 2 =>'FEBRERO',3 =>'MARZO' ,4 =>'ABRIL',5 =>'MAYO',6 =>'JUNIO',7 =>'JULIO',8 =>'AGOSTO',9 =>'SEPTIEMBRE',10 =>'OCTUBRE',11 =>'NOVIEMBRE',12 =>'DICIEMBRE' );
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=VENTAS_'.$meses[$mes].'_'.$año.'.xls');

include_once '../../Classes/PHPExcel.php';
include('../../../conexion.php');

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
$objSheet->setCellValue('A4', 'VENTAS DEL MES '.$meses[$mes].'');
$objSheet->getStyle('A4')->getFont()->setSize(16);
$objSheet->mergeCells('A4:H4');
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
$objSheet->setCellValue('B5', 'N°Serie');
$objSheet->setCellValue('C5', 'Turno');
$objSheet->setCellValue('D5', 'Encargado');
$objSheet->setCellValue('E5', 'Fecha');
$objSheet->setCellValue('F5', 'Cliente');
$objSheet->setCellValue('G5', 'Estado');
$objSheet->setCellValue('H5', 'Total');

$objSheet->getStyle('A5:H5')->getFont()->setBold(true);
$objSheet->getStyle('A5:H5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');

$SQL_VENTAS=mysql_query("SELECT a.*,b.NOMBRE_C AS NOMBRE,c.DES_TUR AS TURNO, d.NOMBRE_ESTADO AS ES FROM  boleta as a, cliente_1 as b, turno as c, estado as d WHERE a.RUC_CLIENTE=b.RUC_DNI AND a.ID_TURNO=c.ID_TURNO AND a.ESTADO=d.ID_ESTADO AND MONTH(a.FECHA_FACTURA)='$mes' and  YEAR(a.FECHA_FACTURA)='$año' ",$conexion);
$numero=5;
while ($dato=mysql_fetch_array($SQL_VENTAS)) {
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['NRO_FACTURA']);
	$objSheet->setCellValue('B'.$numero, $dato['SERIE_FACTURA']);
	$objSheet->setCellValue('C'.$numero, $dato['TURNO']);
	$objSheet->setCellValue('D'.$numero, $dato['ENCARGADO']);
	$objSheet->setCellValue('E'.$numero, $dato['FECHA_FACTURA']);
	$objSheet->setCellValue('F'.$numero, $dato['NOMBRE']);
	$objSheet->setCellValue('G'.$numero, $dato['ES']);
	$objSheet->setCellValue('H'.$numero, $dato['TOTAL']);
}

$borders= array(
	'borders' => array(
	'allborders' => array(
	'style' =>PHPExcel_Style_Border::BORDER_THIN,
	'color' => array('argb' => 'FF000000'),
		)

		),
	);

$objSheet->getStyle('A5:H'.$numero)
		->applyFromArray($borders);

/*Par que las columnas salgan  del tamaño del nombre*/
foreach(range('A', 'H') as $column){
		$objSheet->getColumnDimension($column)->setAutoSize(true);
}

$objSheet->getStyle("A4:H".$numero)->applyFromArray($style);

$objXLS->createSheet();
$objXLS->setActiveSheetIndex(0);
$objSheet = $objXLS->getActiveSheet()->setTitle('Ventas');
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');