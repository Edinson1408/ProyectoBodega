<style type="text/css">
	.contenedor_lista{
		padding: 15px;
	}


</style>

<div class="contenedor_lista">
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Cliente</i>
	<button onclick="Agregar();" style="float: right;" class="btn btn-primary">Agregar Cliente</button>
	<form action="proveedor.php" method="POST">
	
    </form>
</div>
	<table class="table table-sm table-striped table-hover table-bordered">
		<tr>
			<th>RUC-DNI</th>
			<th>Proveedor</th>
			<th class='hidden-sm-down'>Telefono</th>
			<th class='hidden-sm-down'>Celular</th>
			<th class="hidden-sm-down">Dirección</th>
			<th class='hidden-sm-down'>Correo</th>
			<th colspan="4">Acciones</th>
		</tr>
		<TBody id='TablaProveedores'> 
		<?php
			foreach ($Proveedores as $r)
			{
				echo "<tr>";
					echo "<td>".$r['NUMDOC']."</td>";
					echo "<td >".$r['RAZONSOCIAL']."</td>";
					echo "<td class='hidden-sm-down'> ".$r['TELEFONO']."</td>";
					echo "<td class='hidden-sm-down'>".$r['CELULAR']."</td>";
					echo "<td class='hidden-sm-down'>".$r['CORREO']."</td>";
					echo "<td><a title='Editar' onclick=(EditarCliente('".$r['IDPERSONA']."')) style='cursor:pointer;'>
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
