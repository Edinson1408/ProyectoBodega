<h4><?php echo $tituloModal;?></h4>


 <div class="row">
 	<div class="col l6 s12">
 			<div class="form-group">
     		 <input class="form-control input-lg " id="CodProducto" type="text" name="CodProducto" placeholder="Codigo Producto" <?php echo ($CodProducto=='')?'':'readonly'; ?> value='<?php echo $CodProducto;?>'>
			</div>
 	</div>
     <div class="col l6 s12">
     		<div class="form-group">
     		 <input class="form-control input-lg" id="NomProducto" name="NomProducto" type="text" placeholder="Nombre Producto" value="<?php echo $NomProducto;?>">
			</div>
     </div>
 </div>

 <div class="row">
	 <div class="col l6 s12">
	 	<div class="form-group">
	 		<input class="form-control" type="number" name="PrecioUnitario" id="PrecioUnitario" placeholder="Precio Unitario"  value="<?php echo $PU;?>">
	 	</div>
	 </div>
	 <div class="col l6 s12">
	 	<div class="form-group">
	 		<input type="number"  class="form-control" placeholder="Precio Venta" name="PrecioVenta" id="PrecioVenta"  value="<?php echo $PV;?>">
	 	</div>
	 </div>
 </div>

 <div class="row">
 	<div class="col l6 s12">
 		<div class="form-group">
 			<select class="form-control" name="TipoProducto" id="TipoProducto">
 				<?php
 						if ($oculto=='1') {
 							echo '<option value="0">Tipo Producto</option>';
 						}elseif ($oculto=='2') {
 							echo '<option value="'.$CodmTipo.'">'.$NomTipo.'</option>';
 						}
 				?>

 				<?php
 						foreach ($TipoProducto as $TipoPro)
						{
								echo "<option value='".$TipoPro['COD_CLASIFICACION']."'>".$TipoPro['CLASE_PRODUCTO']."</option>";
						}

 				?>
 			</select>
 		</div>
 	</div>
 </div>
 <input type="text" name="CampoOculto" id="CampoOculto" value="<?php echo $oculto;?>" style='visibility: hidden;'>

 <a style="float: right;" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
 <a style="float: right;" href="#!" class="modal-action  waves-effect waves-green btn-flat" onclick="Guardar_Producto();">Guardar</a>


    <script type="text/javascript">
    	function Guardar_Producto()
    	{
    		console.log($('#CodProducto').val());
    		console.log($('#NomProducto').val());
    		console.log($('#PrecioUnitario').val());
    		console.log($('#PrecioVenta').val());
    		console.log($('#TipoProducto').val());
    		console.log($('#CampoOculto').val());

    		//campo con el cual validaremos  si es un update o un insert
    		var CampoOculto=$('#CampoOculto').val();
    		var CodProducto=$('#CodProducto').val();
    		var NomProducto=$('#NomProducto').val()
    		var PrecioUnitario=$('#PrecioUnitario').val();
    		var PrecioVenta=$('#PrecioVenta').val();
    		var TipoProducto=$('#TipoProducto').val();

    		if (CodProducto=='' ) {
    			$('#CodProducto').addClass('border-danger');
    		}else {

    		peticion='insertar'
    		$.ajax({
    			url:'controlador/ProductoC.php',
    			method:'POST',
    			data:{CampoOculto:CampoOculto,peticion:peticion,CodProducto:CodProducto,NomProducto:NomProducto,PrecioUnitario:PrecioUnitario,PrecioVenta:PrecioVenta,TipoProducto:TipoProducto},
    			success:function(respuesta)
    			{
    				console.log(respuesta);
    				$('#modal1').modal('close');
    				Actualiza();
    			}
    		});
    		}

    	}


    	function Actualiza()
    	{
    		peticion='lista';
    		$.ajax({
    			url:'controlador/ProductoC.php',
    			method:'POST',
    			data:{peticion:peticion},
    			success:function(respuesta)
    			{
    				 $("#contenido").html(respuesta);
    			}
    		});
    	}

    </script>
