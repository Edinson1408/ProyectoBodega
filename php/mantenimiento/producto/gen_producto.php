<?php
include('../../../conexion.php');
function gen_cod($e)
{	
	$consulta=mysql_query("SELECT COD_PRODUCTO from $e  ORDER BY COD_PRODUCTO DESC limit 1");
	$f=mysql_fetch_array($consulta);
	$cod=$f['COD_PRODUCTO'];
	$re = substr($cod,0,3);
	$r = substr($cod,5,5);
	$n = (int)$r; 
	$rr=substr($cod,4,6);
	$nn=(int)$rr;

	$n1 = substr($cod,3,5);
	$np=(int)$n1;
if ($n<10 and $nn<9 and  $np<100) {
	$ncod=$re."00".$n+=1;
	return $ncod;
	}
if ($n<100 and $nn<99 and $np<100 ) {
	$ncod=$re."0".$nn+=1;
	return $ncod;
}
if ($n<1000 and $nn<999 and $np>=100){
	$ncod=$re.$np+=1;
	return $ncod;
}
if ($n<100 and $nn<99) {
	$ncod=$re."0".$nn+=1;
	return $ncod;
}
else{
	$ncod=$re.$nn+=1;
	return $ncod;
}
}
?>