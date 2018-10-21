<?php
include('../../../conexion.php');
$n_fac=$_POST['factura'];
?>
<table border="1"> 
<tr>
	<td>Detalle boleta <?php  echo $n_fac ?></td>
</tr>
<tr>
<td width='120'>Boleta</td>
<td width='300'>Producto</td>
<td width='120'>Cantidad</td>
<td width='120'>Precio Unitario</td>
<td width='120'>Importe</td>
</tr>
<?php

// el detalle
$SQL_DETALLE=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO FROM DETALLE_FACTURA A , PRODUCTO B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND A.NRO_FACTURA='$n_fac'",$conexion);
while ($ARR_DETALLE=mysql_fetch_array($SQL_DETALLE)) {

?>



<tr>
<td width='120'><?php echo $ARR_DETALLE['NRO_FACTURA']; ?></td> 
<td width='120'><?php echo $ARR_DETALLE['NOMBRE_PRODUCTO']; ?></td>
<td width='120'><?php echo $ARR_DETALLE['CANTIDAD_PRODUCTO']; ?></td>
<td width='120'><?php echo $ARR_DETALLE['PRECIO_UNITARIO']; ?></td> 
<td width='120'><?php echo $ARR_DETALLE['IMPORTE'] ;?></td> 
</tr> 

<?php }
?>
</table> 