
<style type="text/css">
.container-fluid{
	padding: 25PX;
}
.form-control, .btn{
	border-radius: 0;
}
</style>
<div class="container-fluid">
	<div class="nota">
		<H4>REPORTES DE VENTAS MENSUALES</H4>
	</div>
<!--action="lista_ventas.php"-->
<div class="form-group">
<form  method="POST" id='RepVentasHF'>
	<div class="row">
		<div class="col l4 m4 s12">
			<select class="form-control form-control-sm" name="mes" id='mes'>
				<option>Mes</option>
				<?php
					$meses = array(1 =>'Enero', 2 =>'Febrero',3 =>'Marzo' ,4 =>'Abril',5 =>'Mayo',6 =>'Junio',7 =>'Julio',8 =>'Agosto',9 =>'Septiembre',10 =>'octubre',11 =>'Noviembre',12 =>'Diciembre' );
					for ($i=1; $i <=12  ; $i++) { 
					   echo "<option value='".$i."'>".$meses[$i]."</option>";
					} 
				?>
			</select>
		</div>
		<div class="col l4 m4 s12">
			<select class="form-control form-control-sm"  name="ano" id='ano'>
			    <option>Año</option>
			    <?php
			        $año=2030; 
			        for ($i=2016; $i <$año ; $i++) { 
			            echo "<option value='".$i."'>".$i."</option>";
			        }
			    ?>
			</select>
		</div>
		<div class="col l4 m4 s12">
			<a  class="btn btn-primary btn-sm" onclick=MostrarHistorial();>Buscar</a>
		</div>
	</div>
	</form>
</div>
<a  class="btn btn-danger" style="float: left;" data_id='PDF' onclick='RepVentasHPdfExcel(this);'>
	<i class="glyphicon glyphicon-download-alt">DescargarVentas-PDF</i>
</a>
<a  class="btn btn-success" style="float: left;" data_id='EXCEL' onclick='RepVentasHPdfExcel(this);'>
<i class="glyphicon glyphicon-download-alt">DescargarVentas-EXCEL</i>
</a>
<div id='MuestraReporte'>
</div>
</div>


<script>
MostrarHistorial=()=>{
	let peticion='MostrarHistorial';
	let DataString=$('#RepVentasHF').serialize();
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
			let DataString=$('#RepVentasHF').serialize();
			window.open('reportes/ReportesPdf/PdfHistorialVentas.php?'+DataString);
		}else{
			let DataString=$('#RepVentasHF').serialize();
			window.open('reportes/ReportesExcel/ExcelHistorialVentas.php?'+DataString);
		}
		
	}
	
}



</script>