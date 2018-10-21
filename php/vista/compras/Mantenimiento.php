<div class="container-fluid">
<h3>Mantenimiento Factura</h3>
<hr></hr>
</div>
<!--aqui se hace la tabla loquita-->
<div class="col-xs-12">
<div class="divider">
</div>
<table class="table table-bordered">
	<tr>
		<th style='line-height: 8pt;'>Factura</th>
		<th style='line-height: 8pt;'>Serie</th>
		<th style='line-height: 8pt;'>Proveedor</th>
		<th style='line-height: 8pt;'>Fecha</th>
		<th style='line-height: 8pt;'>SubTotal</th>
		<th style='line-height: 8pt;'>IGV</th>
		<th style='line-height: 8pt;'>Total</th>
		<th colspan="4" style='line-height: 8pt;'>Acciones</th>
	</tr>

<?php
	foreach ($lista_fac as $factura) 
		{
				$f=$factura['0'];
				$s=$factura['1'];
				$p=$factura['3'];
			echo "<tr>";
				echo "<td style='line-height: 8pt;'>".$factura['0']."</td>";
				echo "<td style='line-height: 8pt;'>".$factura['1']."</td>";
				echo "<td style='line-height: 8pt;'>".$factura['3']."</td>";
				echo "<td style='line-height: 8pt;'>".$factura['4']."</td>";
				echo "<td style='line-height: 8pt;'>".$factura['5']."</td>";	
				echo "<td style='line-height: 8pt;'>".$factura['6']."</td>";
				echo "<td style='line-height: 8pt;'>".$factura['7']."</td>";
				echo "<td><a href='modificar_f.php?fac=$f&serie=$s&prove=$p'>Modificar</a></td>";
				echo "<td style='line-height: 8pt;'><a href='agregar_datos/agregar_producto.php?id=$f'>Agregar</a></td>";
					?>
				<td style='line-height: 8pt;'><a href="eliminar/eliminar_factura.php?id=<?php echo $f ?>" onclick="return confirm('Desea borrar la factura <?php echo $f; ?>')">Eliminar</a></td>
				<?php
				//no utilizo este eliianar ya que al eliminar es tambien quitar los productos del almacen 
				//asi que esto no procd papu XD
				//echo "<td><a href='index.php?fac=$f&serie=$s&prove=$p'>X</a></td>";

	   		echo "</tr>";
	   }
                    
?>
</table>
</div>