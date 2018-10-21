<?php
include('conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	
	<title>Pago de Boleta de venta </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
	<script type="text/javascript" src='jquery-3.2.1.min.js'></script>
	<script type="text/javascript" src='js/bootstrap.js'></script>
	<style type="text/css">
	    *{
	        margin: 0;
	        padding: 0;
	    }
	    html, body{
	        background: rgb(236,240,245);
	    }
	    .titulo{
        border-bottom: 0.5px solid #F2F2F2; 
        margin-bottom: 5px;
    	}
		.container{
			width: 100%;
		}
		#panel1{
		 	border-top: 3px solid #5D6D7E  ;
		 	background: #ffffff;
		 	padding: 10px;
		 	margin-bottom: 10px;
		}
	</style>

<script type="text/javascript">
	function verificar(){
	var cliente=document.getElementById("clie").value;
	var url="boletas.php";

	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{id_cliente:cliente},

				success:function(datos){
					$("#div_ajax").html(datos);
				}
			}

		)
}
</script>
</head>
<body>
<div class="container">
<div class="nota">
    <h3>Modulo de pago</h3>
</div>
<div class="panel panel-default" id="panel1">
<div class="titulo" style="margin-left: 10px">
    <h4>Buscar cliente</h4>
</div>
<div class="row">
<div class="col-md-4">
Cliente: <input list="cliente" id="clie"   onkeyup="verificar()" >
					<datalist id="cliente">
					  <?php
					  	$SQL_CLIENTE=mysql_query("SELECT A.RUC_DNI ,A.NOMBRE_C FROM CLIENTE_1 A , BOLETA B WHERE A.RUC_DNI=B.RUC_CLIENTE AND ESTADO='P'",$conexion);
					  	while ($ARR_CLI=mysql_fetch_array($SQL_CLIENTE)) {
					  		echo "<option value='".$ARR_CLI['RUC_DNI']."'>".$ARR_CLI['NOMBRE_C']."</option>";
					  	}
					  ?>
					</datalist>
</div>
</div>
</div>
<div id="div_ajax">
</div>
</div>
</body>
</html>