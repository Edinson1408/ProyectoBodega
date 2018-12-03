<h4><?php echo $tituloModal;?></h4>

 <form id='form_provedores' method="POST">
 <div class="row">
 
    <div class="col l6 s12">
            <div class="form-group">
     		    <select class="form-control" name='TipoDoc' Onchange='SelecTipoDoc(this);'>
                    <option value='0'>Tipo de documento</option>
                    <option value='4' <?= ($TipoDoc=='4')?"selected='seleted'":"" ;?> >RUC</option>
                    <option value='3' <?= ($TipoDoc=='3')?"selected='seleted'":"" ;?> >DNI</option>
                </select>
			</div>
     </div>


 	<div class="col l6 s12">
 	    <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" id="RUCDNIP" type="text" name="RUCDNI" placeholder="RUC / DNI"
                    maxlength="11" <?php echo ($NumDoc=='')?'':'readonly'; ?> value='<?php echo $NumDoc;?>' required>
            <div class="input-group-append" onclick='validaRucP();' id='BotonValidaRuc'>
              <span class="input-group-text" ><a id="btn-validar-ruc"><i class="icon ion-md-search"></i></a></span>
            </div>
        </div>
      </div>
 	</div>
     
 </div>


 <div class="row">
    
    <!--DEPENDE DE SI ES RUC O DNI MOSTRA LA RAZON SOCIAL O  NOMBRE O APELLIDOS-->
    <div class="col l12 s12" id='NomRazonSocial'>
     		<div class="form-group">
     		 <input class="form-control input-lg" id="NomproveedorP" name="Nomproveedor" type="text" placeholder="Razon Social" value="<?php echo $NomPro;?>">
			</div>
    </div>

    <div class='col l6 s6' style='display:none' id='NombreCLiente'>
        <div class="form-group">
            <input class="form-control" type="text" name='NomCliente' id='NomCliente' placeholder='Nombres' value="<?php echo $NomPro;?>">
        </div>
    </div>
    <div class='col l6 s6' style='display:none' id='ApellidoCliente'>
        <div class="form-group">
            <input class="form-control" type="text" name='ApeCliente' id='ApeCliente' placeholder='Apellidos' value="<?php echo $Apellido;?>">
        </div>
    </div>

    
 </div>

 <div class='row'>
    <div class="col s12 l12">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Dirección" id='direccionP' name="direccion" value="<?php echo $Dir;?>">
        </div>
    </div>
 </div>

<div class="row">
    <div class="col s12 l6">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Telefono" name="telefono" id="telefono" value="<?php echo $Telefono;?>">
        </div>
    </div>
    
 </div>
 <div>
    <div class="col s12 l6">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Celular" name="Celular" id="Celular" value="<?php echo $Celular;?>">
        </div>
    </div>
 </div>

<div class='row'>
    <div class="col s12 l6">
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Correo" name="correo" id="correo" value="<?php echo $Correo;?>">
        </div>
    </div>
    <div class="col s12 l6">
        <div class="form-group">
            <input type="date" class="form-control" placeholder="F.Nacimiento" name="FNacimiento" id="FNacimiento" value="<?php echo $FNacimiento;?>">
        </div>
    </div>
</div>


 <input type="text" name="CampoOculto" id="CampoOculto" value="<?php echo $oculto;?>" style='visibility: hidden;'>
 </form>
 <a style="float: right;" href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
 <a style="float: right;position: absolute;" href="#!" class="modal-action  waves-effect waves-green btn-flat" id="create_account" onclick='GuardarProveedor();'>Guardar</a>





<script type="text/javascript">

/* muentra el ruc o nombre segun corresponda*/
cambiaradni=()=>
{
        $('#NombreCLiente').css({'display':'block'})
        $('#ApellidoCliente').css({'display':'block'})
        $('#NomRazonSocial').css({'display':'none'})
        $('#BotonValidaRuc').css({'display':'none'})
}
<?php 
  if ($TipoDoc=='3')
  {
      //echo 'cambiaradni();';
  }
?>
SelecTipoDoc=(e)=>
{
    let TipoDoc=$(e).val();
    if(TipoDoc=='3')
    {
        console.log('nosmtrar nombres');
        $('#NombreCLiente').css({'display':'block'})
        $('#ApellidoCliente').css({'display':'block'})
        $('#NomRazonSocial').css({'display':'none'})
        $('#BotonValidaRuc').css({'display':'none'}) 
    }else if (TipoDoc=='4')
    {
        $('#NombreCLiente').css({'display':'none'})
        $('#ApellidoCliente').css({'display':'none'})
        $('#NomRazonSocial').css({'display':'block'})
        $('#BotonValidaRuc').css({'display':'block'})
        console.log('mostrar razon social');
    }
  
}

   
        GuardarProveedor=()=>{ 
        var dataString = $('#form_provedores').serialize();
            
        peticion='insertar';
        console.log('Datos serializados: '+dataString+'&peticion='+peticion+'&Idpersona=<?php echo $IdPersona; ?>');
        $.ajax({
          url:'controlador/ClienteC.php',
          method:'POST',
          data:dataString+'&peticion='+peticion+'&Idpersona=<?php echo $IdPersona; ?>',
          success:function(respuesta)
          {
           console.log(respuesta);
            $('#modal1').modal('close');
            //Actualiza();
                enrutar_menu('ClienteC.php','lista');
          }
        });

     }






    	/*function Guardar_Proveedor()
    	{


    		//campo con el oculto cual validaremos  si es un update o un insert
        var ruc=$('#RUCDNI').val();
    		var nompro=$('#Nomproveedor').val();
    		var nejecutivo=$('#NEjecutivo').val();
    		var razonsocial=$('#RazonSocial').val();
    		var dir=$('#direccion').val();
        var tel=$('#telefono').val();
        var correo=$('#correo').val();
    		var CampoOculto =$('#CampoOculto').val();



    		peticion='insertar'
    		$.ajax({
    			url:'controlador/ProveedorC.php',
    			method:'POST',
    			data:{CampoOculto:CampoOculto,peticion:peticion,ruc:ruc,nompro:nompro,
            nejecutivo:nejecutivo,
            razonsocial:razonsocial,
            dir:dir,
            tel:tel,
            correo:correo },
    			success:function(respuesta)
    			{
    				console.log(respuesta);
    				$('#modal1').modal('close');
    				Actualiza();
    			}
    		});

    	}*/


 

/*ws para el proveedor */

validaRucP=()=>
{
            console.log('no funca la sunat');
           //$('.modal-msj').css({display:'block'});

           var url = "http://192.155.92.99/WebServices/ObtieneIPLocal/ws_ip.php";
           var ruc = $("#RUCDNIP").val();
           console.log(ruc);
           if (ruc.length == 11) {
               jQuery.ajax({
                   type: 'POST',
                   url: url,
                   data: "r="+ruc+"&f=json&t=demo",
                   beforeSend: function() {},
                   success: function(data) {
                     console.log(data);
                       $('.modal-msj').css('display','none');
                       if(data==0 && data!=""){
                           //$("#notifiaciones").addClass("alert alert-danger");
                               //document.getElementById("notifiaciones").innerHTML ="Lo sentimos pero el número de RUC: "+ruc+" no existe, le sugerimos verificar el dato ingresado." ;
                           //bootbox.alert("Lo sentimos pero el número de RUC: "+ruc+" no existe, le sugerimos verificar el dato ingresado.");
                           console.log("Lo sentimos pero el número de RUC: "+ruc+" no existe, le sugerimos verificar el dato ingresado.");
                       }else{
                           if(data==""){
                               console.log("Lo sentimos, no se logró establecer comunicación con el servidor. Por favor reintente en unos minutos o ingrese los datos manualmente.");
                           }else{
                               data = data.replace(/<br>/,'');
                                console.log(data)
                               var datos   = JSON.parse(data);
                               var mensaje = "";
                                console.log(datos["RSocial"]);
                                console.log(datos["Dir"]);
                               /*var razon_social = (datos["RSocial"]);var direccion =(datos["Dir"]);var ubigeo =(datos["Ubigeo"]);var estado =(datos["Est"]);var CondDom =(datos["CondDom"]);*/
                               $("#NomproveedorP").val(datos["RSocial"]);
                               $("#direccionP").val(datos["Dir"]);
                               //$("#txtubigeo_organizacion").val(datos["Ubigeo"]);
                           }
                       }
                   },
                   error: function(data) {   },
                           async: false
               });
           }else{
               //$('.modal-msj').css('display','none');
               //bootbox.alert("Número de RUC incorrecto");
                /*$("#notifiaciones").addClass("alert alert-danger");
               document.getElementById("notifiaciones").innerHTML ="Número de RUC incorrecto" ;*/
           }
        }



    </script>
