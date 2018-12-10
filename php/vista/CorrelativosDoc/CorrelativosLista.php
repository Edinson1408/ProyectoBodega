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
	<!--<button onclick="Agregar();" style="float: right;" class="btn btn-primary">Agregar Cliente</button>-->
	
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
        <tr>
        <td></td>
        <td></td>
        <td><input type="text" id='SerieCorre' onchange='CambiaSerieNum(this)' readonly='readonly'></td>
        <td><input type="text" id='NumCorre' onchange='CambiaSerieNum(this)' readonly='readonly'></td>
        <td>
        <i class="material-icons" id='EditCorrelativo' onclick='ActualizarCorre();'>edit</i>
        <i class="material-icons" id='SaveCorrelativo' style="display:none" onclick='UpdateCorrelativo();'>save</i>
        <i class="material-icons" id='CancelaUpdate' style="display:none"  onclick='CancelaCorrelativo();'>cancel</i>
        </td>
        </tr>
		<?php
			// foreach ($Proveedores as $r)
			// {
			// 	echo "<tr>";
			// 		echo "<td>".$r['NUMDOC']."</td>";
			// 		echo "<td >".$r['RAZONSOCIAL']."</td>";
			// 		echo "<td class='hidden-sm-down'> ".$r['TELEFONO']."</td>";
			// 		echo "<td class='hidden-sm-down'>".$r['CELULAR']."</td>";
			// 		echo "<td class='hidden-sm-down'>".$r['CORREO']."</td>";
			// 		echo "<td><a title='Editar' onclick=(EditarCliente('".$r['IDPERSONA']."')) style='cursor:pointer;'>
			// 		<i class='material-icons'>edit</i></a></td>
			// 		<td><a title='Eliminar' style='cursor:pointer;' onclick=(eliminar('".$r['IDPERSONA']."'))><i class='material-icons'>delete</i></a></td>";

			//   echo "</tr>";
			// }
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
ActualizarCorre=()=>
{
     $("#SerieCorre").attr("readonly", false);
     $("#NumCorre").attr("readonly", false);
     $('#EditCorrelativo').css({'display':'none'})
}
CancelaCorrelativo=()=>
{
    $("#SerieCorre").attr("readonly", true);
    $("#NumCorre").attr("readonly", true);
     
    $('#EditCorrelativo').css({'display':'block'})
    $('#SaveCorrelativo').css({'display':'none'})
    $('#CancelaUpdate').css({'display':'none'})
}

CambiaSerieNum=()=>{
    $('#SaveCorrelativo').css({'display':'block'})
    $('#CancelaUpdate').css({'display':'block'})
}
 
UpdateCorrelativo=()=>{
    $("#SerieCorre").val();
    $("#NumCorre").val();
}


 $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });


	function Agregar()
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

</script>
