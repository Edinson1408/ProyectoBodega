<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<style type="text/css">
		blockquote{
			border-left: 5px solid #b54848;
		}
		.cotainer{
			width: 80%;
		}
		.btn{
			border-radius: 0;
		}
	</style>
</head>
<body>
<div class="container">
<table class="table table-bordered" >
	<tr>
		<th>Boleta</th>
		<th>N°Serie</th>
		<th>Turno</th>
		<th>Encargado</th>
		<th>Fecha</th>
		<th>Cliente</th>
		<th>Estado</th>
		<th>Sub_total</th>
		<th>IGV</th>
		<th>Total</th>
		<th colspan="2">Acciones</th>
	<?php
		include("../../conexion.php");
		session_start();
		$mes=$_POST['mes'];
		$año=$_POST['año'];
		//sessiones
		$_SESSION['mes']=$_POST['mes'];
		$_SESSION['ano']=$_POST['año'];
		$meses = array(1 =>'Enero', 2 =>'Febrero',3 =>'Marzo' ,4 =>'Abril',5 =>'Mayo',6 =>'Junio',7 =>'Julio',8 =>'Agosto',9 =>'Septiembre',10 =>'octubre',11 =>'Noviembre',12 =>'Diciembre' );
            $t= $meses[$mes];
			echo "<BLOCKQUOTE>";
			echo "<h3>Ingresos de Ventas </h3><br>";
			echo "Mes de ".$t."<br>";
			echo "Año ".$año."";
			echo "</BLOCKQUOTE>";
            echo '<a href="salidav2.php" class="btn btn-primary" style="float: right;"><i class="glyphicon glyphicon-new-window">NuevoDocumento</i></a>';
            echo '<a href="pdf_reporte/lista_ventas_pdf.php" target="T_BLANK" class="btn btn-danger" style="float: left;"><i class="glyphicon glyphicon-download-alt">DescargarVentas-PDF</i></a>';
            echo '<a href="excel/lista_ventas_excel.php" target="T_BLANK" class="btn btn-success" style="float: left;"><i class="glyphicon glyphicon-download-alt">DescargarVentas-EXCEL</i></a>';
            echo '<a href="excel/movimiento_excel.php" target="T_BLANK" class="btn btn-success" style="float: left;"><i class="glyphicon glyphicon-download-alt">MovimientosDeCompras-EXCEL</i></a>';
		$consulta=mysqli_query($conexion,"SELECT a.*,b.NOMBRE_C AS NOMBRE,c.DES_TUR AS TURNO, d.NOMBRE_ESTADO AS ES FROM  boleta as a, cliente_1 as b, turno as c, estado as d WHERE a.RUC_CLIENTE=b.RUC_DNI AND a.ID_TURNO=c.ID_TURNO AND a.ESTADO=d.ID_ESTADO AND MONTH(a.FECHA_FACTURA)='$mes' and  YEAR(a.FECHA_FACTURA)='$año' ");
		if (isset($_POST['enviar'])) {
		while ($f=mysqli_fetch_array($consulta)) {
			echo "<tr>";
				echo "<td>".$f['NRO_FACTURA']."</td>";
				echo "<td>".$f['SERIE_FACTURA']."</td>";
				echo "<td>".$f['TURNO']."</td>";
				echo "<td>".$f['ENCARGADO']."</td>";
				echo "<td>".$f['FECHA_FACTURA']."</td>";
				echo "<td>".$f['NOMBRE']."</td>";
				echo "<td>".$f['ES']."</td>";
				echo "<td>".$f['SUB_TOTAL']."</td>";
				echo "<td>".$f['IGV']."</td>";
				echo "<td>".$f['TOTAL']."</td>";

		?>
				<td><a onclick="window.open('movimiento_bol.php?ID=<?php echo $f['NRO_FACTURA'];?>','ventana','width=640,height=480,left=350,top=150,scrollbars=NO,menubar=NO,resizable=NO,titlebar=NO,status=NO')";return false   class="btn btn-default btn-xs" title="Detalle Boleta"><i class="glyphicon glyphicon-list" ></i></a></td>
				<!--td><a href="#" class="btn btn-default btn-xs" title="Editar Factura"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i></a></td>
				<td><a href="#" class="btn btn-default btn-xs" title="Eliminar Factura"><i class="glyphicon glyphicon-remove-circle" aria-hidden="true"></i></a></td-->
				<td><a href="pdf_reporte/boleta_pdf.php?id=<?php echo $f['NRO_FACTURA'];?>" target="T_BLANK" class="btn btn-default btn-xs" title="Imprimir Boleta"><i class="glyphicon glyphicon-save" aria-hidden="true"></i></a></td>
		<?php
			echo "</tr>";
		}
		}
	?>
	</tr>
</table>
</div>
	<script src='../../js/jquery-3.2.1.min.js'></script>
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../bootstrap/js/bootstrap.js"></script>
</html>