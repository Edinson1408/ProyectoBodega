<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
		<script type="text/javascript" src='jquery-3.2.1.min.js'></script>
		<script type="text/javascript" src='js/bootstrap.js'></script>
	<script type="text/javascript">
		function verificar_boleta(){
		var boleta=document.getElementById("boton").value
		

		var url="detalles.php";

		//llego la hora de ajax
		$.ajax(
				{
					type:"post",
					url:url,
					data:{id_boleta:boleta},

					success:function(datos){
						$("#div_detalles").html(datos);
					}
				}

			)
	}
	</script>
	<style type="text/css">
	    *{
	        margin: 0;
	        padding: 0;
	    }
	    html, body{
	        background: rgb(236,240,245);
	    }
		.container{
			width: 100%;
		}
		#panel2{
		    border-top: 3px solid #5D6D7E  ;
			background: #ffffff;
		 	padding: 10px;
		}
	</style>
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-7">
<div class="panel panel-default" id="panel2">
<?php
error_reporting(0);
include('conexion.php');
$VAR_ID_CLIENTE=$_POST['id_cliente'];
$SQL_CLIENTE=mysql_query("SELECT * FROM CLIENTE_1 WHERE RUC_DNI='$VAR_ID_CLIENTE'",$conexion);
$ARR_CLIE=mysql_fetch_array($SQL_CLIENTE);
$VAR_NOM_CLIE=$ARR_CLIE['NOMBRE_C'];

$X=mysql_num_rows($SQL_CLIENTE);

if (isset($VAR_NOM_CLIE)) {
	echo "<h4>".$VAR_NOM_CLIE."</h4>";

	//SE MOSTRARA LAS BOLETAS QUE TIENE PENDIENTE
	$SQL_BOLETAS=mysql_query("SELECT * FROM BOLETA WHERE RUC_CLIENTE='$VAR_ID_CLIENTE' AND ESTADO='P'",$conexion);
	echo "<h2>Saldo pendiente</h2>";
	echo "<table class='table table-bordered'>";
	echo "<tr>";
	echo "<td style='line-height: 5pt;'>Boleta</td>";
	echo "<td style='line-height: 5pt;'>Fecha</td>";
	echo "<td style='line-height: 5pt;'>Cliente</td>";
	echo "<td style='line-height: 5pt;'>Total</td>";
	echo "<td style='line-height: 5pt;'>Saldo</td>";
	echo "<td style='line-height: 5pt;'></td>";	
	echo "</tr>";
	while ($ARRAY_BOLETA=mysql_fetch_array($SQL_BOLETAS)) 
	{
		$VAR_BOLETA=$ARRAY_BOLETA['NRO_FACTURA'];
		$FECHA_BOLETA=$ARRAY_BOLETA['FECHA_FACTURA'];
		echo "<tr>";
			echo "<td style='line-height: 5pt;'>".$ARRAY_BOLETA['NRO_FACTURA']."</td>";
			echo "<td style='line-height: 5pt;'>".$ARRAY_BOLETA['FECHA_FACTURA']."</td>";
			echo "<td style='line-height: 5pt;' id='cliente'>".$ARRAY_BOLETA['RUC_CLIENTE']."</td>";
			echo "<td style='line-height: 5pt;'>".$ARRAY_BOLETA['TOTAL']."</td>";
			echo "<td style='line-height: 5pt;'>".$ARRAY_BOLETA['SALDO']."</td>";
			echo "<td style='line-height: 5pt;'><a href='detalles.php?boleta=$VAR_BOLETA&fecha_bol=$FECHA_BOLETA'  target='miframe'>".$VAR_BOLETA."</a></td>";
			/*
			echo "<td><a href='pago.php?".$VAR_BOLETA."'>Ingresar Pagos</a></td>";
*/
		echo "</tr>";
	}
	

	echo "</table>";
?>
</div>
</div>

<div class="col-md-5">
<iframe  src=""  AllowTransparency name="miframe" id="frame"  frameborder="0" margin="0" padding="0" scrolling="auto" width="100%" height="500"></iframe> 
</div>
<?php
}
else
{
	echo "<h3>no Existe</h3>";
}

?>
</div>
</div>
</body>
</html>