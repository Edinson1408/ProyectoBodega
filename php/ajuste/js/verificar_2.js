function verificar(){
	var nfec=document.getElementById("fe").value;
	var nnumero_boleta=document.getElementById("nro_bol").value;
	var numero_ser=document.getElementById("n_ser").value;
	
	var url="mostar_detalle.php";

	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{fecha:nfec,boleta:nnumero_boleta,serie:numero_ser},

				success:function(datos){
					$("#div_ajax").html(datos);
				}
			}

		)
}