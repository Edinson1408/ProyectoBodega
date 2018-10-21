<?php
include("../../conexion.php");
session_start();
$_SESSION['pagos']=$_POST['pagofac'];

if (isset($_POST['btn'])) {
	$RUC=$_POST['ruc'];
	$CLIENTE=$_POST['cliente'];
	$NRO_EJE=$_POST['num_eje'];
	$NOM_EJE=$_POST['ejecutivo'];
	$DIR=$_POST['direccion'];
	$TELE=$_POST['telefono'];
	$EMAIL=$_POST['email'];
	mysql_query("INSERT INTO CLIENTE VALUES ('$RUC','$CLIENTE','$NRO_EJE','$NOM_EJE','$DIR','$TELE','$EMAIL')",$conexion);
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
$_SESSION['pagos']=$_POST['pagofac'];

$VAR_CLIE=$_POST['cliente'];
$SQL2_CLI=mysql_query("SELECT * FROM CLIENTE WHERE RUC_CLIENTE='".$VAR_CLIE."'",$conexion);
$NUM_CLIE=mysql_num_rows($SQL2_CLI);
$ARR2_CLI=mysql_fetch_array($SQL2_CLI);
$ARR2_CLI['NOMBRE_CLIENTE'];
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
<div class="card" style="width: 20em;">
   <div class="card-body">
    <h4 class="card-title">Agregar nuevo Proveedor</h4>

RUC: <input class="form-control input-sm" type="text" id="ruc" value="<?php echo $VAR_CLIE; ?>">
Nombre <input class="form-control input-sm" type="text" id="nombre">
N° Ejecutivo <input class="form-control input-sm" type="text" id="nr_eje">
Nombre Ejecutivo <input class="form-control input-sm" type="text" id="no_eje">
Direccion <input class="form-control input-sm" type="text" id="dir">
Telefono <input class="form-control input-sm" type="text" id="tel">
E-mail<input class="form-control input-sm" type="text" id="email">
<input type="submit" class="btn btn-primary" id="enviar" value="Agregar" onclick="agregar_clie();">	

  </div>
</div>
</div>
<?php
}


//para agregar tiene que haber si o si el cliente o proveedor 
// si exite tipo documento , serie , numero , cliente y fecha , entonces
//mostraremos el detalle 

// dando la opcion se se muestra los detalles XD
$_SESSION['numero_fac']=$_POST['ndoc'];
$_SESSION['serie']=$_POST['serie'];

 $VAR_N_FAC=$_POST['ndoc'];
 $VAR_SERIE=$_POST['serie'];

 /****Decalrando las sessiones para nro_fac y serie ***/

$SQL_FACTURA=mysql_query("SELECT * FROM FACTURA WHERE NRO_FACTURA='$VAR_N_FAC' AND SERIE_FACTURA='$VAR_SERIE' AND RUC_CLIENTE='$VAR_CLIE'",$conexion);

$NUN_FAC=mysql_num_rows($SQL_FACTURA);
if ($NUN_FAC>0) {
	//IMFORMACION DE DICHA FACTURA Xd (AQUI CHAMBEA PAPAU SOLO LLAMA A LA TABLA FACTURA)

	//DETALLE DE DICHA FACTURA 
	$VAR_IMPOTE=0;
echo"<div class='container'>";
echo"<table class='table table-bordered' >";
	echo "<tr>";
		echo "<td>FACTURA</td>";
		echo "<td>PRODUCTO</td>";
		echo "<td>CANTIDAD</td>";
		echo "<td>PRECIO UNITARIO</td>";
		echo "<td>IMPORTE</td>";
	echo "<tr>";
	$SQL_D_FACTURA=mysql_query("SELECT * FROM DETALLE_FACTURA WHERE NRO_FACTURA='$VAR_N_FAC'",$conexion);
	while ($ARRAY_D_FACTURA=mysql_fetch_array($SQL_D_FACTURA)) {
		echo "<tr>";
			echo "<td>".$ARRAY_D_FACTURA['NRO_FACTURA']."</td>";
			echo "<td>".$ARRAY_D_FACTURA['COD_PRODUCTO']."</td>";
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
			$VAR_IGV=$VAR_IMPOTE*0.18;
			echo "<td><td>";
			echo "<td>IGV<td>";
			echo "<td>".$VAR_IGV."<td>";
		echo "</tr>";
		echo "<tr>";
			$VAR_TOTAL=$VAR_IMPOTE+$VAR_IGV;
			echo "<td><td>";
			echo "<td>TOTAL<td>";
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


	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../bootstrap/js/bootstrap.js"></script>
<iframe  src=""  AllowTransparency name="miframe" id="frame" frameborder="0" margin="3" scrolling="auto" width="100%" height="500px"></iframe>   

<?php  }  }






}


?>
