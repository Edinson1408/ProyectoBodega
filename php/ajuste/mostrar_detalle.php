<?php
include("../../conexion.php");
session_start();
$_SESSION['fecha']=$_POST['fecha'];
$_SESSION['numero_fac']=$_POST['boleta'];
$_SESSION['numero_ser']=$_POST['serie'];
$VAR_N_BOLETA=$_POST['boleta'];
$SQL_FACTURA=mysql_query("SELECT * FROM AJUSTE WHERE NRO_FACTURA='$VAR_N_BOLETA'",$conexion);
$NUN_FAC=mysql_num_rows($SQL_FACTURA);
if ($NUN_FAC>0) {
	echo "SALIDA DE AJUSTE EXISTENTE";	
}
else { 
?>
<li>
<a href="ingresar_datos.php" target="miframe"><i class="fa fa-circle-thin" aria-hidden="true"></i>Click para ingresar el detalle</a>
</li>
<iframe  src=""  AllowTransparency name="miframe" id="frame" frameborder="0" margin="3" scrolling="auto" width="100%" height="500px"></iframe>   
<?php   
}
?>
</body>