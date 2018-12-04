<h4><?php echo $tituloModal;?></h4>

<form Id='AmortizacionId' method='POST'>
    <div class='row'>  
        <div class="col l6 s12">
            <label>Saldo</label>
            <input class="form-control" type='text'  value='' disabled='disabled' id='SaldoAnterior'>
        </div>
        <div class="col l6 s12">
            <label>Comprobante</label>
            <input type='text'  value=''>
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
    </div>
    <div class='row'>
        <div class="col l6 s12">
 			<div class="form-group">
     		 <input class="form-control" type="text" placeholder="Monto" name='Monto' id='Monto' onchange='CalculaActual(this);'>
			</div>
        </div>
        <div class="col l6 s12">
 			<div class="form-group">
            <label for="">Saldo Actual</label>
     		 <input class="form-control" type="text" disabled='disabled' name='SaldoA' id='SaldoA'>
			</div>
        </div>
    </div>
    <div class='row'>
        <div class="col l12 s12">
            <label for="">Observaciones</label>
            <textarea name="" id="" cols="30" rows="10"></textarea>
        </div>
    </div>

 </form>

 <a style="float: right;" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
 <a style="float: right;" href="#!" class="modal-action  waves-effect waves-green btn-flat" onclick="GuardarAmortizacion();">Guardar</a>


<script type="text/javascript">
    //Si cobra todo no permitir llenar el input , y
    CobrarTodo=(e)=>
    {
        var CheckAutomatico=$(a).prop('checked');
	    (CheckAutomatico==true)? $('#Monto').prop('diabled',true):$('#Monto').prop('diabled',false);
        
        
    }

    CalculaActual=(e)=>
    {
        let monto= parsefloat($(e).val());
        let SaldoAnterior =parsefloat($('#SaldoAnterior').val());
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
        
    }
    
</script>
