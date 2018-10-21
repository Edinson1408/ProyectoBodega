<!DOCTYPE html>
<html>
<head>
	<title>Cliente</title>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<link href="../../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	html{
		padding: 15px;
	}
	.nota{
		padding-top: 10px;
		height: 50px;
		border-bottom: 3px solid #337ab7;
	}
	#com{
		font-size: 2em;
	}
	.container{
		width: 100%;
	}
	</style>
</head>
<body>
<div class="container"
><div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Cliente</i>
	<a href="reg_cli.php" style="float: right;" class="btn btn-primary">AgregarCliente</a>
	<form action="Cliente.php" method="POST">
	<!--div class="input-group">
    <input type="text" name="buscar" class="form-control" style="float: right; right:10px; width: 30%;  bottom: 28px;">
    <span class="input-group-btn">
    <input type="submit" name="enviar" class="btn btn-default" style="bottom: 28px; right:10px;" value="Buscar">
    </span>
    </div-->
    </form>
</div>
	<table class="table table-bordered">
		<tr>
			<th>RUC-DNI</th>
			<th>Cliente</th>
			<th>Dirección</th>
			<th>Telefono</th>
			<th>Correo</th>
			<th colspan="4">Acciones</th>
		</tr>
		<?php
		include('../../seguridad1.php');
			include('../../../conexion.php');
			error_reporting(0);
			$buscar=$_POST['buscar'];
			if (isset($_POST['enviar'])) {
			$sql_pro=mysql_query("SELECT * FROM cliente_1 where NOMBRE_C '$buscar'",$conexion);
			while ($r=mysql_fetch_array($sql_pro)) {
				echo "<tr>";
					echo "<td>".$r['RUC_DNI']."</td>";
					echo "<td>".$r['NOMBRE_C']."</td>";
					echo "<td>".$r['DIR_CLI']."</td>";
					echo "<td>".$r['TEL_CLIE']."</td>";
					echo "<td>".$r['CORRE_CLI']."</td>";
			?>
			  <td><a href="modificar.php?id=<?php echo $r['RUC_DNI'];?>" class="btn btn-default btn-xs" title="Editar Cliente"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i></a></td>
			  <td><a href="eliminar.php?id=<?php echo $r['RUC_DNI'];?>" class="btn btn-default btn-xs" title="Eliminar Cliente"><i class="glyphicon glyphicon-remove-circle" aria-hidden="true"></i></a></td>
			<?php
			  echo "</tr>";
			}
			}
			if (!isset($_POST['enviar'])) {
			$sql_pro=mysql_query("SELECT * FROM cliente_1 order by NOMBRE_C ASC",$conexion);
			while ($r=mysql_fetch_array($sql_pro)) {
				echo "<tr>";
					echo "<td>".$r['RUC_DNI']."</td>";
					echo "<td>".$r['NOMBRE_C']."</td>";
					echo "<td>".$r['DIR_CLI']."</td>";
					echo "<td>".$r['TEL_CLIE']."</td>";
					echo "<td>".$r['CORRE_CLI']."</td>";
			?>
			  <td><a href="modificar.php?id=<?php echo $r['RUC_DNI'];?>" class="btn btn-default btn-xs" title="Editar Cliente"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i></a></td>
			  <td><a href="eliminar.php?id=<?php echo $r['RUC_DNI'];?>" class="btn btn-default btn-xs" title="Eliminar Cliente"><i class="glyphicon glyphicon-remove-circle" aria-hidden="true"></i></a></td>
			<?php
			  echo "</tr>";
			}
			}
		?>
	</table>
</div>
</body>
</html>