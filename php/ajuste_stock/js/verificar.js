function verificar(){
	var fe=document.getElementById("fecha").value;
	var se=document.getElementById("n_ser").value;
	var bo=document.getElementById("n_bol").value;

	
	var url="mostrar_detalle.php";
	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{fecha:fe,serie:se,boleta:bo},

				success:function(datos){
					$("#div_ajax").html(datos);
				}
			}

		)
}