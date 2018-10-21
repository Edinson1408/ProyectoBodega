<!DOCTYPE html>
<html>
<head>
	<title>Cierre Caja</title>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<style type="text/css">
	html, body{
        background: rgb(236,240,245);
    }
	.container{
	    width: 100%;
	}
	.table-striped{
		width: 98%;
		margin:auto; 
	}
	.titulo{
	    border-bottom: 2px solid #F2F2F2; 
	    margin-bottom: 5px;
    }
	</style>
</head>
<body>
<?php
include('../../conexion.php');
$n_fac=$_POST['factura'];
?>
<div class="container">
<div class="titulo" style="margin-left: 10px;">
	<h4>Detalle boleta <?php  echo $n_fac ?></h4>
</div>
<table class="table table-bordered">
<tr>
<th width='120' style="line-height: 7pt;">Boleta</th>
<th width='300' style="line-height: 7pt;">Producto</th>
<th width='120' style="line-height: 7pt;">Cantidad</th>
<th width='120' style="line-height: 7pt;">Precio Unitario</th>
<th width='120' style="line-height: 7pt;">Importe</th>
</tr>
<?php
// el detalle
$SQL_DETALLE=mysql_query("SELECT A.*,B.NOMBRE_PRODUCTO FROM DETALLE_BOLETA A , PRODUCTO B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND A.NRO_FACTURA='$n_fac'",$conexion);
while ($ARR_DETALLE=mysql_fetch_array($SQL_DETALLE)) {
?>
<tr>
<td width='120' style="line-height: 7pt;"><?php echo $ARR_DETALLE['NRO_FACTURA']; ?></td> 
<td width='120' style="line-height: 7pt;"><?php echo $ARR_DETALLE['NOMBRE_PRODUCTO']; ?></td>
<td width='120' style="line-height: 7pt;"><?php echo $ARR_DETALLE['CANTIDAD_PRODUCTO']; ?></td>
<td width='120' style="line-height: 7pt;"><?php echo $ARR_DETALLE['PRECIO_UNITARIO']; ?></td> 
<td width='120' style="line-height: 7pt;"><?php echo $ARR_DETALLE['IMPORTE'] ;?></td>
</tr> 
<?php }
?>
</table> 
</div>
</body>
</html>