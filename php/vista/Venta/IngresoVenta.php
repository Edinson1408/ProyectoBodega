<?php
//hay que hacer las validaciones de los vacios
include("../../conexion.php");
?>
<script>
function sf(ID){
document.getElementById(ID).focus();
}
</script>
<style>

form{
	padding: 20px;
}
.sinborde {
    border: 0;
  }
  
  </style>
</head>

</head>
<body onload="sf('btn');">
<form  method='POST' id='GuardarVenta'>

<div class="form-group">
<img src="../img/LOGOTIPO.PNG" alt="">
	<div class="row">
	<div class="col l4 m4 s12">
			Fecha : <input type="date" class="form-control form-control-sm" name="FecComprobante" id='FecComprobante' value="<?php date_default_timezone_set('America/Bogota'); echo date('Y-m-d')?>" id="fe">
		</div>
			<div class="col l4 m4 s12">
			Documento :	
			<select class="form-control form-control-sm" id="TipoDocCom" name='TipoDoc' onchange="CambiaCorrelativo();">
			<option value='2'>Boleta</option>
			<option value='1'>Factura</option>
			</select>
		</div>
		<div class="col l4 m6 s12">
	<?php
	/*$SQL_PAGO=mysqli_query($conexion,"SELECT * FROM ESTADO  ORDER BY ID_ESTADO ASC ");
	$ARR_CLI=mysqli_fetch_array($SQL_PAGO)*/
	?>
	Pago :<select class="form-control form-control-sm" id="Estado" name='Estado' >
			<option value="1">Cancelado</option>
			<option value="2">Pendiente</option>
					<!--<option value="<?php echo $ARR_CLI['ID_ESTADO'];?>"><?php echo $ARR_CLI['NOMBRE_ESTADO'];?></option>-->
					<?php
					/*$sql_estado=mysqli_query($conexion,"SELECT * FROM estado");
					while ($r=mysqli_fetch_array($sql_estado)) {
						echo "<option value='".$r['ID_ESTADO']."'>".$r['NOMBRE_ESTADO']."</option>";
					}*/
					?>
					</select>
	</div>
	</div>
	<div class="row">

		<div class="col l4 m4 s12">
			Serie : <input type="text" class="form-control form-control-sm" name="Serie" id='Serie' >
		</div>
	
		<div class="col l4 m4 s12">
			<!--Nro Documento: <input type="text" name="" data_name='asd' onchange="VerificaDoc(this)" class="form-control form-control-sm" id="nro_bol" value="<?php echo $MaxId; ?>">-->
			Correlativo : <input type="text"  data_name='asd' onchange="" class="form-control form-control-sm" id="NumCompro" name='NumCompro' value="<?php echo $MaxId; ?>">
		</div>
		
	</div>
<div class="row">
	<div class="col l4 m6 s12">
		RUC/DNI : <input list="cliente" id="CliDoc" class="form-control form-control-sm" name="CliDoc" value="" autocomplete="off" onDblClick=NewCliente();>
		<div id="LiCliente"></div>
	</div>
	<div class="col l8 m6 s12">
		Cliente :	
		<input type="text"  id="NombreCLiente" name="NombreCLiente" class="form-control form-control-sm" readonly>
	</div>
	
</div>


<div class="row">
	<div class="col l6 m6 s12">
		<div class="switch">
		    <label>
		      Automatico
		      <input type="checkbox" id="CheckAutomatico" onchange="Automatico(this)">
		      <span class="lever"></span>
		      Manual
		    </label>
	 	 </div>
	</div>
	<div class="col l6 m6 s12">
		<input type="text" name="CodigoBarras" class="form-control form-control-sm" id='CodigoBarras'  style="display: none" autocomplete="off">
		<div id="suggesstion-box"></div>
	<div>
</div>
	<!--hideen-->
	<input type='hidden' name='IdPersona' id='IdPersona'>
<!--Modal NewCliente-->
<div id="NuevoCLiente" class="modal" style="width: 90%">
<div class="modal-content" id="ModalNewClient">
</div>
</div>

<div id="div_ajax">
</div>


</div>
<div class="row">
	<table class="table table-bordered ">
	<thead>
		<tr>
			<td style='line-height:6pt;'>Codigo</td>
			<td style='line-height:6pt;'>Nombre</td>
			<td style='line-height:6pt;'>Cantidad</td>
			<td style='line-height:6pt;'>Precio</td>
			<td style='line-height:6pt;'>Importe</td>
		</tr>
	</thead>
	<tbody id='ContenidoGrilla'>
		

	</tbody>
	<tr>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'>Sub total</td>
	<td  style="background-color: #34495E;color: white; line-height:6pt;" >S./ <input type='text' id='SubTotal' name='SubTotal' class="sinborde" style="background-color: #34495E;" readonly></td>
	</tr>
	<tr>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'>Igv</td>
	<td  style="background-color: #34495E;color: white; line-height:6pt;" >S./ <input type='text' id='Igv' name='Igv' class="sinborde" style="background-color: #34495E;" readonly></td>
	</tr>

	<tr>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'></td>
	<td style='line-height:6pt;'>Total</td>
	<td  style="background-color: #34495E ;color: white; line-height:6pt;" >S./ <input type='text' id='Total' name='Total' class="sinborde" style="background-color: #34495E;" readonly></td>
	</tr>
	</table>
	
	
</div>

<a class="btn btn-primary" onclick='Guardar();'>Guardar</a>

</form>

<script>


Guardar=()=>
{
	
	$.ajax({
		url:'controlador/VentasC.php',
		type:'POST',
		data :$('#GuardarVenta').serialize()+'&peticion=GuardarVenta',
		success:function(respuesta)
		{
			console.log(respuesta);
			var numcom=$('#NumCompro').val();
			window.open("reportes/Imprimir/ImpresionBoleta.php?Idcomprobante="+respuesta);
			enrutar_menu('VentasC.php','IngresoVenta');
		}
	})
	console.log($('#GuardarVenta').serialize());
}



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

/********** Agregar Nuevo cliente
************/
NewCliente=()=>{
	$.ajax({
				type:"post",
				url:"controlador/VentasC.php",
				data:{'peticion':'VistaNewClient'},
				success:function(datos){
					$("#ModalNewClient").html(datos);
				}
			});
	$('#NuevoCLiente').modal('open');
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

$('#LiCliente').hide();
$(document).ready(function(){
	//para que siempre este activo las modales
	$('.modal').modal();


	/*Buscador cliente x DNI*/
	$("#CliDoc").keyup(()=>{
		let RucDni=$("#CliDoc").val();
		let Accion='RucCLiente';
		$.ajax({
			type:"POST",
			url:"controlador/VentasC.php",
			data:{'peticion':Accion,'RucDni':RucDni},
			success: function(data)
			{
				$("#LiCliente").show();
				$("#LiCliente").html(data);	
			}
			
		});
	});



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
SelectDni=(val,id,IdPersona)=>
{
		console.log(val);
		console.log(id);
		console.log(IdPersona);
		$("#CliDoc").val(id);
		$("#NombreCLiente").val(val)
		$("#IdPersona").val(IdPersona)
		$("#LiCliente").hide();
}



var Conta=0;
var Total=0;
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
				var valida=ValidaProRepetido($Ojb.CODPRODUCTO);
				if (valida=='NO')
				{
					$('#ContenidoGrilla').append(`
						<tr>
						<td style='line-height:6pt;'> 
							<input class='sinborde' id='CodProducto${Conta}' name='CodProducto${Conta}' value='${$Ojb.CODPRODUCTO}'> 
						</td>
						<td style='line-height:6pt;'> ${$Ojb.NOMPRODUCTO}</td>
						<td> 
							<input  class="form-control form-control-sm " type='text' id='Cantidad${Conta}' data_id='${Conta}'' name='Cantidad${Conta}' value='1' onchange="ValidaStock(this)">
						</td>
						<td style='line-height:6pt;'> 
						<input  class="sinborde" type='text' id='PrecioVenta${Conta}' name='PrecioVenta${Conta}' value='${$Ojb.PRECIOVENTA}' readonly>
						</td>
						<td style='line-height:6pt;'> 
							<input  class="sinborde" type='text' id='Importe${Conta}' name='Importe${Conta}' value='${$Ojb.PRECIOVENTA}' readonly>
						</td>
						</tr>`);
					
						Total=Total+Number.parseFloat($Ojb.PRECIOVENTA);

				}
				else{
					swal('El producto ya fue selecionado');
				}
			}else 
			{
				swal('No tiene Stock suficiente');
			}
			let SubTotal=$("#SubTotal").val(Total);
			let Igv=0.18;
			$("#Igv").val(Total*0.18);
			// let totalF=SubTotal+(SubTotal*Igv);
			let totalF=Total+(Total*Igv);
			$("#Total").val(totalF);
			
			
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
		var Cod=$('#CodProducto'+$i).val();
		if (Cod==$CodProducto)
		{ return 'SI'}
		else { return 'NO' }
		if(cod=='')
		{$i=51}
	}
}

 ValidaStock =(a)=>
{
	//cod producto
	let id=$(a).attr("data_id");
	let CodProducto=$('#CodProducto'+id).val();
	let cantidad=$(a).val();
	console.log(CodProducto);
	$.ajax({
		url:'controlador/VentasC.php',
		type:'POST',
		data:{'peticion':'ValidaStock','CodProducto':CodProducto},
		success:function(respuesta)
		{			
			console.log('CANTIDAD STOCK '+respuesta); 
			if(parseInt(cantidad)>parseInt(respuesta))
			{
				swal('No cuenta con el stock suficiente ');
				$('#Cantidad'+id).val(respuesta);
				$(a).val(respuesta)
				CalcularImporte(a);
			}else
			{
				CalcularImporte(a);
			}
		}

	});
	
}

CalcularImporte=(a)=>
{
	let id=$(a).attr("data_id");
	let Cantidad=Number.parseFloat($(a).val());
	let preciov=Number.parseFloat($('#PrecioVenta'+id).val());
	$('#Importe'+id).val(preciov*Cantidad);
	console.log($(a).attr("data_id"));
	console.log($(a).val());
	console.log(preciov);
	CalcularTotales();
}

CalcularTotales=()=>
{
	var calculador=0;
	for(let $i=1;$i<50;$i++)
	{
		
		var Importe=$('#Importe'+$i).val();
		
		if(Importe=='' || Importe==undefined)
		{$i=51}
		else {

			calculador=calculador+(Number.parseFloat(Importe));
		}
		
	}
	console.log(`==============================================`);
	console.log(calculador);
	$("#SubTotal").val(calculador);
	let Igv=0.18;
	$("#Igv").val(calculador*0.18);
	let totalF=calculador+(calculador*Igv);
	$("#Total").val(totalF);
}

CambiaCorrelativo=(Id='')=>
{
	$(`#NumCompro`).attr("readonly", true);
	$(`#Serie`).attr("readonly", true);
	if(Id=='') 
	{
		var TipoDoc=$('#TipoDocCom').val();
	}
	else{
		var TipoDoc=Id;
	}
	
	console.log(TipoDoc);
	$.ajax({
		url:'controlador/VentasC.php',
		type:'POST',
		data:{'peticion':'CambiaCorrelativo','TipoDoc':TipoDoc},
		success:function(respuesta)
		{	
			$Obj=JSON.parse(respuesta);		
			
			$('#NumCompro').val($Obj.Numero);
			$('#Serie').val($Obj.Serie);
			
		}

	});
}
CambiaCorrelativo('2');
</script>
