<?php
$conexion=mysql_connect('localhost','root','1234');
if (!$conexion) 
echo "error";
$bd=mysql_select_db('bodega',$conexion);
if (!$bd) 
echo "error";
/*else
	echo "todo bien banda";*/
?>