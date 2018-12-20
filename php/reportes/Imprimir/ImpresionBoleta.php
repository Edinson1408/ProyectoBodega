<!DOCTYPE html>
<html>
<head>
	<title></title>
   
</head>
<body >
<?php
require_once('../../pdf/mpdf.php');
include('../../../conexion.php');
$BOLETA=$_GET['Idcomprobante'];
$Sql=mysqli_query($conexion,"SELECT * FROM comprobante_venta WHERE IDCOMPROBANTE='$BOLETA'");
$res=mysqli_fetch_object($Sql);

$html.='<div class="cabecera">';
$html.='<img src="../../../img/Logo_1.png" style="width:100px;"></img><BR>';
$html.="<p class='ti'>LUIGGI'S MARKET<BR></p>";
$html.="<p class='in'>INVERSIONES VITTERI ORTIZ S.A.C<br>";
$html.="R.U.C.:20601965420</p><br>";
$html.="Cal. 30 B Mza. U2 Lote 01 Urb. Ciudad del Pescador<BR>";
$html.="Bellavista, Callao <BR>";
$html.="R.U.C.:70944692 N/S:88-88888888</p><br>";
$html.='</div>';
$html.='BOLETA DE VENTA<br>';
$BOLETA=$_GET['id'];
$html.='N° BOLETA: '.$res->NUMCOMPROBANTE.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SERIE:'.$res->SERIECOMPROBANTE.'<BR>';
//clienteNOMCLIENTE
$html.='Cliente: '.$res->NOMCLIENTE.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$html.='Dni: '.$res->NOMCLIENTE.'<br>';
$html.='Fecha de Emision: '.$res->FECHACOMPROBANTE.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';


$html.='Hora: <br>';
$html.='************************************************';
$html.='<TABLE><tr><td>Can.</td><td>Descripción</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;P.U</td>';
$SQL_DETALLE=mysqli_query($conexion,"SELECT *
 FROM comprobante_venta_detalle WHERE IDCOMPROBANTE='".$_GET['Idcomprobante']."' 
 GROUP BY CODPRODUCTO ");

while ($ARR_DETA=mysqli_fetch_array($SQL_DETALLE)) 
{
    
    $PORDUC=$ARR_DETA['CODPRODUCTO'];
	$SQL_PRODUCTO=mysqli_query($conexion,"SELECT NOMPRODUCTO FROM PRODUCTO WHERE CODPRODUCTO='$PORDUC' ");
	$ARR_PRO=mysqli_fetch_array($SQL_PRODUCTO);
    $html.='<tr><td>'.$ARR_DETA['CANTIDAD'].'</td><td>'.$ARR_PRO['NOMPRODUCTO'].'</td><td>&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$ARR_DETA['IMPORTE'].'</td></tr>';	
}



//$ARR_FACTURA['IMPORTE'];
//$ARR_FACTURA['IGV'];
//$ARR_FACTURA['TOTAL'];
$html.='</TABLE>************************************************<Br>';
$html.='<div class="cal">';
$html.='<p class="d"> IGV: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$res->IGV.'<br>';
$html.='Sub Total: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$res->SUBTOTAL.'</p>';
$html.='<p class="to">TOTAL: S/.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$res->TOTAL.'</p><br><br>';
$html.='</div>';
$html.='<div class="footer">';
$html.="¡Gracias por su compra en LUIGGI'S MARKET!<br>";
$html.="******************************<br>";
$html.="Vuelva Pronto";
$html.='</div>';

$mpdf = new mPDF('c','B6');
$css=file_get_contents('Imprimir.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('Boleta.pdf','I');

?>
</body>
</html>