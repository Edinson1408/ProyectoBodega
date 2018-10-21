<?php
include("../../conexion.php");
session_start();
$_SESSION['estado']=$_POST['nestado'];
if (isset($_POST['btn'])) {
	$RUC=$_POST['ruc'];
	$CLIENTE=$_POST['cliente'];
	$DIR=$_POST['direccion'];
	$TELE=$_POST['telefono'];
	$EMAIL=$_POST['email'];
	mysqli_query($conexion,"INSERT INTO CLIENTE_1 VALUES ('$RUC','$CLIENTE','$DIR','$TELE','$EMAIL')");
	echo "se agrego corectamente verifique nuevamente" ;
}
else
	{ 



/* por el momento no usaremos esto por que josue no lo a grabajado 
echo $DOCUMENTO=$_POST['documento'];
echo "<br>";
$SQL2_DOC=mysql_query("SELECT * FROM DOCUMENTO WHERE COD_DOCUMENTO='$DOCUMENTO'",$conexion);
$ARR2_DOC=mysql_fetch_array($SQL2_DOC);
echo $ARR2_DOC['NOMBRE_DOC']."<BR>";
*/
/*session del cliente XD para mantener el ruc pues perro XD*/
$_SESSION['cliente']=$_POST['cliente'];

/* La fecha como sesscion*/
$_SESSION['fecha']=$_POST['fecha'];


$VAR_CLIE=$_POST['cliente'];
$SQL2_CLI=mysqli_query($conexion,"SELECT * FROM CLIENTE_1 WHERE RUC_DNI='".$VAR_CLIE."'");
$NUM_CLIE=mysqli_num_rows($SQL2_CLI);
$ARR2_CLI=mysqli_fetch_array($SQL2_CLI);
$ARR2_CLI['NOMBRE_C'];
//*SESSION NOBRE DEL CLIENTE */
$_SESSION['N_CLIENTE']=$ARR2_CLI['NOMBRE_C'];
if ($NUM_CLIE<1) { ?>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src='js/jquery-3.2.1.min.js'></script>
	<style type="text/css">
		.card{
			margin-top: 50px;
			float: left;
			border: 3px solid #e2e2e2;
			padding: 10px;
			-webkit-box-shadow:-2px -2px 9px 0px rgba(0, 2, 0, 1);
			-moz-box-shadow:2px -2px 9px 0px rgba(0, 2, 0, 1);
			box-shadow:-2px -2px 9px 0px rgba(0, 2, 0, 1);

		}
		input{
			margin: 0;
		}

	</style>
		<script>
		function sf(ID){
		document.getElementById(ID).focus();
		}
</script>
<body onload="sf('link');">
<div class="card" style="width: 20em;">
   <div class="card-body">
	<h4 class="card-title">Ingresar nuevo Cliente</h4>

RUC: <input type="text" class="form-control input-sm" id="ruc" value="<?php echo $VAR_CLIE; ?>">
Nombre <input type="text" class="form-control input-sm" id="nombre">
Direccion <input type="text" class="form-control input-sm" id="dir" value="NA">
Telefono <input type="text" class="form-control input-sm" id="tel" value="NA">
E-mail<input type="text" class="form-control input-sm" id="email" value="NA">
<input type="submit" id="enviar" class="btn btn-primary" value="Agregar" onclick="agregar_clie();">	
</div>
</div>
</div>
<?php
}


//para agregar tiene que haber si o si el cliente o proveedor 
// si exite tipo documento , serie , numero , cliente y fecha , entonces
//mostraremos el detalle 

// dando la opcion se se muestra los detalles XD
$_SESSION['numero_fac']=$_POST['boleta'];


 $VAR_N_BOLETA=$_POST['boleta'];


 /****Decalrando las sessiones para nro_fac y serie ***/

$SQL_FACTURA=mysqli_query($conexion,"SELECT * FROM BOLETA WHERE NRO_FACTURA='$VAR_N_BOLETA' AND SERIE_FACTURA='001' AND RUC_CLIENTE='$VAR_CLIE'");

$NUN_FAC=mysqli_num_rows($SQL_FACTURA);
if ($NUN_FAC>0) {
	//IMFORMACION DE DICHA FACTURA Xd (AQUI CHAMBEA PAPAU SOLO LLAMA A LA TABLA FACTURA)

	//DETALLE DE DICHA FACTURA 
	$VAR_IMPOTE=0;
echo"<div class='container'>";
echo"<table class='table table-bordered' >";
		echo "<td>BOLETA</td>";
		echo "<td>PRODUCTO</td>";
		echo "<td>CANTIDAD</td>";
		echo "<td>PRECIO UNITARIO</td>";
		echo "<td>IMPORTE</td>";
	echo "<tr>";
	$SQL_D_FACTURA=mysqli_query($conexion,"SELECT A.*, B.NOMBRE_PRODUCTO AS PRODUCTO FROM DETALLE_BOLETA AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND NRO_FACTURA='$VAR_N_BOLETA'");
	while ($ARRAY_D_FACTURA=mysqli_fetch_array($SQL_D_FACTURA)) {
		echo "<tr>";
			echo "<td>".$ARRAY_D_FACTURA['NRO_FACTURA']."</td>";
			echo "<td>".$ARRAY_D_FACTURA['PRODUCTO']."</td>";
			echo "<td>".$ARRAY_D_FACTURA['CANTIDAD_PRODUCTO']."</td>";
			echo "<td>".$ARRAY_D_FACTURA['PRECIO_UNITARIO']."</td>";
			echo "<td>".$ARRAY_D_FACTURA['IMPORTE']."</td>";
		echo "</tr>";
	//EL IMPORTE LO VOY A COMULANDO , 	
		$VAR_IMPOTE=$VAR_IMPOTE+$ARRAY_D_FACTURA['IMPORTE'];
	}
		echo "<tr>";
			echo "<td><td>";
			echo "<td>Sub Total<td>";
			echo "<td>".$VAR_IMPOTE."<td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><td>";
			echo "<td>IGV<td>";
			$VAR_IGV=$VAR_IMPOTE*0.18;
			echo "<td>".$VAR_IGV."<td>";
		echo "</tr>";
		echo "<tr>";
			echo "<td><td>";
			echo "<td>TOTAL<td>";
			$VAR_TOTAL=$VAR_IMPOTE+$VAR_IGV;
			echo "<td>".$VAR_TOTAL."<td>";
		echo "</tr>";
echo"</table>";
echo"</div>";
	
}
else { 

if ($NUM_CLIE==1) {
	



	?>
<li>
<a href="ingresar_datos.php" target="miframe"><i class="fa fa-circle-thin" aria-hidden="true"></i>Click para ingresar el detalle</a>
</li>



<iframe  src=""  AllowTransparency name="miframe" id="frame" frameborder="0" margin="3" scrolling="auto" width="100%" height="500px"></iframe>   

<?php  }  }






}


?>
</body>