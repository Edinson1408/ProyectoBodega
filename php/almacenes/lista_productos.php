<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    	blockquote{
			border-left: 5px solid #b54848;
		}
		.cotainer{
			width: 80%;
		}
    </style>
</head>
<body>
<div class="container">
<BLOCKQUOTE>
<h3>Productos</h3><br>
</BLOCKQUOTE>
<table class="table table-bordered">
	<tr>
		<th>Tipo</th>
		<th>Producto</th>
		<th>Precio</th>
		<?php
		include('../../conexion.php');
		$sql_lista=mysql_query("SELECT A.*,B.CLASE_PRODUCTO AS CLAS FROM PRODUCTO AS A, clasificacion_producto AS B WHERE A.CLASE_PRODUCTO=B.COD_CLASIFICACION",$conexion);
		while ($fi=mysql_fetch_array($sql_lista)) {
			echo "<tr>";
				echo "<td>".$fi['CLAS']."</td>";
				echo "<td>".$fi['NOMBRE_PRODUCTO']."</td>";
				echo "<td>".$fi['PRECIO_UNITARIO']."</td>";
			echo "</tr>";
		}
		?>
	</tr>

</table>
</div>
</body>
</html>