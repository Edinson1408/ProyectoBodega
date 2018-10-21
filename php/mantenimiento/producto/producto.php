<?php
$mysqli = new mysqli("localhost","root","1234","bodega");
$salida="";
$query="SELECT a.*, b.CLASE_PRODUCTO AS NOMBRE FROM producto as a, clasificacion_producto as b WHERE a.CLASE_PRODUCTO=b.COD_CLASIFICACION";
if (isset($_POST['consulta'])) {
	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT a.*, b.CLASE_PRODUCTO AS NOMBRE FROM producto as a, clasificacion_producto as b WHERE a.CLASE_PRODUCTO=b.COD_CLASIFICACION AND a.NOMBRE_PRODUCTO LIKE '%".$q."%'";
}

$resultado = $mysqli->query($query);

if ($resultado->num_rows > 0) {
	$salida.="<table class='table table-bordered'>
				<thead>
					<tr>
						<th>Tipo</th>
						<th>Producto</th>
						<th>Precio de compra</th>
						<th>Precio de venta</th>
						<th colspan='4'>Acciones</th>
					</tr>
				</thead>
			    <tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.="<tr>
					<td>".$fila['NOMBRE']."</td>
					<td>".$fila['NOMBRE_PRODUCTO']."</td>
					<td>".$fila['PRECIO_UNITARIO']."</td>
					<td>".$fila['PRECIO_VENTA']."</td>
					<td><a href='modificar.php?id=".$fila['COD_PRODUCTO']."'>Modificar</a></td>	
					<td><a href='eliminar.php?id=".$fila['COD_PRODUCTO']."'>Eliminar</a></td>			
				</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron datos";
}
?>
<?php
echo $salida;
$mysqli->close();
?>
<!--https://www.youtube.com/watch?v=OASBM4heElI-->