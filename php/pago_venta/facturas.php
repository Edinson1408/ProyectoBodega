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
				data:{id_factura:factura},

				success:function(datos){
					$("#div_detalles").html(datos);
				}
			}

		)
}


</script>

<?php
error_reporting(0);
include('conexion.php');
$VAR_ID_CLIENTE=$_POST['id_cliente'];
$SQL_CLIENTE=mysql_query("SELECT * FROM CLIENTE WHERE RUC_CLIENTE='$VAR_ID_CLIENTE'",$conexion);
$ARR_CLIE=mysql_fetch_array($SQL_CLIENTE);
$VAR_NOM_CLIE=$ARR_CLIE['NOMBRE_C'];

$X=mysql_num_rows($SQL_CLIENTE);

if (isset($VAR_NOM_CLIE)) {
	echo "<center><h1>".$VAR_NOM_CLIE."</h1></center>";

	//SE MOSTRARA LAS BOLETAS QUE TIENE PENDIENTE
	$SQL_BOLETAS=mysql_query("SELECT * FROM FACTURA WHERE RUC_CLIENTE='$VAR_ID_CLIENTE' AND ESTADO='P'",$conexion);
	echo "<h2>Saldo pendiente</h2>";
	echo "<table border='1px'>";
	echo "<tr>";
	echo "<td>Boleta</td>";
	echo "<td>Fecha</td>";
	echo "<td>Cliente</td>";
	echo "<td>Total</td>";
	echo "<td>Saldo</td>";
	echo "<td></td>";	
	echo "</tr>";
	while ($ARRAY_BOLETA=mysql_fetch_array($SQL_BOLETAS)) 
	{
		$VAR_BOLETA=$ARRAY_BOLETA['NRO_FACTURA'];
		$FECHA_BOLETA=$ARRAY_BOLETA['FECHA_FACTURA'];
		echo "<tr>";
			echo "<td>".$ARRAY_BOLETA['NRO_FACTURA']."</td>";
			echo "<td>".$ARRAY_BOLETA['FECHA_FACTURA']."</td>";
			echo "<td id='cliente'>".$ARRAY_BOLETA['RUC_CLIENTE']."</td>";
			echo "<td>".$ARRAY_BOLETA['TOTAL']."</td>";
			echo "<td>".$ARRAY_BOLETA['SALDO']."</td>";
			echo "<td><a href='detalles.php?boleta=$VAR_BOLETA&fecha_bol=$FECHA_BOLETA'  target='miframe'>".$VAR_BOLETA."</a></td>";
			/*
			echo "<td><a href='pago.php?".$VAR_BOLETA."'>Ingresar Pagos</a></td>";
*/
		echo "</tr>";
	}
	

	echo "</table>";
?>
<iframe  src=""  AllowTransparency name="miframe" id="frame"  frameborder="0" margin="3" scrolling="auto" width="100%" height="900"></iframe> 

<?php
}
else
{
	echo "<center><h1>no Existe</h1></center>";
}

?>
