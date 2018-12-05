<h4><?php echo $tituloModal;?></h4>

<form Id='AmortizacionId' method='POST'>
    <div class='row'>  
        <div class="col l6 s12">
            <label>Saldo</label>
            <input class="form-control" type='text'  value='<?=$Saldo;?>' readonly='readonly' id='SaldoAnterior' name='SaldoAnterior'>
        </div>
        <div class="col l6 s12">
            <label>Comprobante</label>
            <input class="form-control" type='text'  value='' name='comprobante'>
        </div>
    </div>
    <div class="row">
 	    <div class="col l6 s12">
 			<div class="form-group">
                <div class="switch">
                    <label>Cobrar Todo<input type="checkbox" id="CheckAutomatico" onchange="CobrarTodo(this)">
                    <span class="lever"></span>
                    </label>
	 	        </div>
			</div>
 	    </div>

        <div class="col l6 s12">
 			<div class="form-group">
     		 <input class="form-control" type="date"  name='FechaR' id='FechaR' >
			</div>
        </div>
    </div>
    <div class='row'>
        <div class="col l6 s12">
 			<div class="form-group">
             <label>Monto</label>
     		 <input class="form-control" type="text" placeholder="Monto" name='Monto' id='Monto' onchange='CalculaActual(this);'>
			</div>
        </div>
        <div class="col l6 s12">
 			<div class="form-group">
            <label for="">Saldo Actual</label>
     		 <input class="form-control" type="text"  name='SaldoA' id='SaldoA'  readonly='readonly'>
			</div>
        </div>
    </div>
    <div class='row'>
        <div class="col l12 s12">
            <label for="">Observaciones</label>
            <textarea name="observacion" id="" cols="30" rows="10"></textarea>
        </div>
    </div>
    <input type="hidden" value='<?=$IdComprobante;?>' name='IdComprobante'>
 </form>

 <a style="float: right;" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
 <a style="float: right;" href="#!" class="modal-action  waves-effect waves-green btn-flat" onclick="GuardarAmortizacion();">Guardar</a>


<script type="text/javascript">
    //Si cobra todo no permitir llenar el input , y
    CobrarTodo=(e)=>
    {
        console.log('55');
        var CheckAutomatico=$(e).prop('checked');
        if(CheckAutomatico==true){
        $('#Monto').prop('readonly','readonly');
        let SaldoAnterior =parseFloat($('#SaldoAnterior').val());
        let monto= SaldoAnterior;
        $('#Monto').val(monto);
        $('#SaldoA').val(SaldoAnterior-monto);
        }
        else {
        $('#Monto').prop('readonly','');
        $('#Monto').val('0');
            }
        
    }

    CalculaActual=(e)=>
    {
        let monto= parseFloat($(e).val());
        let SaldoAnterior =parseFloat($('#SaldoAnterior').val());
        if (monto>SaldoAnterior)
        {
            swal('Se a excedido en el monto el saldo es '+SaldoAnterior);
        }
        else{
            let SaldoActual = $('#SaldoA').val(SaldoAnterior-monto);
        }
        
    }

    GuardarAmortizacion=()=>
    {
        $DataString=$('#AmortizacionId').serialize();
        console.log($DataString);
    }
    
</script>
