<?php
include('metodo_man_fac.php');
	$bje_man_fac=new mantenimiento_factura();
if (isset($_GET['fac'])) 
			{
			$VAR_FACTURA= $_GET['fac'];
			$serie= $_GET['serie'];
			$porvedor= $_GET['prove'];
			}

if (isset($_POST['fact'])) {
	 $VAR_FACTURA= $_POST['fact'];

	 
	$facturaXD=$_POST['fact'];
	
	$producto=$_POST['pro'];

	$cantidad_anterior=$_POST['cantidad_ante'];

	 $cantidad_nueva=$_POST['cantidad_actual'];
	 $precio_u=$_POST['precio_u'];

$bje_man_fac->actualizar_todo($facturaXD,$producto,$cantidad_nueva,$cantidad_anterior,$precio_u,$serie,$porvedor);


}



	$LISTA_DETA=$bje_man_fac->get_detalle($VAR_FACTURA);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
	<style type="text/css">
		.input-np{
			height: 0px;
		}
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
<a href="modificar_datos/modificar_datos.php?id=<?php echo $VAR_FACTURA; ?>">Modificar Datos</a>
<table class="table table-bordered">
	<tr>
		<th style="line-height: 10pt;">Factura</th>
		<th style="line-height: 10pt;">Producto</th>
		<th style="line-height: 10pt;">Cantidad</th>
		<th style="line-height: 10pt;">P.U</th>
		<th style="line-height: 10pt;">Importe</th>
		<th style="line-height: 10pt;">Actualizar</th>
	</tr>


<?php

	foreach ($LISTA_DETA as $DETALLE) 
		{
			echo "<form action='' method='POST'>";
			echo "<tr>";
				echo "<td style='line-height: 10pt;'>".$DETALLE['0']."</td>";
				echo "<td style='line-height: 10pt;'>".$DETALLE['6']."</td>";

				echo "<td style='line-height: 10pt;'><input tipe='text' name='cantidad_actual' value='".$DETALLE['2']."'></td>";
				echo "<td style='line-height: 10pt;'>".$DETALLE['3']."</td>";
				echo "<td style='line-height: 10pt;'>".$DETALLE['4']."</td>";
				echo "<td style='line-height: 10pt;'><input type='submit'  name='enviar' value='Modificar'></td>";
			echo "</tr>";
			//factura
				echo "<input tipe='text' class='input-np' name='fact' value='".$DETALLE['0']."' style='visibility:hidden'>";
			//producto
				echo "<input tipe='text' class='input-np' name='pro' value='".$DETALLE['1']."' style='visibility:hidden'>";
				//cantidad_anterior
				echo "<input tipe='text' class='input-np' name='cantidad_ante' value='".$DETALLE['2']."' style='visibility:hidden'>";
				//precio _unitario
				echo "<input tipe='text' class='input-np' name='precio_u' value='".$DETALLE['3']."' style='visibility:hidden'>";
			echo "</form>";
		}




/*$cod_producto='7750243045773';
$n='5';*/
//$bje_man_fac->disminuir_almacen($cod_producto,$n);
//$bje_man_fac->aumentar_almacen($cod_producto,$n);


?>
</table>
<a href="index.php">Regresar</a>
</div>
</body>
</html>

	
