<h4><?php echo $tituloModal;?></h4>
<form id='FormTipoProducto'>

 <div class="row">
 	<div class="col l6 s12">
 			<div class="form-group">
     		 <input class="form-control input-lg " id="CodTipo" type="text" name="CodTipo" 
			  placeholder="Codigo Tipo Producto">
			</div>
 	</div>
     <div class="col l6 s12">
     		<div class="form-group">
     		 <input class="form-control input-lg" id="NomTipo" name="NomTipo" type="text" 
			  placeholder="Nombre Tipo Producto" >
			</div>
     </div>
 </div>

 <div class="row">
	 <div class="col l6 s12">
	 	<div class="form-group">
	 		<input class="form-control" type="text" name="Icono" id="Icono" 
			 placeholder="Icono" >
	 	</div>
	 </div>
	 <div class="col l2 s6">
	 	<div class="form-group">
	 		<input type="color"  class="form-control"  name="color" id="color" >
	 	</div>
	 </div>
 </div>
 </form>


 <a style="float: right;" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
 <a style="float: right;" href="#!" class="modal-action  waves-effect waves-green btn-flat" onclick="GuardarTipoProducto();">Guardar</a>


    <script type="text/javascript">
    	function GuardarTipoProducto()
    	{
    
    		$.ajax({
    			url:'controlador/ProductoC.php',
    			method:'POST',
    			data:$('#FormTipoProducto').serialize()+'&peticion=InsertarTipo',
    			success:function(respuesta)
    			{
    				console.log(respuesta);
    				 $('#modal1').modal('close');
    				// Actualiza();
    			}
    		});
    		

    	}



    </script>
