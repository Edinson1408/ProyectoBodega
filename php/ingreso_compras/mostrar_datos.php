<?php
include ('../seguridad.php');
include("../../conexion.php");

if (isset($_POST['n_cliente'])) {

$CLIENTE=$_POST['n_cliente'];
$SQL_PRO=mysql_query("SELECT * FROM CLIENTE WHERE RUC_CLIENTE='$CLIENTE'",$conexion);
$ARR_PRO=mysql_fetch_array($SQL_PRO);
?>
<input type="text" name="" value="<?php ECHO $ARR_PRO['NOMBRE_CLIENTE'];  ?>" disabled>
<?php	
}
?>


<?php
if (isset($_POST['n_producto'])) {
	$VAR_PRO=$_POST['n_producto'];
	$SQL_PRODUCTO=mysql_query("SELECT * FROM PRODUCTO WHERE COD_PRODUCTO='$VAR_PRO'",$conexion);
	$ARR_PRODUCTO=mysql_fetch_array($SQL_PRODUCTO);
?>
<input type="text" name="" value="<?php ECHO $ARR_PRODUCTO['NOMBRE_PRODUCTO'];  ?>" disabled>

<?php
}
?>


