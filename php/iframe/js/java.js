$(document).ready(function(){
	// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
	$('.modal').modal();
});

function verDetalle(codigo){
	var peticion='PreviewComprobante';
		$.ajax({
				type: 'POST',
				data: {'codigo':codigo,'peticion':peticion},
				url: 'controlador/HomeC.php',
				success: function(data){
					console.log(data);
						$('#ModalPreviewTikets').empty();
						$('#ModalPreviewTikets').append(data);
						$('#modal1').modal('open');
						$("#modal1").animate({ scrollTop: 0 }, 600);
						/*$('#modalDetalle').modal({
								show:true,
								backdrop:'static',
						});*/
				}
			});
		return false;
}
