<meta charset="utf-8">
<style type="text/css">
	th, tr{
		text-align: center;
	}
</style>
<table class="table table-bordered" >
	<tr>
		<th>N°Serie</th>
		<th>Doc.</th>
		<th>Turno</th>
		<th>Encargado</th>
		<th>Fecha</th>
		<th>Cliente</th>
		<th>Sub_total</th>
		<th>IGV</th>
		<th>Total</th>
		<!--th colspan="2">Acciones</th-->
	<?php
		session_start();
		
		

		$meses = array(1 =>'Enero', 2 =>'Febrero',3 =>'Marzo' ,4 =>'Abril',5 =>'Mayo',6 =>'Junio',7 =>'Julio',8 =>'Agosto',9 =>'Septiembre',10 =>'octubre',11 =>'Noviembre',12 =>'Diciembre' );
            $t= $meses[$mes];	
		foreach ($ListaHistorial as $f ) {
			
		
			echo "<tr>";
				echo "<td>".$f['SERIECOMPROBANTE']."</td>";
				echo "<td>".$f['NUMCOMPROBANTE']."</td>";
				echo "<td>".$f['NOMTURNO']."</td>";
				echo "<td>".$f['ENCARGADO']."</td>";
				echo "<td>".$f['FECHACOMPROBANTE']."</td>";
				echo "<td>".$f['NOMCLIENTE']."</td>";
				echo "<td>".$f['SUBTOTAL']."</td>";
				echo "<td>".$f['IGV']."</td>";
				echo "<td>".$f['TOTAL']."</td>";

				/*<td><a href="pdf_reporte/boleta_pdf.php?id=<?php echo $f['NRO_FACTURA'];?>" target="T_BLANK" class="btn btn-success btn-xs" title="Imprimir Boleta"><i class="glyphicon glyphicon-save" aria-hidden="true"></i></a></td>*/
			echo "</tr>";
		
		}
		
	?>
	</tr>
</table>
