<?php
include('../../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mantenimiento de Facturas</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<style type="text/css">
	*{
		padding: 0;
		margin: 0;
	}
	table,th,td{
		text-align: center;
	}
	.divider{
		height:20px;
	}
	</style>
</head>
<body>
<div class="container-fluid">
<h3>Mantenimiento Factura</h3>
<hr></hr>
</div>
<form action="lista_facturas.php" method="POST">
<div class="col-xs-3">
  <input type="text" class="form-control input-sm" name="buscar" placeholder="Nro boleta" aria-label="Recipient's username" aria-describedby="basic-addon2">
</div>
<div class="col-xs-4">
  <input type="submit" name="enviar" class="btn btn-primary btn-sm" value="Buscar">
</div>
</form>
<div class="col-xs-12">
<div class="divider">
</div>
<table class="table table-bordered">
	<tr>
		<th style='line-height: 8pt;'>Serie</th>
		<th style='line-height: 8pt;'>Factura</th>
		<th style='line-height: 8pt;'>Fecha</th>
		<th style='line-height: 8pt;'>Total</th>
		<th colspan="3" style='line-height: 8pt;'>Acciones</th>
	</tr>
	<?php
	error_reporting(0);
	$filtro=$_POST['buscar'];
	if (isset($_POST['enviar'])) {
	$sql_factura=mysql_query("SELECT * FROM FACTURA WHERE NRO_FACTURA='$filtro'",$conexion);
	while ($arr_fac=mysql_fetch_array($sql_factura)) {
		echo "<tr>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['SERIE_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['NRO_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['FECHA_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['TOTAL']."</td>";
			echo "<td style='line-height: 8pt;'><a href='modificar_datos/modificar_datos.php?id=".$arr_fac['NRO_FACTURA']."'>Modificar</a></td>";
			echo "<td style='line-height: 8pt;'><a href='agregar_datos/agregar_producto.php?id=".$arr_fac['NRO_FACTURA']."'>Agregar</a></td>";
	?>
	<td style='line-height: 8pt;'><a href="eliminar/eliminar_factura.php?id=<?php echo $arr_fac['NRO_FACTURA'] ?>" onclick="return confirm('Desea borrar la factura <?php echo $arr_fac['NRO_FACTURA']?>')">Eliminar</a></td>
	<?php
		echo "</tr>";
	}
	}
	if (!isset($_POST['enviar'])) {
	$sql_factura=mysql_query("SELECT * FROM FACTURA",$conexion);
	while ($arr_fac=mysql_fetch_array($sql_factura)) {
		echo "<tr>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['SERIE_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['NRO_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['FECHA_FACTURA']."</td>";
			echo "<td style='line-height: 8pt;'>".$arr_fac['TOTAL']."</td>";
			echo "<td style='line-height: 8pt;'><a href='modificar_datos/modificar_datos.php?id=".$arr_fac['NRO_FACTURA']."'>Modificar</a></td>";
			echo "<td style='line-height: 8pt;'><a href='agregar_datos/agregar_producto.php?id=".$arr_fac['NRO_FACTURA']."'>Agregar</a></td>";
	?>
			<td style='line-height: 8pt;'><a href="eliminar/eliminar_factura.php?id=<?php echo $arr_fac['NRO_FACTURA'] ?>" onclick="return confirm('Desea borrar la factura <?php echo $arr_fac['NRO_FACTURA']?>')">Eliminar</a></td>
	<?php
		echo "</tr>";
	}
	}
	?>
</table>
</div>
</div>
</body>
	<script src='../../../js/sweetalert.min.js'></script>
	<script src='../../../js/jquery-3.2.1.min.js'></script>
	<script src="../../../bootstrap/js/bootstrap.min.js"></script>
	<script src="../../../bootstrap/js/bootstrap.js"></script>
	<script src="../../../js/main.js"></script>
	<script src="../../../js/jquery.mCustomScrollbar.concat.min.js"></script>
</html>