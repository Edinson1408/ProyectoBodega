<?php
include('../../seguridad1.php');
include('../../../conexion.php');
$id=$_REQUEST['id'];
$e=$_POST['cod'];
$a=$_POST['nom'];
$b=$_POST['precio'];
$c=$_POST['precio_ve'];
$d=$_POST['tipo'];
mysql_query("UPDATE producto SET COD_PRODUCTO='$e', NOMBRE_PRODUCTO='$a', PRECIO_UNITARIO='$b', PRECIO_VENTA='$c', CLASE_PRODUCTO='$d' where COD_PRODUCTO='$id'",$conexion);
mysql_query("UPDATE almacen SET COD_PRODUCTO='$e', COD_CLASIFICACION='$d' where COD_PRODUCTO='$id'",$conexion);
header('location:index.html');
?>