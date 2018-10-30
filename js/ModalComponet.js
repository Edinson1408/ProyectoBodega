class SellModal extends HTMLElement {
    constructor(){
      super();
    }
  
    connectedCallback(){
      let shadowRoot=this.attachShadow({mode:'open'});
      shadowRoot.innerHTML=`
      <div class="modal-content" id="ModalNewClient">
      <h4>Nuevo Cliente</h4>

 <form id='form_account' method="POST">
 <div class="row">

	<div class="col l6 s12">
 	    <div class="form-group">
            <div class="input-group">
            <select name="TipoDos" id="TipoDoc" class="form-control" onchange="SelecRucDni();">
                <option value="RUC">RUC</option>
                <option value="DNI">DNI</option>
            </select>
            </div>
        </div>
 	</div>

 	<div class="col l6 s12"  id="ContRuc">
 	    <div class="form-group">
            <div class="input-group">
            <input type="text" class="form-control" id="RUCDNI" type="text" name="RUCDNI" placeholder="RUC"
            maxlength="11" value='' required>
            <div class="input-group-append">
              <span class="input-group-text" onclick='ValidaRuc();'><a id="btn-validar-ruc"><i class="icon ion-md-search"></i></a></span>
            </div>
            </div>
        </div>
 	</div>

    <div class="col l6 s12" style="display:none;" id="ContDni">
 	    <div class="form-group">
            <div class="input-group">
            <input type="text" class="form-control" id="DNI" type="text" name="DNI" placeholder="DNI"
            maxlength="11" value='' required>
            </div>
        </div>
 	</div>
 </div>

 <div class="row">
	
	 <div class="col l6 s12">
	 	<div class="form-group">
	 		<input type="text"  class="form-control" placeholder="Nombre" name="RazonSocial" id="RazonSocial"  >
	 	</div>
	 </div>

    <div class="col l6 s12">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Dirección" id='direccion' name="direccion">
        </div>
    </div>


 </div>
 

<div class="row">
    <div class="col s12 l6">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Telefono" name="telefono" id="telefono" >
        </div>
    </div>
    <div class="col s12 l6">
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Correo" name="correo" id="correo" >
        </div>
    </div>
 </div>
 

 <a style="float: right;" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
 <a style="float: right;position: absolute;" href="#!" class="modal-action  waves-effect waves-green btn-flat" id="create_account">Guardar</a>


</form>



    <script type="text/javascript">
    /*Para cambiar entre el ruc y dni */
    SelecRucDni=()=>
    {
        let tipoDoc=document.getElementById('TipoDoc').value;
        if (tipoDoc=='RUC'){
        $('#ContRuc').css({'display':'block'}),$('#ContDni').css({'display':'none'})}
        else
       {$('#ContDni').css({'display':'block'}),$('#ContRuc').css({'display':'none'})}
    }




    $(document).ready(function() {
        $('#create_account').click(function(){
            console.log($('#RUCDNI').val());
            console.log($('#Nomproveedor').val());
            console.log($('#NEjecutivo').val());
            console.log($('#RazonSocial').val());
            console.log($('#direccion').val());
            console.log($('#telefono').val());
            console.log($('#correo').val());
            console.log($('#CampoOculto').val());
            var dataString = $('#form_account').serialize();

            peticion='insertar';
            console.log('Datos serializados: '+dataString+'&peticion='+peticion);


            $.ajax({
            url:'controlador/ProveedorC.php',
            method:'POST',
            data:dataString+'&peticion='+peticion,
            success:function(respuesta)
            {
                console.log(respuesta);
                $('#modal1').modal('close');
            
            }
            });

        });



});

 </script>

      
      </div> `;
    }
}
window.customElements.define('sell-cliente',SellModal)



