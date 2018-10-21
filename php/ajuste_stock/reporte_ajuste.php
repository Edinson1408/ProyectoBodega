<?php
include("../../conexion.php")
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    	*{
    		padding: 3px;
    	}
    	input{
    		border-radius: 0;
    	}
    	.btn{
    		border-radius: 0;
    	}
    	th,td{
    		text-align: center;
    	}
    	.nota{
			padding-top: 10px;
			height: 50px;
		}
		#com{
			font-size: 2em;
		}
    </style>
</head>
<body>
<div class="container-fluid">
<h3>Boletas de Ajuste</h3>
<hr></hr>
<table class="table table-bordered">
	<tr>
		<th style='line-height: 10pt;'>Nro Ajuste</th>
		<th style='line-height: 10pt;'>Serie Ajuste</th>
		<th style='line-height: 10pt;'>Fecha</th>
		<th style='line-height: 10pt;'>Hora</th>
		<th style='line-height: 10pt;'>Total</th>
		<th style='line-height: 10pt;'>Encargado</th>
		<th style='line-height: 10pt;'>Eliminar</th>
		<th style='line-height: 10pt;'>Detalle</th>
	</tr>
	<?php
	$sql_ajuste=mysql_query("SELECT * FROM ajuste",$conexion);
	while ($arr_ajuste=mysql_fetch_array($sql_ajuste)) {
		echo "<tr>";
			echo "<td style='line-height: 10pt;'>".$arr_ajuste['NRO_FACTURA']."</td>";
			echo "<td style='line-height: 10pt;'>".$arr_ajuste['SERIE_FACTURA']."</td>";
			echo "<td style='line-height: 10pt;'>".$arr_ajuste['FECHA_FACTURA']."</td>";
			echo "<td style='line-height: 10pt;'>".$arr_ajuste['HORA_FACTURA']."</td>";
			echo "<td style='line-height: 10pt;'>".$arr_ajuste['TOTAL']."</td>";
			echo "<td style='line-height: 10pt;'>".$arr_ajuste['ENCARGADO']."</td>";
			?>
			<td style='line-height: 8pt;'><a href="cancelar.php?id=<?php echo $arr_ajuste['NRO_FACTURA'] ?>" onclick="return confirm('Desea Borrar Los Datos')">Cancelar</a></td>
			<td><a onclick="window.open('detalle_ajuste.php?id=<?php echo $arr_ajuste['NRO_FACTURA'];?>','ventana','width=640,height=480,left=350,top=150,scrollbars=NO,menubar=NO,resizable=NO,titlebar=NO,status=NO')";return false class="btn btn-default btn-xs" title="Detalle Ajuste"><i class="glyphicon glyphicon-list" aria-hidden="true"></i></a></td>
			<?php
		echo "</tr>";
	}
	?>
</table>
</div>
</body>
</html>