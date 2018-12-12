<?php
$FI=$_GET['Inicio'];
$FF=$_GET['Fin'];
header('Content-Type: application/vdn.ms-excel');
header('Content-Disposition: attachment; filename=VENTAS_'.$FI.'_'.$FF.'.xls');

include_once '../../Classes/PHPExcel.php';
include('../../Basedato/conexion.php');
require '../../modelo/CuentasXCobrarM.php';
$objXLS= new PHPExcel();
$ObjCuentas=new Cuentas();

$ListaHistorial=$ObjCuentas->ListaCuentasReporte($FI,$FF);


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
$objSheet->setCellValue('A4', 'Cuentas cobradas ');
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

$objSheet->setCellValue('A5', 'N° Id');
$objSheet->setCellValue('B5', 'N° Documento');
$objSheet->setCellValue('C5', 'Tipo Doc.');
$objSheet->setCellValue('D5', 'Cliente');
$objSheet->setCellValue('E5', 'Total');
$objSheet->setCellValue('F5', 'Amortizado');
$objSheet->setCellValue('G5', 'Saldo');
$objSheet->setCellValue('H5', 'Fecha Com.');
$objSheet->setCellValue('I5', 'Estado');


$objSheet->getStyle('A5:I5')->getFont()->setBold(true);
$objSheet->getStyle('A5:I5')->getFont()->setSize(12)->getColor()->setARGB('FF000080');



$numero=5;
foreach ($ListaHistorial as $dato ) {	
	$numero++;
	$objSheet->setCellValue('A'.$numero, $dato['IDCOMPROBANTE']);
	$objSheet->setCellValue('B'.$numero, $dato['NUMCOMPROBANTE']);
	$objSheet->setCellValue('C'.$numero, $dato['ABREBIATURA']);
	$objSheet->setCellValue('D'.$numero, utf8_encode($dato['NOMCLIENTE']));
	$objSheet->setCellValue('E'.$numero, $dato['TOTAL']);
	$objSheet->setCellValue('F'.$numero, $dato['MONAMORTIZACION']);
	$objSheet->setCellValue('G'.$numero, $dato['SALDOX']);
    $objSheet->setCellValue('H'.$numero, $dato['FECHACOMPROBANTE']);
    if ($dato['SALDOX']=='0') {$a='Cancelado';}else{$a='Pendiente';};
    $objSheet->setCellValue('I'.$numero, $a);
    if($a=='Cancelado'){
        $objSheet->setCellValue('G'.$numero, 'Amortizado');
        $objSheet->setCellValue('H'.$numero, 'Fecha');
        $objSheet->setCellValue('I'.$numero, 'Obdervacion');
        $ListaAmortizacion=$ObjCuentas->DetalleAmortizacionReporte($dato['IDCOMPROBANTE']);
        foreach ($ListaAmortizacion as $R ) {	
            $objSheet->setCellValue('F'.$numero, 'Detalle');
            $objSheet->setCellValue('G'.$numero, $R['MONAMORTIZACION']);
            $objSheet->setCellValue('H'.$numero, $R['FEAMORTIZACION']);
            $objSheet->setCellValue('I'.$numero, $R['OBSERVACION']);
            }
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

$objSheet->getStyle('A5:I'.$numero)
		->applyFromArray($borders);

 /*Par que las columnas salgan  del tamaño del nombre*/
foreach(range('A', 'I') as $column){
    $objSheet->getColumnDimension($column)->setAutoSize(true);
}

$objSheet->getStyle("A4:I".$numero)->applyFromArray($style);

$objXLS->createSheet();
$objXLS->setActiveSheetIndex(0);
$objSheet = $objXLS->getActiveSheet()->setTitle('Ventas');
//generar archivo de excel
$objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
$objWriter->save('php://output');

?>




