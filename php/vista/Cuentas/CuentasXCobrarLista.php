<?php
session_start();
///validamos solo el adm tiene accesos a esta parte
echo $_SESSION['categoria'];
?>
<div class="container-fluid">
    <form action="cierre_caja.php" method="POST">
        <div class="row">
        <div class="col-xs-2">
        <input type="date" name="inicio" class="form-control input-sm">
        </div>
        <div class="col-xs-2">
        <input type="submit" name="buscar" value="Buscar" class="btn btn_default btn-sm">
        </div>
        </div>
    </form>
        <a href="pdf/diario.php" class="btn btn-danger btn-sm" target="T_Blank">PDF</a>
		<a href="excel/diario.php" class="btn btn-success btn-sm" target="T_Blank">Excel</a>
		<a href="excel/movimiento.php" class="btn btn-success btn-sm" target="T_Blank">ExcelMovimiento</a>
    <div class='row'>
        <div class='col s12 l6'>
            <button class="btn btn-danger btn-lg" >Cuentas Pendientes</button>
        </div>
        <div class='col s12 l6'>
            <button class="btn btn-danger btn-lg" >Cuentas Cobradas</button>
        </div>
    </div>
    <h4>Cuentas por Cobrar </h4>
	<div class="row">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th style='line-height:6pt;'>Id</th>
                    <th style='line-height:6pt;'>N° Documento</th>
                    <th style='line-height:6pt;'>Tipo Doc.</th>
                    <th style='line-height:6pt;'>Cliente</th>
                    <th style='line-height:6pt;'>Total</th>
                    <th style='line-height:6pt;'>Fecha C.</th>
                    <th style='line-height:6pt;'>Fecha V.</th>
                    <th style='line-height:6pt;'>Acciones</th>
                    
                    
                </tr>
                <?php
                
                foreach ($ListaCuentas as $f) {
                    
                    echo "<tr>";
                    echo "<td style='line-height:5pt;'>".$f['IDCOMPROBANTE']."</td>";
                    echo "<td style='line-height:5pt;'>".$f['NUMCOMPROBANTE']."</td>";
                    echo "<td style='line-height:5pt;'>".$f['ABREBIATURA']."</td>";
                    echo "<td style='line-height:5pt;'>".$f['NOMCLIENTE']."</td>";
                    echo "<td style='line-height:5pt;'>S/".$f['TOTAL']."</td>";
                    echo "<td style='line-height:5pt;'>".$f['FECHACOMPROBANTE']."</td>";
                    echo "<td style='line-height:5pt;'></td>";
                    echo "<td style='line-height:5pt;'>Ver | Amortizar</td>";
                    echo "</tr>";

                        
                    }
                ?>
            </table>
            
        </div>
	</div>

</div>
<!--modal editar Agregar-->
<div id="ModalAmortizar" class="modal" style="width: 90%">
    <div class="modal-content" id="AmortizarContenido">

    </div>
 </div>


<script type="text/javascript">
 $(document).ready(function(){
    // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
  });



Amortizar=()=>
{
    $.ajax({
    		url:'controlador/CuentasXCobrarC.php',
    		method:'POST',
    		data:{peticion:'FormAmortizar'},
    		success:function(respuesta)
    		{
    		  $("#AmortizarContenido").html(respuesta);
    		}
    		});
    $('#ModalAmortizar').modal('open');
    
}

VerAmortizaciones=()=>
{

}
</script>