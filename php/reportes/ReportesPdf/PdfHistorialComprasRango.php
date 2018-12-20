
<?php
require_once('../../pdf/mpdf.php');
include('../../Basedato/conexion.php');
require '../../modelo/ComprasM.php';
$ObjReporteV=new Compras();
$mes=$_GET['mes'];
$año=$_GET['ano'];
$ListaHistorial=$ObjReporteV->HistorialComprasRango($mes,$año);
//$inicio=$_GET['Inicio'];
//$final=$_GET['Final'];
$html.="<div class='contenedor'>";
    $html.="<div class='info'><img src='../img/logo.jpeg'><b>LUGGI'S MARKET</b></img></div>";
$html.='</div>';

$html.='<div class="titulo">';
    $html.='<h3>Reporte General de Compras del '.$mes.' al '.$año.'</h3>';
    $html.='<p>EMITIDO: '.date("d-m-Y").'</p>';
$html.='</div>';
$html.='<hr></>';


$html.='<table>';
$html.='<thead>';
$html.='<tr>';
$html.='<th>N° Comprobante</th>';
$html.='<th>N°Serie</th>';
$html.='<th>Doc.</th>';
$html.='<th>Turno</th>';
$html.='<th>Encargado</th>';
$html.='<th>Fecha</th>';
$html.='<th>Proveedor</th>';
$html.='<th>Estado</th>';
$html.='<th>Sub_total</th>';
$html.='<th>IGV</th>';
$html.='<th>Total</th>';
$html.='</tr>';
$html.='</thead>';
$html.='<tbody>';
foreach ($ListaHistorial as $f ) {	
    $html.="<tr>";
    $html.="<td>".$f['IDCOMPROBANTE']."</td>";
    $html.="<td>".$f['SERIECOMPROBANTE']."</td>";
    $html.= "<td>".$f['NUMCOMPROBANTE']."</td>";
    $html.= "<td>".utf8_encode($f['NOMTURNO'])."</td>";
    $html.= "<td>".$f['ENCARGADO']."</td>";
    $html.= "<td>".$f['FECHACOMPROBANTE']."</td>";
    $html.= "<td>".$f['NOMPROVEEDOR']."</td>";
    $html.= "<td>".$f['IDESTADO']."</td>";
    $html.= "<td>".$f['SUBTOTAL']."</td>";
    $html.= "<td>".$f['IGV']."</td>";
    $html.= "<td>".$f['TOTAL']."</td>";
    $html.="<tr>";
  }
  $html.='</tbody>';
//while ($ARR_FAC=mysqli_fetch_array($sql_rango)) {
 //   $html.='<tbody>
 //   <tr>
 //   <td>'.$ARR_FAC['NRO_FACTURA'].'</td>
 //   <td>'.$ARR_FAC['FECHA_FACTURA'].'</td>
 //   <td>'.$ARR_FAC['NOMBRE'].'</td>
 //   <td>'.$ARR_FAC['SUB_TOTAL'].'</td>
 //   <td>'.$ARR_FAC['IGV'].'</td>
 //   <td>'.$ARR_FAC['TOTAL'].'</td>
//    </tr>
////    </tbody>';
//}

$html.='</table>';


$mpdf = new mPDF('c','A4');
$css=file_get_contents('Rcss/CssRangoFVPdf.css');
$mpdf->writeHTML($css,1);
$mpdf->writeHTML($html);
$mpdf->Output('rango_fechas_ventas.pdf','I');
?>

