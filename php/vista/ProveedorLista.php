<style type="text/css">
	.contenedor_lista{
		padding: 15px;
	}


</style>

<div class="contenedor_lista">
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Proveedores</i>
	<button onclick="Agregar();" style="float: right;" class="btn btn-primary">Agregar Proveedor</button>
	<form action="proveedor.php" method="POST">
	<!--div class="input-group">
    <input type="text" name="buscar" class="form-control" style="float: right; right:10px; width: 30%;  bottom: 28px;">
    <span class="input-group-btn">
    <input type="submit" name="enviar" class="btn btn-default" style="bottom: 28px; right:10px;" value="Buscar">
    </span>
    </div-->
    </form>
</div>
	<table class="table table-sm table-striped table-hover table-bordered">
		<tr>
			<th>RUC-DNI</th>
			<th>Proveedor</th>
			<th class='hidden-sm-down'>N°Ejecutivo</th>
			<th class='hidden-sm-down'>Nombre_Ejecutivo</th>
			<th class="hidden-sm-down">Dirección</th>
			<th class='hidden-sm-down' >Telefono</th>
			<th class='hidden-sm-down'>Correo</th>
			<th colspan="4">Acciones</th>
		</tr>
		<?php
		///include('../../seguridad1.php');
			//include('../../../conexion.php');
			/*error_reporting(0);
			$buscar=$_POST['buscar'];
			if (isset($_POST['enviar'])) {
			$sql_pro=mysql_query("SELECT * FROM cliente where NOMBRE_CLIENTE '$buscar'",$conexion);
			while ($r=mysql_fetch_array($sql_pro)) {
				echo "<tr>";
					echo "<td>".$r['RUC_CLIENTE']."</td>";
					echo "<td>".$r['NOMBRE_CLIENTE']."</td>";
					echo "<td>".$r['NUM_EJE']."</td>";
					echo "<td>".$r['NOM_EJE']."</td>";
					echo "<td>".$r['DIRECCION_CLIENTE']."</td>";
					echo "<td>".$r['TELEFONO_CLIENTE']."</td>";
					echo "<td>".$r['CORREO_CLIENTE']."</td>";
			?>
			  <td><a href="modificar.php?id=<?php echo $r['RUC_CLIENTE'];?>" class="btn btn-default btn-xs" title="Editar Proveedor"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i></a></td>
			  <td><a href="eliminar.php?id=<?php echo $r['RUC_CLIENTE'];?>" class="btn btn-default btn-xs" title="Eliminar Proveedor"><i class="glyphicon glyphicon-remove-circle" aria-hidden="true"></i></a></td>
			<?php
			  echo "</tr>";
			}
			}*/
			//if (!isset($_POST['enviar'])) {
			//$sql_pro=mysql_query("SELECT * FROM cliente order by NOMBRE_CLIENTE ASC",$conexion);
			//while ($r=mysql_fetch_array($sql_pro)) {
			foreach ($Proveedores as $r)
			{
				echo "<tr>";
					echo "<td>".$r['RUC_CLIENTE']."</td>";
					echo "<td >".$r['NOMBRE_CLIENTE']."</td>";
					echo "<td class='hidden-sm-down'> ".$r['NUM_EJE']."</td>";
					echo "<td class='hidden-sm-down'>".$r['NOM_EJE']."</td>";
					echo "<td class='hidden-sm-down'>".$r['DIRECCION_CLIENTE']."</td>";
					echo "<td class='hidden-sm-down'>".$r['TELEFONO_CLIENTE']."</td>";
					echo "<td class='hidden-sm-down'>".$r['CORREO_CLIENTE']."</td>";
					echo "<td><a title='Editar' onclick=(editar('".$r['RUC_CLIENTE']."')) style='cursor:pointer;'>
					<i class='material-icons'>edit</i></a></td>
					<td><a title='Eliminar' style='cursor:pointer;' onclick=(eliminar('".$r['RUC_CLIENTE']."'))><i class='material-icons'>delete</i></a></td>";

			  echo "</tr>";
			}
			//}
		?>
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
		console.log('Agregar ProveedorC');
		$.ajax({
			url:"controlador/ProveedorC.php",
			method:"POST",
			data : {peticion:peticion},
			success:function(resultado){
				$('#ModalProveedor').html(resultado);
				$('#modal1').modal('open');
			}

		});
	}

	function editar($codigo)
	{
		var peticion='editar';
		console.log('editar '+$codigo);
		$.ajax({
			url:'controlador/ProveedorC.php',
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
						url:"controlador/ProductoC.php",
						method:"POST",
						data:{peticion:peticion,codigo:$codigo},
						success: function(resultado)
						{
							$("#contenido").html(resultado);
							swal("El archivo Se elimino Correctamente", {
							      icon: "success",
							    });
						}});

			  } else {

			  }
			});


	}


  $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });

</script>
