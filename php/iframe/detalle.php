<?php
include('../../conexion.php');
session_start();
$nro=$_POST['codigo'];
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		body, html{
			margin: 0;
			padding: 0;
		}
		.contenedor{
			width: 100%;
			margin: auto;
		}
		.cabecera{
			text-align: center;
		}
		.ti{
			font-weight: bold;
			line-height: 1em;
			text-align: center;
			font-size: 18pt;
		}
		.in{
			line-height: 1em;
			text-align: center;
		}
		.cuerpo{
			width: 50%;
			margin: auto;
		}
		.cal{
			line-height: 1em;
		}
		.footer{
			text-align: center;
		}
		.to{
			font-weight: bold;
			line-height: 1em;
		}
		.d{
			line-height: 1em;
		}
		p{
			margin:  0;
		}
	</style>
</head>
<body>
<div class="contenedor">
<div class="cabecera">
	<img src="iframe/img/imprimir.jpeg"></img><BR>
	<p class='ti'>LUIGGI'S MARKET<BR></p>
	<p class='in'>INVERSIONES VITTERI ORTIZ S.A.C<br>R.U.C.:20601965420<br>Cal. 30 B Mza. U2 Lote 01 Urb. Ciudad del Pescador<BR>Bellavista, Callao</p><br>
</div>
<div class="cuerpo">
<p> BOLETA DE VENTA<br>
<?php
$SQL_HORA=mysqli_query($conexion,"SELECT A.*, B.NOMBRE_C AS CLIENTE FROM BOLETA AS A, CLIENTE_1 AS B WHERE A.RUC_CLIENTE=B.RUC_DNI AND NRO_FACTURA='$nro'");
$r=mysqli_fetch_array($SQL_HORA);
$_SESSION['clie']=$r['CLIENTE'];
?>
	N° BOLETA: <?php echo $r['NRO_FACTURA'];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SERIE:001<br>
	Cliente:<?php echo $r['CLIENTE']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Dni: <?php echo $r['RUC_CLIENTE'].'<br>';?>
	Fecha de Emision: <?php echo $r['FECHA_FACTURA']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
<?php
echo "Hora:".$r['HORA_FACTURA']."<br>";
echo "************************************************";
?>

<TABLE>
	<tr>
		<td>Can.</td>
		<td>Descripción</td>
		<td style="margin-left: 65px;">P.U</td>
	</tr>
<?php
$SQL_DETALLE=mysqli_query($conexion,"SELECT SUM(CANTIDAD_PRODUCTO) AS CANTIDAD, SUM(IMPORTE) AS IMPO, COD_PRODUCTO FROM DETALLE_BOLETA WHERE NRO_FACTURA='$nro' GROUP BY COD_PRODUCTO ");
while ($ARR_DETA=mysqli_fetch_array($SQL_DETALLE))
{	$PORDUC=$ARR_DETA['COD_PRODUCTO'];
	$SQL_PRODUCTO=mysqli_query($conexion,"SELECT NOMBRE_PRODUCTO, PRECIO_VENTA FROM PRODUCTO WHERE COD_PRODUCTO='$PORDUC' ");
	$ARR_PRO=mysqli_fetch_array($SQL_PRODUCTO);
	echo '<tr><td>'.$ARR_DETA['CANTIDAD'].'</td><td>'.$ARR_PRO['NOMBRE_PRODUCTO'].'</td><td style="margin-left: 65px;">'.$ARR_PRO['PRECIO_VENTA'].'</td></tr>';
}
$SQL_FAC=mysqli_query($conexion,"SELECT * FROM BOLETA WHERE NRO_FACTURA='$nro'");
$ARR_FACTURA=mysqli_fetch_array($SQL_FAC);
echo "</TABLE>************************************************<Br>";
echo "<div class='cal'>";
echo "<p class='d'>Sub Total: S/.".$ARR_FACTURA['SUB_TOTAL']."<br>";
echo "IGV: S/.".$ARR_FACTURA['IGV']."</p>";
echo "<p class='to'>TOTAL: S/.".$ARR_FACTURA['TOTAL']."</p><br>";
echo '</div>';
?>
</div>
<div class="footer">
¡Gracias por su compra en LUIGGI'S MARKET!<br>
******************************<br>
Vuelva Pronto
</div>
<div class="bt">
<?php
$sql=mysqli_query($conexion,"SELECT * FROM BOLETA WHERE NRO_FACTURA='$nro'");
$ARR_FACTURA=mysqli_fetch_array($sql);

$_SESSION['fecha']=$ARR_FACTURA['FECHA_FACTURA'];
$_SESSION['hora']=$ARR_FACTURA['HORA_FACTURA'];
$_SESSION['dni']=$ARR_FACTURA['RUC_CLIENTE'];
echo '</div>';
?>
	<a href="pdf/imprimir.php?id=<?php echo $ARR_FACTURA['NRO_FACTURA'];?>" class='btn btn-default' target='T_Blank'><i class="fa fa-print fa-1" aria-hidden="true"> Imprimir</i></a>
</div>
</div>
</body>
</html>
