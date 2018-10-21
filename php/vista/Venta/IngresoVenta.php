<?php
//hay que hacer las validaciones de los vacios
include("../../conexion.php");
?>

	<!-- <script type="text/javascript" src='../php/ingreso_ventas/js/verifica_1.js'></script> -->
		<!-- <style type="text/css">
		html{
			padding: 15px;
		}
		.btn{
			margin-top: 18px;
		}
		.container{
			width: 100%;
			padding: 10px;
		}
		#com{
			font-size: 2em;
		}
		.nota{
			padding-top: 10px;
			height: 50px;
			border-bottom: 3px solid #337ab7;
		}
		.form-control{
			border-radius: 0px;
		}
	</style> -->
	<script>
function sf(ID){
document.getElementById(ID).focus();
}
</script>
</head>

</head>
<body onload="sf('btn');">
<?php
//NUEVO CODIGO DE BOLETA 
// function gen_id()
// {
// include('../../conexion.php');
// $cod1=mysqli_query($conexion,"SELECT max(NRO_FACTURA+1) AS ID FROM BOLETA WHERE PROCESO='2'");
// $r2=mysqli_fetch_array($cod1);
// return $r2['ID'];
// }
// $VAR_NUEVA_BOLETA=gen_id();
?>
<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Agregar nueva venta</i>
	<a href="salidav2.php" class="btn btn-default" style="float: right;">Nueva venta</a>
</div>

<div class="form-group">
	<br><br><br>
	<div class="row">
		<div class="col l4 m4 s12">
			fecha : <input type="date" class="form-control form-control-sm" name="" value="<?php date_default_timezone_set('America/Bogota'); echo date('Y-m-d')?>" id="fe">
		</div>
		<div class="col l4 m4 s12">
			Tipo Documento:	
			<select class="form-control form-control-sm" id="doc" disabled>
			<option>BOLETA</option>
			</select>
		</div>

		<div class="col l4 m4 s12">
			Nro Documento: <input type="text" name="" data_name='asd' onchange="VerificaDoc(this)" class="form-control form-control-sm" id="nro_bol" value="<?php echo $MaxId; ?>">
		</div>
		
	</div>
	
<div class="row">
	
	<div class="col l4 m6 s12">
		<?php
			$SQL_CLIENTE=mysqli_query($conexion,"SELECT * FROM CLIENTE_1  ORDER BY RUC_DNI DESC ");
		$ARR_CLI=mysqli_fetch_array($SQL_CLIENTE)
		?>
		Cliente: <input list="cliente" id="clie" class="form-control form-control-sm" name="" value="<?php echo $ARR_CLI['RUC_DNI'];?>">
							<datalist id="cliente">
							  <?php
							  	$SQL_CLIENTE=mysqli_query($conexion,"SELECT * FROM CLIENTE_1");
							  	while ($ARR_CLI=mysqli_fetch_array($SQL_CLIENTE)) {
							  		echo "<option value='".$ARR_CLI['RUC_DNI']."'>".$ARR_CLI['NOMBRE_C']."</option>";
							  	}
							  ?>
							</datalist>
	</div>
	<div class="col l4 m6 s12">
			Nombre Cliente:	
			<input type="text" name="" class="form-control form-control-sm" disabled="disable">
	</div>
	<div class="col l4 m6 s12">
	<?php
	$SQL_PAGO=mysqli_query($conexion,"SELECT * FROM ESTADO  ORDER BY ID_ESTADO ASC ");
	$ARR_CLI=mysqli_fetch_array($SQL_PAGO)
	?>
	Pago:<select class="form-control input-sm" id="pago" >
					<option value="<?php echo $ARR_CLI['ID_ESTADO'];?>"><?php echo $ARR_CLI['NOMBRE_ESTADO'];?></option>
					<?php
					$sql_estado=mysqli_query($conexion,"SELECT * FROM estado");
					while ($r=mysqli_fetch_array($sql_estado)) {
						echo "<option value='".$r['ID_ESTADO']."'>".$r['NOMBRE_ESTADO']."</option>";
					}
					?>
					</select>
	</div>
</div>


<div class="row">
	<div class="col l6 m6 s12">
	
		<div class="switch">
		    <label>
		      Manual
		      <input type="checkbox" id="CheckAutomatico" onchange="Automatico(this)">
		      <span class="lever"></span>
		      Automatico
		    </label>
	 	 </div>
	</div>
	<div class="col l6 m6 s12">

		<input type="text" name="CodigoBarras" class="form-control form-control-sm" id='CodigoBarras'  style="display: none" autocomplete="off">
		<div id="suggesstion-box"></div>
	<div>
</div>
	



<div id="div_ajax">
</div>
</div>
<div class="row">
	<table class="table">
	<thead>
		<tr>
			<td>Codigo</td>
			<td>Nombre</td>
			<td>Cantidad</td>
			<td>Precio</td>
		</tr>
	</thead>
	<tbody id='ContenidoGrilla'>
		

	</tbody>
	</table>
	
</div>


<script>

//identificamos si esta en manual o automatico
function Automatico(a)
{
	var CheckAutomatico=$(a).prop('checked');
	(CheckAutomatico==true)? $('#CodigoBarras').css('display','block'):$('#CodigoBarras').css('display','none');
	
}
 

	     // funcion que se ejecuta cada vez que se selecciona una empresa

function VerificaDoc(a){
		let NumDoc=a.value;
		let nclie=$("#clie").val();
		let nfec=$("#fe").val();
		let NumBoleta=$("#nro_bol").val();
		let estado=$("#pago").val();
		let  url="Ingreso_ventas/mostar_detalle.php";

		$.ajax({
				url:url,
				type:"post",
				data:{documento:NumDoc,cliente:nclie,fecha:nfec,boleta:NumBoleta,nestado:estado},
				success:function(respuesta){
					console.log(respuesta);
					$("#div_ajax").html(respuesta);
				}
			});


}

function verificar(){

let  url="Ingreso_ventas/mostar_detalle.php";
	var ndoc=document.getElementById("doc").value;
	var nclie=document.getElementById("clie").value;
	var nfec=document.getElementById("fe").value;
	var nnumero_boleta=document.getElementById("nro_bol").value;
	var estado=document.getElementById("pago").value;
	
	

	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{documento:ndoc,cliente:nclie,fecha:nfec,boleta:nnumero_boleta,nestado:estado},

				success:function(datos){
					$("#div_ajax").html(datos);
				}
			}

		)
}


     // funcion que se ejecuta cada vez que se selecciona una empresa
function agregar_clie(){
	var nruc=document.getElementById("ruc").value;
	var ncliente=document.getElementById("nombre").value;
	var ndire=document.getElementById("dir").value;
	var ntel=document.getElementById("tel").value;
	var nemail=document.getElementById("email").value;


	var boton=document.getElementById("enviar").value;
	
	var url="mostar_detalle.php";

	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{btn:boton,ruc:nruc,cliente:ncliente,direccion:ndire,telefono:ntel,email:nemail},

				success:function(datos){
					$("#div_ajax").html(datos);
				}
			}

		)
}




function ingreso_almacen(){
	var nfactura=document.getElementById("factura").value;
	var nproducto=document.getElementById("producto").value;
	var ncantidad=document.getElementById("cantidad").value;
	var url="mostrar_detalle.php";

	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{num_fac:nfactura,cod_pro:nproducto,cantidad:ncantidad},

				success:function(datos){
					$("#selec_pro").html(datos);
				}
			}

		)
}
/*****Buscador XD */
$(document).ready(function(){
	$("#CodigoBarras").keyup(function(){
		$.ajax({
		type: "POST",
		url: "controlador/VentasC.php",
		data:'keyword='+$(this).val()+'&peticion=AutoCompletado',
		beforeSend: function(){
			$("#CodigoBarras").css("background","#FFF url(https://phppot.com/demo/jquery-ajax-autocomplete-country-example/loaderIcon.gif) no-repeat 100%");
		},
		success: function(data){
			$("#suggesstion-box").show();
			$("#suggesstion-box").html(data);
			$("#CodigoBarras").css("background","#FFF");
		}
		});
	});
});

/**buscador de perosnas*/

var Conta=0;
function selectCountry(val,id) {
	Conta=Conta+1;
	console.log(val)
	console.log(id)
	$.ajax({
		url:"controlador/VentasC.php",
		type:'POST',
		data:{'peticion':'AddGrilla','CodProducto':id},
		success:function(respuesta)
		{	
			console.log(respuesta);
			$Ojb=JSON.parse(respuesta);
			$stock=$Ojb.CANTIDAD;
			if($stock>0)
			{
				var valida=ValidaProRepetido($Ojb.COD_PRODUCTO);
				if (valida=='NO')
				{
					$('#ContenidoGrilla').append(`
						<tr>
						<td id='CodProducto${Conta}'>${$Ojb.COD_PRODUCTO}</td>
						<td>${$Ojb.NOMBRE_PRODUCTO}</td>
						<td><input type='text' id='Cantidad${Conta}' value='1' name='Cantidad${Conta}'></td>
						<td>${$Ojb.PRECIO_VENTA}</td>
						</tr>`);
				}
				else{
					swal('El producto ya fue selecionado');
				}
			}else 
			{
				swal('No tiene Stock suficiente');
			}
			
		}
	})
	
//$("#CodigoBarras").val(val);
$("#suggesstion-box").hide();

//AddGrilla();
//$('#IdPersonaV').val(id);
}

/****llenaremos los tr de las tablas   ****/
function ValidaProRepetido($CodProducto)
{
	for(let $i=1;$i<50;$i++)
	{
		var Cod=$('#CodProducto'+$i).html();
		if (Cod==$CodProducto)
		{ return 'SI'}
		else { return 'NO' }
		if(cod=='')
		{$i=51}
	}
}

function ValidaStock($CodProducto)
{

}

</script>
