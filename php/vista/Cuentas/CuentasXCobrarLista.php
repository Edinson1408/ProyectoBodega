<?php
session_start();
///validamos solo el adm tiene accesos a esta parte
 $_SESSION['categoria'];
?>


<div class="container-fluid">
    <form id='FormCuentas' method="POST">
        <div class="row">
        <div class="col s6">
            <label >F. Inicio</label>
            <input type="date" name="Inicio" id="Inicio" class="form-control input-sm">
        </div>
        <div class="col s6">
            <label >F. Fin</label>
            <input type="date" name="Fin" id="Fin" class="form-control input-sm">
        </div>
        </div>
    </form>
        <!--<a href="pdf/diario.php" class="btn btn-danger btn_default btn-sm" >HTML</a>-->
        <a class="btn  btn-primary btn-sm" >HTML</a>
        <a class="btn btn-danger btn-sm" target="T_Blank" data_id="PDF" onclick="RepVentasHPdfExcel(this)">PDF</a>
		<a class="btn btn-success btn-sm" target="T_Blank" data_id="EXCEL" onclick="RepVentasHPdfExcel(this)">Excel</a>
		<!-- <a class="btn btn-success btn-sm" target="T_Blank">ExcelMovimiento</a> -->
        <!--<a href="excel/movimiento.php" class="btn btn-success btn-sm" target="T_Blank">ExcelMovimiento</a>-->
</div>
<div class='row'>
            <div class='col s12 l6'>
                <button class="btn btn-danger btn-lg" onclick="CambiarVista('CuentasXCobrar')">Cuentas Pendientes</button>
            </div>
            <div class='col s12 l6'>
                <button class="btn btn-danger btn-lg " onclick="CambiarVista('CuentasCobradas')" >Cuentas Cobradas</button>
            </div>
</div>

<div id='CuentasXCobrar' ><!-- vista cuentas por cobrar-->
    <div class="container-fluid">
        <h4><?php echo $titulo;?> </h4>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th style='line-height:6pt;'>Id</th>
                        <th style='line-height:6pt;'>N° Documento</th>
                        <th style='line-height:6pt;'>Tipo Doc.</th>
                        <th style='line-height:6pt;'>Cliente</th>
                        <th style='line-height:6pt;'>Total</th>
                        <th style='line-height:6pt;'>Amortizado</th>
                        <th style='line-height:6pt;'>Saldo</th>
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
                        echo "<td style='line-height:5pt;'>".$f['MONAMORTIZACION']."</td>";
                        echo "<td style='line-height:5pt;'>".$f['SALDOX']."</td>";
                        echo "<td style='line-height:5pt;'></td>";
                        echo "<td style='line-height:5pt;'>";?>
                        <i class="material-icons" style='cursor:pointer;' onclick="VerAmortizaciones('<?=$f['IDCOMPROBANTE']?>')">visibility</i>
                        <i class="material-icons" style='cursor:pointer;' onclick="Amortizar('<?=$f['SALDOX']?>','<?=$f['IDCOMPROBANTE']?>');">equalizer</i>
                        <?php echo "</td>";
                        echo "</tr>";

                            
                        }
                    ?>
                </table>
                
            </div>
        </div>

    </div>
</div>
<div id='CuentasCobradas' style='display:none'><!-- vista cuentas por cobrar-->
    <div class="container-fluid">
       
        <h4><?php echo $titulo2;?> </h4>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr>
                        <th style='line-height:6pt;'>Id</th>
                        <th style='line-height:6pt;'>N° Documento</th>
                        <th style='line-height:6pt;'>Tipo Doc.</th>
                        <th style='line-height:6pt;'>Cliente</th>
                        <th style='line-height:6pt;'>Total</th>
                        <th style='line-height:6pt;'>Amortizado</th>
                        <th style='line-height:6pt;'>Saldo</th>
                        <th style='line-height:6pt;'>Fecha V.</th>
                        <th style='line-height:6pt;'>Acciones</th>
                        
                        
                    </tr>
                    <?php
                    
                    foreach ($ListaCuentasCobradas as $f) {
                        
                        echo "<tr>";
                        echo "<td style='line-height:5pt;'>".$f['IDCOMPROBANTE']."</td>";
                        echo "<td style='line-height:5pt;'>".$f['NUMCOMPROBANTE']."</td>";
                        echo "<td style='line-height:5pt;'>".$f['ABREBIATURA']."</td>";
                        echo "<td style='line-height:5pt;'>".$f['NOMCLIENTE']."</td>";
                        echo "<td style='line-height:5pt;'>S/".$f['TOTAL']."</td>";
                        echo "<td style='line-height:5pt;'>".$f['MONAMORTIZACION']."</td>";
                        echo "<td style='line-height:5pt;'>".$f['SALDOX']."</td>";
                        echo "<td style='line-height:5pt;'></td>";
                        echo "<td style='line-height:5pt;'>";?>
                        <i class="material-icons" style='cursor:pointer;' onclick="VerAmortizaciones('<?=$f['IDCOMPROBANTE']?>')">visibility</i>
                        <i class="material-icons" style='cursor:pointer;' onclick="Amortizar('<?=$f['SALDOX']?>','<?=$f['IDCOMPROBANTE']?>');">equalizer</i>
                        <?php echo "</td>";
                        echo "</tr>";

                            
                        }
                    ?>
                </table>
                
            </div>
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


CambiarVista=(valor)=>
{
    if(valor=='CuentasXCobrar')
    {
        $('#CuentasXCobrar').css({'display':'block'})
        $('#CuentasCobradas').css({'display':'none'})
        
    }else{
        $('#CuentasXCobrar').css({'display':'none'})
        $('#CuentasCobradas').css({'display':'block'})
    }
   
}

Amortizar=(Saldo,IdComprobante)=>
{
    $.ajax({
    		url:'controlador/CuentasXCobrarC.php',
    		method:'POST',
    		data:{peticion:'FormAmortizar',Saldo:Saldo,IdComprobante:IdComprobante},
    		success:function(respuesta)
    		{
    		  $("#AmortizarContenido").html(respuesta);
    		}
    		});
    $('#ModalAmortizar').modal('open');
    
}

VerAmortizaciones=(IdComprobante)=>
{
    $.ajax({
    		url:'controlador/CuentasXCobrarC.php',
    		method:'POST',
    		data:{peticion:'MostarAmortizaciones',IdComprobante:IdComprobante},
    		success:function(respuesta)
    		{
    		  $("#AmortizarContenido").html(respuesta);
    		}
    		});
        $('#ModalAmortizar').modal('open');
}


RepVentasHPdfExcel=(e)=>
{
	console.log('hola')
	
	var mes=$('#Inicio').val();
	var ano=$('#Fin').val();
	if (mes=='')
	{
		swal('seleccione una fecha de inicio');
	}else if(ano=='')
	{
		swal('seleccione una fecha  de termino');
	}
	else
	{
		var formato=$(e).attr('data_id');
		if (formato=='PDF')
		{
            
			let DataString=$('#FormCuentas').serialize();
			window.open('reportes/ReportesPdf/PdfCuentasR.php?'+DataString);
		}else{
            
			let DataString=$('#FormCuentas').serialize();
			window.open('reportes/ReportesExcel/ExcelCuentasR.php?'+DataString);
		}
		
	}
	
}


SeguridadAnular=($id)=>
{
	if ($id=='1')
	{}
	else
	{
		//renderizar con read
		$('#contenidobody').html('');
		Rendiza('contenidobody')
	}
	
	
}

SeguridadAnular('<?=$_SESSION['categoria']?>')


</script>

