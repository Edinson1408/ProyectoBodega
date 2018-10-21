     // funcion que se ejecuta cada vez que se selecciona una empresa
function verificar(){
	var ndoc=document.getElementById("doc").value;
	var nclie=document.getElementById("clie").value;
	var nfec=document.getElementById("fe").value;
	var nnumero_boleta=document.getElementById("nro_bol").value;
	var estado=document.getElementById("pago").value;
	
	var url="mostar_detalle.php";

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