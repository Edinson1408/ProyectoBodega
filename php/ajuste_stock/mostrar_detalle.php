<?php
include("../../conexion.php");
session_start();
$var_fecha=$_POST['fecha'];
$var_serie=$_POST['serie'];
$var_boleta=$_POST['boleta'];

$_SESSION['fec']=$_POST['fecha'];
$_SESSION['ser']=$_POST['serie'];
$_SESSION['bol']=$_POST['boleta'];

$SQL_AJUSTE=mysql_query("SELECT * FROM AJUSTE WHERE NRO_fACTURA='$var_boleta'",$conexion);
$NUM_AJUSTE=mysql_num_rows($SQL_AJUSTE);
if ($NUM_AJUSTE>0) {
	echo "Numero de ajuste existente";
}
else{
?>
<a href="ingresar_datos.php" target="miframe"><i class="fa fa-circle-thin" aria-hidden="true"></i>Click para ingresar el detalle</a>
</li>
<iframe  src=""  AllowTransparency name="miframe" id="frame" frameborder="0" margin="3" scrolling="auto" width="100%" height="500px"></iframe> 
<?php 	
}
?>