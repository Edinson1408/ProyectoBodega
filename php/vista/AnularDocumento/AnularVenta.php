<?php
session_start();
?>
<div class="container-fluid" id='BodyAnular'>
		<div class="col-xs-12">
		<h3>Cancelar boleta</h3>
		<hr></hr>
		</div>
		<!--********************************************************************************-->
		<form action="buscador.php" method="POST">
		<div class='row'>
			<div class="col s3">
			  <select class="form-control input-sm" name="OptionBusqueda" id="OptionBusqueda" onchange="CambiaPlace();">
			  <option value="1">Numero Doc</option>
			  <option value="2">Serie Doc.</option>
			  <option value="3">Cliente</option>
			  <option value="4">F. Emision</option>
			  </select>
			</div>
			<div class="col s3">
			  <input type="text" class="form-control input-sm" name="buscar" id='buscar' placeholder="Nro boleta" onchange="despinta_input();">
			</div>
			<div class="col s3">
			  <a class='btn btn-primary btn-sm' onclick='BuscadorAnularVenta();'>Buscar</a>
			</div>
		</div>
			
		</form>
		
		<div class="col s12 "  >
			
			
			<table class="table table-bordered" id='CambiaContenido'>
				<thead>
					<tr>
						<th style='line-height: 6pt; width: 10px;'>Boleta</th>
						<th style='line-height: 6pt;'>Encargado</th>
						<th style='line-height: 6pt;'>Fecha</th>
						<th style='line-height: 6pt;'>Hora</th>
						<th style='line-height: 6pt;'>Total</th>
						<th style='line-height: 6pt;'>Cancelar Boleta</th>
					</tr>
					</thead>	
					<tbody id='Cambiatabla_vista'>
							<?php
								foreach ($reporteVista as $f)
								{
										echo "<tr>";
											echo "<td>".$f['IDCOMPROBANTE']."</td>";
											echo "<td>".$f['ENCARGADO']."</td>";
											echo "<td>".$f['FECHACOMPROBANTE']."</td>";
											echo "<td></td>";
											echo "<td>S/".$f['TOTAL']."</td>";
											?>
											<td style='line-height: 8pt;'><a onclick="AnularDoc('<?php echo $f['IDCOMPROBANTE'] ?>');" style='cursor: pointer;'>Cancelar</a></td>
											<?php
										echo "</tr>";

								}
							?>
					</tbody>
			</table>
		
		
		</div>
</div>
<!--href="cancelar.php?id=<?php echo $f['NRO_FACTURA'] ?>" -->
<script type="text/javascript">

	
	function AnularDoc($a)
	{
		console.log($a);
		$.ajax({
			url:"controlador/VentasC.php",
			method:'POST',
			data : {peticion:'AnularComprobante',IdComprobante:$a},
			success:function(respuesta)
			{
				console.log(respuesta)
				enrutar_menu('VentasC.php','AnularVenta')
			}

		})
	}

SeguridadAnular=($id)=>
{
	if ($id=='1')
	{}
	else
	{
		//renderizar con read
		$('#contenidobody').html('');
		Rendiza('contenidobody')
	}
	
	
}

SeguridadAnular('<?=$_SESSION['categoria']?>')

CambiaPlace=()=>
	{
		var ValorXd=$('#OptionBusqueda').val();
		console.log(ValorXd)
			switch (ValorXd) {
				case '1':
				$('#buscar').attr("placeholder", "Nro Documento");
					break;
				case '2':
				$('#buscar').attr("placeholder", "Nro Serie");
					break;
				case '3':
				$('#buscar').attr("placeholder", "Nombre Cliente");
					break;
				case '4':
				$('#buscar').attr("placeholder", "Fecha Emision");
					break;
				default:
					break;
			}
	}


BuscadorAnularVenta=()=>
{
	var IdBusqueda=$('#OptionBusqueda').val();
	var Busqueda=$('#buscar').val();
	var busquedaF='';
	if($('#buscar').val()=='')
	{
		swal('Pro favor llene el campo solicitado');
		$('#buscar').css({'border-color':'red'});
		
	}
	else
	{
		$.ajax({
				url:'controlador/VentasC.php',
				type:'POST',
				data:{'peticion':'AnularComprobanteBusqueda','IdBusqueda':IdBusqueda,'Busqueda':Busqueda,'busquedaF':busquedaF},
				success:function(respuesta)
				{	
					console.log(respuesta)
					$('#Cambiatabla_vista').empty();
					$('#Cambiatabla_vista').html(respuesta);
					
					
				}

			});
	}
	
}


despinta_input=()=>{
	$('#buscar').css({'border-color':''});
}
</script>