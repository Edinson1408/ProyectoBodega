<?php
session_start();
include('conexion.php');
require __DIR__ . '/../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$connector = new WindowsPrintConnector("EPSONTM");
$printer = new Printer($connector);

/* Initialize */
$printer -> initialize();





/*  image */
try {
    $logo = EscposImage::load("resources/logo.png", false);
    $imgModes = Printer::IMG_DEFAULT;
          $justification =Printer::JUSTIFY_CENTER;
          $printer -> setJustification($justification);
        $printer -> bitImage($logo, $imgModes);
        $printer -> setJustification();
} catch (Exception $e) {
    /* Images not supported on your PHP, or image file not found */
    $printer -> text($e -> getMessage() . "\n");
}
/*ESPACIO*/
$printer -> feed(1);
/* Justification */
$justification =Printer::JUSTIFY_CENTER;
$printer -> setJustification($justification);
/* Font modes */
$modes =  Printer::MODE_DOUBLE_HEIGHT;
    $printer -> selectPrintMode($modes);
    $printer -> text("LUIGGI'S MARKET\n");
$printer -> selectPrintMode(); // Reset


$printer -> text("INVERSIONES VITTERI ORTIZ S.A.C\n");
$printer -> text("R.U.C.: 20601965420\n");

$modes =  Printer::MODE_FONT_B;
    $printer -> selectPrintMode($modes);
    $printer -> text("Cal. 30 B Mza. U2 Lote 01 Urb. Ciudad del Pescador\n");
    $printer -> text("Bellavista Callao\n");
    $printer -> text("987387035\n");
$printer -> selectPrintMode(); // Reset
$printer -> setJustification();


$justification =Printer::JUSTIFY_LEFT;
$printer -> setJustification($justification);
$modes =  Printer::MODE_FONT_B;
$printer -> selectPrintMode($modes);
$BOLETA=$_SESSION['numero_fac'];
$printer -> text("BOLETA DE VENTA\n");
$printer -> text("N° BOLETA:$BOLETA              SERIE:001\n");
$cliente=$_SESSION['N_CLIENTE'];
$dni=$_SESSION['cliente'];
$fecha=$_SESSION['fecha'];
$SQL_HORA=mysql_query("SELECT * FROM BOLETA WHERE NRO_FACTURA='$BOLETA'",$conexion);
$r=mysql_fetch_array($SQL_HORA);
$hora=$r['HORA_FACTURA'];
$printer -> text("Cliente :$cliente      DNI:$dni\n");
$printer -> text("Fecha de Emision:$fecha            Hora:$hora\n");
$printer -> text("********************************************************\n");
$printer -> text("Can.     Descripción    P.U.\n");
$SQL_DETALLE=mysql_query("SELECT SUM(CANTIDAD_PRODUCTO) AS CANTIDAD, SUM(IMPORTE) AS IMPO, COD_PRODUCTO FROM DETALLE_BOLETA WHERE NRO_FACTURA='$BOLETA' GROUP BY COD_PRODUCTO ",$conexion);

while ($ARR_DETA=mysql_fetch_array($SQL_DETALLE)) 
{   $PORDUC=$ARR_DETA['COD_PRODUCTO'];
    $SQL_PRODUCTO=mysql_query("SELECT NOMBRE_PRODUCTO, PRECIO_VENTA FROM PRODUCTO WHERE COD_PRODUCTO='$PORDUC' ",$conexion);
    $ARR_PRO=mysql_fetch_array($SQL_PRODUCTO);
    $can=$ARR_DETA['CANTIDAD'];
    $n_pro=$ARR_PRO['NOMBRE_PRODUCTO'];
    $pu=$ARR_PRO['PRECIO_VENTA'];
$printer -> text("  $can     $n_pro S/.$pu\n");
    
}
$SQL_FAC=mysql_query("SELECT * FROM BOLETA WHERE NRO_FACTURA='$BOLETA'",$conexion);
$ARR_FACTURA=mysql_fetch_array($SQL_FAC);
$igv=$ARR_FACTURA['IGV'];
$sub_total=$ARR_FACTURA['SUB_TOTAL'];
$total=$ARR_FACTURA['TOTAL'];
$printer -> text("********************************************************\n");

$printer -> text("IGV:                                        S/. $igv\n");
$printer -> text("Sub Total:                                  S/. $sub_total\n");
$printer -> text("TOTAL:                                      S/. $total\n");
$printer -> selectPrintMode(); 
$printer -> setJustification();


$justification =Printer::JUSTIFY_CENTER;
$printer -> setJustification($justification);
$modes =  Printer::MODE_FONT_B;
$printer -> selectPrintMode($modes);

$printer -> text("Gracias por su compra!\n");
$printer -> text("--------------------------\n");
$printer -> text("Vuelva Pronto\n");
$printer -> selectPrintMode(); 
$printer -> setJustification();


/*
$justification = array(
    Printer::JUSTIFY_LEFT,
    Printer::JUSTIFY_CENTER,
    Printer::JUSTIFY_RIGHT);
for ($i = 0; $i < count($justification); $i++) {
    $printer -> setJustification($justification[$i]);
    $printer -> text("A man a plan a canal panama\n");
}
$printer -> setJustification(); // Reset
*/


/*coartar el papel*/
$printer -> cut();

/* Pulse */
$printer -> pulse();

/* Always close the printer! On some PrintConnectors, no actual
 * data is sent until the printer is closed. */
$printer -> close();
header("Location:../../salidav2.php");
?>