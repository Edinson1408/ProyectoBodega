<style type="text/css">
	.contenedor_lista{
		padding: 15px;
	}


</style>

<div class="contenedor_lista">
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Usuarios</i>
	<button onclick="AgregarUsuario();" style="float: right;" class="btn btn-primary">Agregar Usuario</button>
</div>
	<table class="table table-sm table-striped table-hover table-bordered">
		<tr>
			<th>DNI</th>
			<th>Nombres</th>
			<th class='hidden-sm-down'>Usuario</th>
			<th class="hidden-sm-down">Nivel</th>
			<th class='hidden-sm-down'>Turno</th>
			<th colspan="4">Acciones</th>
		</tr>
		<TBody id='TablaProveedores'> 
		<?php
			foreach ($Usuarios as $r)
			{
				echo "<tr>";
					echo "<td>".$r['NUMDOC']."</td>";
					echo "<td >".$r['NOMBRES']."</td>";
					echo "<td class='hidden-sm-down'> ".$r['NOMUSER']."</td>";
					echo "<td class='hidden-sm-down'>".$r['IDCATEGORIA']."</td>";
					echo "<td class='hidden-sm-down'>".utf8_encode($r['NOMTURNO'])."</td>";
					echo "<td><a title='Editar' onclick=(EditarUsuario('".$r['IDPERSONA']."')) style='cursor:pointer;'>
					<i class='material-icons'>edit</i></a></td>
					<td><a title='Eliminar' style='cursor:pointer;' onclick=(eliminar('".$r['IDPERSONA']."'))><i class='material-icons'>delete</i></a></td>";

			  echo "</tr>";
			}
		?>
		</TBody>
	</table>
</div>


<!--modal editar Agregar-->
<div id="modal1" class="modal" style="width: 90%">
    <div class="modal-content" id="ModalProveedor">

    </div>
 </div>


<script type="text/javascript">
 $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });


	function AgregarUsuario()
	{
		var peticion='Agregar';
		console.log('Agregar usuariosC');
		$.ajax({
			url:"controlador/UsuarioC.php",
			method:"POST",
			data : {peticion:peticion},
			success:function(resultado){
				$('#ModalProveedor').html(resultado);
				$('#modal1').modal('open');
			}

		});
	}

	function EditarUsuario($codigo)
	{

		var peticion='Editar';
		console.log('editar '+$codigo);
		$.ajax({
			url:'controlador/UsuarioC.php',
			method:"POST",
			data:{peticion:peticion,IdPersona:$codigo},
			success:function(resultado)
			{
				$('#ModalProveedor').html(resultado);
				$('#modal1').modal('open');
			}
		});

	}

	function eliminar($codigo)
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
