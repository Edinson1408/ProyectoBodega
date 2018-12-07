<?php
$mes=$_GET['mes'];
$año=$_GET['ano'];
$meses = array(1 =>'ENERO', 2 =>'FEBRERO',3 =>'MARZO' ,4 =>'ABRIL',5 =>'MAYO',6 =>'JUNIO',7 =>'JULIO',8 =>'AGOSTO',9 =>'SEPTIEMBRE',10 =>'OCTUBRE',11 =>'NOVIEMBRE',12 =>'DICIEMBRE' );
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=VENTAS_'.$meses[$mes].'_'.$año.'.xls');

include_once '../../Classes/PHPExcel.php';
include('../../Basedato/conexion.php');
require '../../modelo/VentasM.php';
$objXLS= new PHPExcel();
$ObjReporteV=new VentasM();

$ListaHistorial=$ObjReporteV->HistorialVentasR($mes,$año);

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

$objSheet->setCellValue('A5', 'N° Comprobante');
$objSheet->setCellValue('B5', 'N°Serie');
$objSheet->setCellValue('C5', 'Doc.');
$objSheet->setCellValue('D5', 'Turno');
$objSheet->setCellValue('E5', 'Encargado');
$objSheet->setCellValue('F5', 'Fecha');
$objSheet->setCellValue('G5', 'Cliente');
$objSheet->setCellValue('H5', 'Estado');
$objSheet->setCellValue('I5', 'Sub_total');
$objSheet->setCellValue('J5', 'IGV');
$objSheet->setCellValue('K5', 'IGV');


$objSheet->getStyle('A5:K5')->getFont()->setBold(true);
$objSheet->getStyle('A5:K5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');



$numero=5;
foreach ($ListaHistorial as $dato ) {	
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['IDCOMPROBANTE']);
	$objSheet->setCellValue('B'.$numero, $dato['SERIECOMPROBANTE']);
	$objSheet->setCellValue('C'.$numero, $dato['NUMCOMPROBANTE']);
	$objSheet->setCellValue('D'.$numero, utf8_encode($dato['NOMTURNO']));
	$objSheet->setCellValue('E'.$numero, $dato['ENCARGADO']);
	$objSheet->setCellValue('F'.$numero, $dato['FECHACOMPROBANTE']);
	$objSheet->setCellValue('G'.$numero, $dato['NOMCLIENTE']);
    $objSheet->setCellValue('H'.$numero, $dato['IDESTADO']);
    $objSheet->setCellValue('I'.$numero, $dato['SUBTOTAL']);
    $objSheet->setCellValue('J'.$numero, $dato['IGV']);
    $objSheet->setCellValue('K'.$numero, $dato['TOTAL']);
}


$borders= array(
	'borders' => array(
	'allborders' => array(
	'style' =>PHPExcel_Style_Border::BORDER_THIN,
	'color' => array('argb' => 'FF000000'),
		)

		),
	);

$objSheet->getStyle('A5:K'.$numero)
		->applyFromArray($borders);

 /*Par que las columnas salgan  del tamaño del nombre*/
foreach(range('A', 'K') as $column){
    $objSheet->getColumnDimension($column)->setAutoSize(true);
}

$objSheet->getStyle("A4:K".$numero)->applyFromArray($style);

$objXLS->createSheet();
$objXLS->setActiveSheetIndex(0);
$objSheet = $objXLS->getActiveSheet()->setTitle('Ventas');
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');

?>






