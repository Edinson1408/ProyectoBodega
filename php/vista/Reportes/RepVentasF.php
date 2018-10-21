<style>
.contenedor_lista{
  padding: 15px;
}</style>

<div class="contenedor_lista">
      <!--<form action="rang_fec_ventas.php" method="POST">-->
        	<div class="form-group">
        	<div class="col-xs-3">
	             <input type="date" name="inicio" class="form-control input-sm" id="F1V" >
        	</div>
        	</div>
        	<div class="form-group">
        	<div class="col-xs-3">
	             <input type="date" name="final" class="form-control input-sm" id="F2V">
        	</div>
        	</div>
	              <input type="submit" name="buscar" class="btn btn-default btn-sm"  value="Buscar" onclick="GenrarReporteV();">
          	    <a href="#" class="btn btn-default btn-sm">General</a>
          	    <!--<a href="../reporte/ReportesPdf/rango_ventas_pdf.php" class="btn btn-danger btn-sm" target="T_BLANK">PDF</a>-->
                <a  class="btn btn-danger btn-sm" onclick="Generapdf('Pdf_RangoF_Venta.php');">PDF</a>
          	    <a href="excel/rango_ventas_excel.php" class="btn btn-success btn-sm">Excel</a>
<!--</form>-->

<div class="panel panel-default" id="panel1">
    <div class="row">
        <div class="col-md-12">
            <div class="titulo" style="margin-left: 10px;">
                <h4>Ventas - Rango de Fechas</h4>
            </div>
        </div>
    </div>
</div>
<div id='ConReVenta'>
<table class="table table-striped" >
	<tr>
		<th>Boleta N°</th>
		<th>Turno</th>
		<th>Encargado</th>
		<th>Fecha</th>
		<th>Cliente</th>
		<th>Sub_Total</th>
		<th>Igv</th>
		<th>Total</th>
	</tr>

      	<?php
      	foreach ($reporteVista as $f)
        {
        		echo "<tr>";
        			echo "<td>".$f['NRO_FACTURA']."</td>";
        			echo "<td>".$f['TURNO']."</td>";
        			echo "<td>".$f['ENCARGADO']."</td>";
        			echo "<td>".$f['FECHA_FACTURA']."</td>";
        			echo "<td>".$f['NOMBRE']."</td>";
        			echo "<td>".$f['SUB_TOTAL']."</td>";
        			echo "<td>".$f['IGV']."</td>";
        			echo "<td>".$f['TOTAL']."</td>";
        		echo "</tr>";
      	}
      	?>

</table>
</div>
</div>
<script>
  function GenrarReporteV()
  {
      console.log($('#F1V').val());
      let F1=$('#F1V').val();
      let F2 = $('#F2V').val()
      console.log($('#F2V').val());
      let peticion='Mreporte';

      $.ajax({
        type: 'POST',
        data: {'Inicio':F1,'Final':F2,'peticion':peticion},
        url: 'controlador/VentasC.php',
          success: function(respuesta)
          {
            $('#ConReVenta').html(respuesta);
              console.log(respuesta);
          }
      });

  }
  function Generapdf(NombrePdf)
  {
    let F1=$('#F1V').val();
    let F2 = $('#F2V').val();
    //href="reportes/ReportesPdf/Pdf_RangoF_Venta.php"
    window.open('reportes/ReportesPdf/'+NombrePdf+'?Inicio='+F1+'&Final='+F2);
  }
</script>
