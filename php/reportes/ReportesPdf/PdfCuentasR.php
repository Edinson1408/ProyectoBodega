
<?php
require_once('../../pdf/mpdf.php');
include('../../Basedato/conexion.php');
require '../../modelo/CuentasXCobrarM.php';
$ObjCuentas=new Cuentas();
$FI=$_GET['Inicio'];
$FF=$_GET['Fin'];
$ListaHistorial=$ObjCuentas->ListaCuentasReporte($FI,$FF);

$html.="<div class='contenedor'>";
    $html.="<div class='info'><img src='../img/logo.jpeg'><b>LUGGI'S MARKET</b></img></div>";
$html.='</div>';

$html.='<div class="titulo">';
    $html.='<h3>Reporte General de Cuentas</h3>';
    $html.='<p>EMITIDO: '.date("d-m-Y").'</p>';
$html.='</div>';
$html.='<hr></>';
$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>N° Id</th>';
$html.='<th>N° Documento</th>';
$html.='<th>Tipo Doc.</th>';
$html.='<th>Cliente</th>';
$html.='<th>Total</th>';
$html.='<th>Amortizado</th>';
$html.='<th>Saldo</th>';
$html.='<th>Fecha Com.</th>';
$html.='<th>Estado</th>';
$html.='</tr>';
$html.='</thead>';
$html.='<tbody>';
foreach ($ListaHistorial as $f ) {	
    $html.="<tr>";
    $html.="<td>".$f['IDCOMPROBANTE']."</td>";
    $html.="<td>".$f['NUMCOMPROBANTE']."</td>";
    $html.= "<td>".$f['ABREBIATURA']."</td>";
    $html.= "<td>".utf8_encode($f['NOMCLIENTE'])."</td>";
    $html.= "<td>".$f['TOTAL']."</td>";
    $html.= "<td>".$f['MONAMORTIZACION']."</td>";
    $html.= "<td>".$f['SALDOX']."</td>";
    $html.= "<td>".$f['FECHACOMPROBANTE']."</td>";
    if ($f['SALDOX']=='0') {$a='Cancelado';}else{$a='Pendiente';};
    $html.= "<td>".$a."</td>";
    $html.="</tr>";
    if($a=='Cancelado'){
    $html.="<tr>";
        $html.='<thead>';
        $html.='<tr>';
        $html.='<th></th>';
        $html.='<th></th>';
        $html.='<th></th>';
        $html.='<th></th>';
        $html.='<th></th>';
        $html.='<th></th>';
        $html.='<th>Amortizado</th>';
        $html.='<th>Fecha </th>';
        $html.='<th>Obdervacion</th>';
        $html.='</tr>';
        $html.='</thead>';
        $html.='<tbody>';
            $ListaAmortizacion=$ObjCuentas->DetalleAmortizacionReporte($f['IDCOMPROBANTE']);
            foreach ($ListaAmortizacion as $R ) {	
            $html.="<tr>";
            $html.="<td></td>";
            $html.="<td></td>";
            $html.="<td></td>";
            $html.="<td></td>";
            $html.="<td></td>";
            $html.="<td>Detalle</td>";
            $html.="<td>".$R['MONAMORTIZACION']."</td>";
            $html.="<td>".$R['FEAMORTIZACION']."</td>";
            $html.="<td>".$R['OBSERVACION']."</td>";
            $html.="</tr>";
            }
        $html.='</tbody>';
      
    $html.="</tr>";
    }
    
  }
  $html.='</tbody>';
$html.='</table>';


$mpdf = new mPDF('c','A4');
$css=file_get_contents('Rcss/CssRangoFVPdf.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('rango_fechas_ventas.pdf','I');
?>

