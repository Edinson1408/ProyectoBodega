<div class="container-fluid">
		<div class="col-xs-12">
		<h3>Cancelar boleta</h3>
		<hr></hr>
		</div>
		<!--********************************************************************************-->
		<form action="buscador.php" method="POST">
			<div class="col-xs-3">
			  <input type="text" class="form-control input-sm" name="buscar" placeholder="Nro boleta" aria-label="Recipient's username" aria-describedby="basic-addon2">
			</div>
			<div class="col-xs-4">
			  <input type="submit" name="enviar" class="btn btn-primary btn-sm" value="Buscar">
			</div>
		</form>
		<!--********************************************************************************-->
		<div class="col-xs-12">
			<div class="divider">
			</div>
			<table class="table table-bordered">
				<tr>
					<th style='line-height: 6pt; width: 10px;'>Boleta</th>
					<th style='line-height: 6pt;'>Encargado</th>
					<th style='line-height: 6pt;'>Fecha</th>
					<th style='line-height: 6pt;'>Hora</th>
					<th style='line-height: 6pt;'>Total</th>
					<th style='line-height: 6pt;'>Cancelar Boleta</th>
				</tr>
				<tbody>
					 	<?php
					      	foreach ($reporteVista as $f)
					        {
					        		echo "<tr>";
					        			echo "<td>".$f['NRO_FACTURA']."</td>";
					        			echo "<td>".$f['ENCARGADO']."</td>";
					        			echo "<td>".$f['FECHA_FACTURA']."</td>";
					        			echo "<td>".$f['HORA_FACTURA']."</td>";
					        			echo "<td>S/".$f['TOTAL']."</td>";
					        			?>
										<td style='line-height: 8pt;'><a onclick="AnularDoc('<?php echo $f['NRO_FACTURA'] ?>');" style='cursor: pointer;'>Cancelar</a></td>
										<?php
					        		echo "</tr>";

					      	}
					    ?>
				</tbody>
			</table>
		<!--********************************************************************************-->
		</div>
</div>
<!--href="cancelar.php?id=<?php echo $f['NRO_FACTURA'] ?>" -->
<script type="text/javascript">
	function AnularDoc($a)
	{
		console.log($a);
	}

</script>