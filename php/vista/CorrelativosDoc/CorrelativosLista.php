<?php 
session_start();

?>
<style type="text/css">
	.contenedor_lista{
		padding: 15px;
	}

 
</style>
<div class="contenedor_lista">
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Correlativos Documentos</i>
	<button onclick="AgregarCorrelativos();" style="float: right;" class="btn btn-primary">Agregar Correlativos</button>
	
</div>
	<table class="table table-sm table-striped table-hover table-bordered">
		<tr>
			<th>Id</th>
			<th>Documento</th>
			<th>Serie</th>
			<th>Numero</th>
			<th colspan="4">Acciones</th>
		</tr>
		<TBody> 
		<?php 
		
			foreach ($ListaCorrelativos as $key ) {
						$Id=$key['IDCORRELATIVOS'];
					?>
				<tr>
				<td><?=$key['IDCORRELATIVOS']?></td>
				<td><?=$key['Nombre']?></td>
				<td>
				<input type="text" value='<?=$key['SERIE']?>' id='SerieCorre<?=$Id?>' onchange='CambiaSerieNum(this)' readonly='readonly' style="background-color: #ddd" ></td>
				<td>
				<input type="text" value='<?=$key['NUM']?>' id='NumCorre<?=$Id?>' onchange='CambiaSerieNum(this)' readonly='readonly'  style="background-color: #ddd"></td>
				<td>
				<i class="material-icons" id='EditCorrelativo<?=$Id?>' onclick="ActualizarCorre('<?=$Id?>');">edit</i>
				<i class="material-icons" id='SaveCorrelativo' style="display:none" onclick="UpdateCorrelativo('<?=$Id?>');">save</i>
				<i class="material-icons" id='CancelaUpdate' style="display:none"  onclick="CancelaCorrelativo('<?=$Id?>');">cancel</i>
				</td>
				</tr>

		<?php	}
		?>


		</TBody>
	</table>
</div>


<!--modal editar Agregar-->
<div  class="modal" style="width: 90%" id="ModalCorrelativos">
    <div class="modal-content" id="CuerpoCorrelativo">

    </div>
 </div>


<script type="text/javascript">
ActualizarCorre=(Id)=>
{
	console.log(Id);
     $("#SerieCorre"+Id).attr("readonly", false);
     $("#NumCorre"+Id).attr("readonly", false);
     $('#EditCorrelativo'+Id).css({'display':'none'})

	$("#SerieCorre"+Id).css({'background-color':''});
	$("#NumCorre"+Id).css({'background-color':''});
     
	 
}
CancelaCorrelativo=(Id)=>
{
    $(`#SerieCorre${Id}`).attr("readonly", true);
    $(`#NumCorre${Id}`).attr("readonly", true);

	$(`#SerieCorre${Id}`).css({'background-color':'#ddd'});
    $(`#NumCorre${Id}`).css({'background-color':'#ddd'});
     
    $('#EditCorrelativo'+Id).css({'display':'block'})
    $('#SaveCorrelativo').css({'display':'none'})
    $('#CancelaUpdate').css({'display':'none'})
}

CambiaSerieNum=()=>{
    $('#SaveCorrelativo').css({'display':'block'})
    $('#CancelaUpdate').css({'display':'block'})
}
 
UpdateCorrelativo=(Id)=>{
    $("#SerieCorre").val();
    $("#NumCorre").val();
}


 $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });


	function AgregarCorrelativos()
	{
		var peticion='agregar';
		console.log('Agregar ClienteC');
		$.ajax({
			url:"controlador/ClienteC.php",
			method:"POST",
			data : {peticion:peticion},
			success:function(resultado){
				$('#ModalProveedor').html(resultado);
				$('#modal1').modal('open');
			}

		});
	}

	function EditarCliente($codigo)
	{
		var peticion='editar';
		console.log('editar '+$codigo);
		$.ajax({
			url:'controlador/ClienteC.php',
			method:"POST",
			data:{peticion:peticion,codigo:$codigo},
			success:function(resultado)
			{
				$('#ModalProveedor').html(resultado);
				$('#modal1').modal('open');
			}
		});

	}

	function eliminar($codigo)
	{
        var Categoria='<?=$_SESSION['categoria'];?>'
		if(Categoria=='1')
        {
        console.log('eliminar '+$codigo);
		var peticion='eliminar';

		swal({
			  title: "¿Desea Eliminar este Producto?",
			  text: "Al eliminar este producto , se eliminara el stock actual \n Esto puede afectar a su inventario",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) {

			  	$.ajax({
						url:"controlador/ProveedorC.php",
						method:"POST",
						data:{peticion:peticion,codigo:$codigo},
						success: function(resultado)
						{
							Actualiza();
							//$("#contenido").html(resultado);
							swal("El archivo Se elimino Correctamente", {
							      icon: "success",
							    });
						}});

			  } else {

			  }
			});


	
    
    
    
        }

        else {

            swall('Solo el adm puede realizar esta operacion')

        }

}

	function Actualiza()
    	{
    		peticion='lista';
    		$.ajax({
    			url:'controlador/ProveedorC.php',
    			method:'POST',
    			data:{peticion:peticion},
    			success:function(respuesta)
    			{
    				 $("#contenidobody").html(respuesta);
    			}
    		});
    	}

  $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });


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

</script>
