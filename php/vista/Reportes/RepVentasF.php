<style>
.contenedor_lista{
  padding: 15px;
}</style>

<div class="contenedor_lista">
<div class="form-group">
<form  method="POST" id='RepVentasF'>
	<div class="row">
		<div class="col l4 m4 s12">
			
		<input type="date"  class="form-control form-control-sm" name="mes" id='mes'>	
		</div>
		<div class="col l4 m4 s12">
		<input type="date"  class="form-control form-control-sm" name="ano" id='ano'>	
		</div>
		<div class="col l4 m4 s12">
			<a  class="btn btn-primary btn-sm" onclick=MostrarHistorial();>Buscar</a>
		</div>
	</div>
	</form>
</div>
	              
          	 
          	 
                <a  class="btn btn-danger btn-sm" data_id='PDF' onclick='RepVentasHPdfExcel(this);'>PDF</a>
          	    <a class="btn btn-success btn-sm" data_id='EXCEL' onclick='RepVentasHPdfExcel(this);'> Excel</a>


<div class="panel panel-default" id="panel1">
    <div class="row">
        <div class="col-md-12">
            <div class="titulo" style="margin-left: 10px;">
                <h4>Ventas - Rango de Fechas</h4>
            </div>
        </div>
    </div>
</div>
<div id='MuestraReporte'>

</div>
</div>
<script>

MostrarHistorial=()=>{
	let peticion='Mreporte';
	let DataString=$('#RepVentasF').serialize();
	$.ajax({
    		url:'controlador/VentasC.php',
    		method:'POST',
    		data:DataString+'&peticion='+peticion,
    		success:function(respuesta)
    		{	
				//document.getElementById('MuestraReporte').innerHTML=respuesta;
				$('#MuestraReporte').html(respuesta);
    		}
    		});
}

RepVentasHPdfExcel=(e)=>
{
	console.log('hola')
	
	var mes=$('#mes').val();
	var ano=$('#ano').val();
	if (mes=='Mes')
	{
		swal('seleccione un mes');
	}else if(ano=='Año')
	{
		swal('seleccione un año');
	}
	else
	{
		var formato=$(e).attr('data_id');
		if (formato=='PDF')
		{
			let DataString=$('#RepVentasF').serialize();
			window.open('reportes/ReportesPdf/PdfHistorialVentasRango.php?'+DataString);
		}else{
			let DataString=$('#RepVentasF').serialize();
			window.open('reportes/ReportesExcel/ExcelHistorialVentasRango.php?'+DataString);
		}
		
	}
	
}

</script>
