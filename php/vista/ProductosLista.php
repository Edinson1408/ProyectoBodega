
<head>


	<style type="text/css">
	.contenedor_lista{
		padding: 15px;
	}
	.nota{
		padding-top: 10px;
		height: 50px;
		border-bottom: 3px solid #337ab7;
	}
	#com{
		font-size: 2em;
	}
	#contenedor
	{
	overflow-y:scroll;
    height:500px;

	}


	/*.tableFixHead { overflow-y: auto; height: auto; }*/

table { border-collapse: collapse; width: 100%; }
/* td { padding: 0px 0px; }*/
th { background:#eee; }

	</style>
</head>
<body>
<!--<div class="container">-->
<div class="contenedor_lista">
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Productos</i>
	<button onclick="Agregar();" style="float: right;" class="btn btn-primary">
	AgregarProducto
	</button>
	<button onclick="AgregarTipoProducto();" style="float: right;" class="btn btn-primary">
	Agregar Clasificacion
	</button>
	<div class="input-field col s6">
		<!--<input type="text" name="caja_busquedad" id="caja_busquedad" placeholder="Buscar">-->
          	<div class="form-group">
     		 <input class="form-control input-lg" id="inputlg" type="text" placeholder="Buscar">
			</div>
    </div>

</div>


<br><br><br>
<div id="row">

<div class="table table-sm table-striped table-hover table-bordered tableFixHead" id="contenedor">
  <table>
    <thead>
      <tr>
      	<th>Tipo</th>
		<th>Producto</th>
		<th>PRECIO V.</th>
		<th >PRECIO C.</th>
		<th colspan='4'>Acciones</th>
	</tr>
    </thead>
    <tbody id="contenedor1">

    </tbody>
  </table>
</div>





</div>

<!--modal editar Agregar-->
<div id="modal1" class="modal" style="width: 90%">
    <div class="modal-content" id="ModalProducto">
    </div>
</div>
<!--<script src="jquery-3.2.1.min.js"></script>-->
<!--<script src="main.js"></script>-->
<script type="text/javascript">

AgregarTipoProducto=()=>
{
	let peticion='AgregarTipoP';
	console.log('Agrrgar tipo de producto');
	$.ajax({
			url:"controlador/ProductoC.php",
			method:"POST",
			data : {peticion:peticion},
			success:function(resultado){
				$('#ModalProducto').html(resultado);
				$('#modal1').modal('open');
			}

		});

}



$('.tableFixHead').on('scroll', function() {
  $('thead', this).css('transform', 'translateY('+ this.scrollTop +'px)');
});

	function Agregar()
	{
		var peticion='agregar';
		console.log('Agregar Productos');
		$.ajax({
			url:"controlador/ProductoC.php",
			method:"POST",
			data : {peticion:peticion},
			success:function(resultado){
				$('#ModalProducto').html(resultado);
				$('#modal1').modal('open');
			}

		});
	}

	function editar($codigo)
	{
		var peticion='editar';
		console.log('editar '+$codigo);
		$.ajax({
			url:'controlador/ProductoC.php',
			method:"POST",
			data:{peticion:peticion,codigo:$codigo},
			success:function(resultado)
			{
				$('#ModalProducto').html(resultado);
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

<script>
{
    "use strict";
    let start_page = 0;
    const scope = $("#contenedor1");
    this.load = function(start) {
        $.get("vista/api/LoadProductos.php?get", { start: start }, function(response) {
            scope.append(response);
            start_page += 5;
        });
    };
    const win = $("#contenedor");
    console.log(win);
    win.scroll(() => {
    	console.log({scrollHeight:win.prop("scrollHeight"),scrollTop:win.prop("scrollTop"),winheight:win.height()})
        if (win.prop("scrollHeight")-Math.round(win.prop("scrollTop")) == win.height()) {
        	console.log(win.height());
            this.load(start_page);
        }
    });
    this.load();
}
</script>


</body>
</html>
