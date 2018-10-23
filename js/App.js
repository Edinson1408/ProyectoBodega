ValidaRuc=()=>{
    var url = "http://192.155.92.99/WebServices/ObtieneIPLocal/ws_ip.php";
    var ruc = $("#RUCDNI").val();
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
                        data = data.replace(/<br>/gi,'');

                        var datos   = JSON.parse(data);
                        var mensaje = "";

                        /*var razon_social = (datos["RSocial"]);var direccion =(datos["Dir"]);var ubigeo =(datos["Ubigeo"]);var estado =(datos["Est"]);var CondDom =(datos["CondDom"]);*/
                        $("#RazonSocial").val(datos["RSocial"]);
                        $("#direccion").val(datos["Dir"]);
                        //$("#txtubigeo_organizacion").val(datos["Ubigeo"]);
                    }
                }
            },
            error: function(data) {   },
                    async: false
        });
    }else{
        
    }
}
