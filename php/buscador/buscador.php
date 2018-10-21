<?php
include ('../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Buscador de Boletas</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
<div class="col-xs-12">
<h3>Cancelar boleta</h3>
<hr></hr>
</div>
<!--********************************************************************************-->
<form action="buscador.php" method="POST">
<div class="col-xs-3">
  <input type="text" class="form-control input-sm" name="buscar" placeholder="Nro boleta" aria-label="Recipient's username" aria-describedby="basic-addon2">
</div>
<div class="col-xs-4">
  <input type="submit" name="enviar" class="btn btn-primary btn-sm" value="Buscar">
</div>
</form>
<!--********************************************************************************-->
<div class="col-xs-12">
<div class="divider">
</div>
<table class="table table-bordered">
	<tr>
		<th style='line-height: 6pt; width: 10px;'>Boleta</th>
		<th style='line-height: 6pt;'>Encargado</th>
		<th style='line-height: 6pt;'>Fecha</th>
		<th style='line-height: 6pt;'>Hora</th>
		<th style='line-height: 6pt;'>Total</th>
		<th style='line-height: 6pt;'>Cancelar Boleta</th>
	</tr>
	<?php
	error_reporting(0);
	$filtro=$_POST['buscar'];
	if (isset($_POST['enviar'])) {
		$sql_boleta=mysql_query("SELECT * FROM boleta WHERE NRO_FACTURA='$filtro'",$conexion);
		while ($array_boleta=mysql_fetch_array($sql_boleta)) {
			echo "<tr>
					<td style='line-height: 8pt; width: 10px;'>".$array_boleta['NRO_FACTURA']."</td>
					<td style='line-height: 8pt;'>".$array_boleta['ENCARGADO']."</td>
					<td style='line-height: 8pt;'>".$array_boleta['FECHA_FACTURA']."</td>
					<td style='line-height: 8pt;'>".$array_boleta['HORA_FACTURA']."</td>
					<td style='line-height: 8pt;'>S/.".$array_boleta['TOTAL']."</td>";
				?>
					<td style='line-height: 8pt;'><a href="cancelar.php?id=<?php echo $array_boleta['NRO_FACTURA'] ?>" onclick="return confirm('Desea Borrar Los Datos')">Cancelar</a></td>
				<?php
				echo "<tr>";
		}
	}
	if (!isset($_POST['enviar'])) {
		$sql_boleta=mysql_query("SELECT * FROM boleta",$conexion);
		while ($array_boleta=mysql_fetch_array($sql_boleta)) {
			echo "<tr>
					<td style='line-height: 8pt; width: 10px;'>".$array_boleta['NRO_FACTURA']."</td>
					<td style='line-height: 8pt;'>".$array_boleta['ENCARGADO']."</td>
					<td style='line-height: 8pt;'>".$array_boleta['FECHA_FACTURA']."</td>
					<td style='line-height: 8pt;'>".$array_boleta['HORA_FACTURA']."</td>
					<td style='line-height: 8pt;'>S/.".$array_boleta['TOTAL']."</td>";
				?>
					<td style='line-height: 8pt;'><a href="cancelar.php?id=<?php echo $array_boleta['NRO_FACTURA'] ?>" onclick="return confirm('Desea borrar la boleta <?php echo $array_boleta['NRO_FACTURA']?>')">Cancelar</a></td>
				<?php
				echo "<tr>";
		}
	}
	?>
</table>
<!--********************************************************************************-->
</div>
</div>
</body>
<!--script type="text/javascript">	
function alerta()
    {
    var mensaje;
    var opcion = confirm("Clicka en Aceptar o Cancelar");
    if (opcion == true) {
        mensaje = "Has clickado OK";
	} else {
	    mensaje = "Has clickado Cancelar";
	}
	document.getElementById("ejemplo").innerHTML = mensaje;
}
</script-->
</html>