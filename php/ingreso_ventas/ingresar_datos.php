<?php
include('../../conexion.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">

	<style type="text/css">

		.btn{
			margin-top: 18px;
		}
		h4{
			color:#1750a5;
			margin-top: 10px;
			margin-bottom: 10px;
			margin-left: 10px;
			margin-right: 10px;
			display: inline;
		}
	</style>
</head>
<body onload="formu.pro.focus()">
<p>
<h4>Ingresar Detalle</h4>
</p>
<form method="POST" action="ingresar_datos.php" name="formu">
<div class="form-group">
<div class="col-xs-4">
Producto : 
<input list="producto" class="form-control input-sm" id="pro" name="pro">
					<datalist id="producto">
					  <?php
						  	$SQL_PRODUCTO=mysqli_query($conexion,"SELECT * FROM PRODUCTO");
						  	while ($ARR_PRO=mysqli_fetch_array($SQL_PRODUCTO)) 
						  	{
						  		echo "<option value='".$ARR_PRO['COD_PRODUCTO']."'>".$ARR_PRO['NOMBRE_PRODUCTO']."</option>";
						  	}
					  ?>
					</datalist>
</div>
<div class="col-xs-4">
cantidad : <input type="text" class="form-control input-sm" id="cantidad" name="canti" value="1">
</div>
<input type="submit" name="boton_agregar" class="btn btn-primary" value="Agregar" >
</div>
</form>
<!--a href='impresora/example/demo.php'>imprimir</a-->
<a href="impresora/example/demo.php" target="tiframe"><i class="fa fa-circle-thin" aria-hidden="true"></i>imprimir</a>

<?php
//insertara a la factura 
// campos de factura 
/*
NRO_FACTURA
SERIE_FACTURA
RUC_EMPRESA
RUC_CLIENTE 
FECHA_FACTURA
DIRECCION_CLIENTE // ESTA DIRECION ESTARA NULA POR QUE TENGO QUE EXTRAER DE LA TABLA PENDEJOS xd
GUIA_REMISION // ESTA GUIA SERA 001
GUIA_TRANSPORTISTA
GUIA_VENDEDOR
SUB_TOTAL //ESTARA EN CERO , LUEGO SE CALCULARA Y SE ACTUALIZARA
IGV 
TOTAL
PROCESO

*/
error_reporting(0);
$VAR_SERIE='001';
$VAR_NUM_FAC=$_SESSION['numero_fac'];
$VAR_RUC_CLI=$_SESSION['cliente'];
$VAR_FECHA_FAC=$_SESSION['fecha'];
$_SESSION['N_CLIENTE'];
$VAR_FECHA_FAC;
$VAR_LOCAL_PRO=$_POST['pro'];
$VAR_LOCA_CANT=$_POST['canti'];

$TURNO=$_SESSION['TURNO'];
$encargado=$_SESSION['nom_user'];

if (isset($_POST['boton_agregar'])) {
	echo 'aqio';
	//trayendo las variables de sessiones 
// DEBEMOS VER SI LA FACTURA EXITE PAR PODER AGREFARLA , ESTO SE HACE PARA YA NO CHANCAR LA BASE
// SU BIEN ES SIERTO ESTO SE ISI EN EL DOCUMENTO MOSTRAR DETALLE , PERO ESO ERA PARA MOSTRAR 
//Y ESTE SERA PARA INGRESAR 
$SQL_VERIF_FAC=mysqli_query($conexion,"SELECT * FROM BOLETA WHERE NRO_FACTURA='$VAR_NUM_FAC'");
$NUM_VERIFICADO=mysqli_num_rows($SQL_VERIF_FAC);
date_default_timezone_set('America/Bogota'); 
$hora = date('G:i:s');
//INICIO IF
		if ($NUM_VERIFICADO==0) // SI ES 0 QUIERE DECIR QUE NO EXISTE ENTONCES SE AGREGA PUES PAPU xd 
		{
			//INSERTANDO LOS DATOS DE LA CATURA
			echo mysqli_query($conexion,"INSERT INTO BOLETA VALUES ('$VAR_NUM_FAC','$VAR_SERIE','70944692','$VAR_RUC_CLI','$VAR_FECHA_FAC','$hora','00','00','00','2','$TURNO','$encargado','','')");

		}
//FIN IF

// COMO YA AGREGAMOS LA FACTURA ENTONCES AGREGAREMOS SU DETALLE
//PRIEMO EXTRAER LOS DATOS DEL MALDITO PRODUCTO JAJAA PARA PONER SU PRECIO UNITATIO xd
$SQL_DATOS_PRO=mysqli_query($conexion,"SELECT * FROM PRODUCTO WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'");
$ARRY_DA_PRO=mysqli_fetch_array($SQL_DATOS_PRO);
//CALSE DE PRODUCTO
$VAR_CALSE=$ARRY_DA_PRO['CLASE_PRODUCTO'];
//AHORA A EXTRAER LOS DATOS xd
$VAR_PRECIO_UNI=$ARRY_DA_PRO['PRECIO_VENTA'];
//IMPORTE PAPU
$VAR_IMPORTE_PR=$VAR_PRECIO_UNI*$VAR_LOCA_CANT;

$CAN_INGRE=mysqli_query($conexion,"SELECT SUM(cantidad) AS INGRESO FROM CANTIDAD_INGRESO WHERE cod_producto='$VAR_LOCAL_PRO'");
$CAN_SALID=mysqli_query($conexion,"SELECT SUM(cantidad) AS SALIDAS FROM CANTIDAD_SALIDA WHERE cod_producto='$VAR_LOCAL_PRO'");
$ARR_INGRE=mysqli_fetch_array($CAN_INGRE);
$ARR_SALID=mysqli_fetch_array($CAN_SALID);

$CANTIDAD_PRODUCTO=$ARR_INGRE['INGRESO']-$ARR_SALID['SALIDAS'];

//POR FIN INSERTAMOS xD
if ($CANTIDAD_PRODUCTO < $VAR_LOCA_CANT) {
	echo "<BR> STOCK INSUFICIENTE EN ALMACEN";
}	
else{	
		mysqli_query($conexion,"INSERT INTO DETALLE_BOLETA VALUES ('$VAR_NUM_FAC','$VAR_LOCAL_PRO','$VAR_LOCA_CANT','$VAR_PRECIO_UNI','$VAR_IMPORTE_PR','2')");

//DISMINUYENDO EL ALAMACEN
		// AQUI DEVEMOS PREGUNTAR SI EXITE EL PRODUTO
		// SI NO EXITE , ENTONCES TEMOS QUE AGREGARLO 
		// SI EXISTE , ENTONCES DEVEMOS ACTUALIZAR LA TABLA Y SUMARLE AL CANTIDAD QUE EMOS INGRESADO
		$SQL_VE_ALMACEN=mysqli_query($conexion,"SELECT * FROM ALMACEN WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'");
		

		$NUM_VE_ALMACEN=mysqli_num_rows($SQL_VE_ALMACEN);
		if ($NUM_VE_ALMACEN==0) 
		{ //si el porcto es cero es que no exite , entonces lo insertamos 
			echo "<BR>ESTE PRODUTO NO EXISTE NO SE PUEDE DESCONTAR DELALMACEN";
			
		}
		else
		{
			//AQUI AREMOS EL UPDATE POR QUE EL PRODUCTO YA EXIXTE
			// SOLO EXTRAERE EL CAMPO DE CANTIDAD // ESTA ES LA ULTIMA CANTIDAD QUE TIENE EN EL MOENTO 
			//EXTRER DATOS DE CONSUALTA
			$ARR_VE_ALMACEN=mysqli_fetch_array($SQL_VE_ALMACEN);
			
			$CANTIDAD_REAL=$ARR_VE_ALMACEN['CANTIDAD'];
			//DISMINUIMOS LA CANTIDAD CON LA CANTIDAD DE LA COANSULTA - LA CANTIDAD QUE SE INGRESO
			$CANTIDAD_DIS=$CANTIDAD_REAL-$VAR_LOCA_CANT;

			//HAREMOS EL UPDATE PAPU , PASITO A PASITO SUBE SUABESITO xd
			mysqli_query($conexion,"UPDATE  ALMACEN 
							SET CANTIDAD='$CANTIDAD_DIS'
							WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'");
			mysqli_query($conexion,"INSERT INTO movimiento_almacen VALUES ('','$VAR_NUM_FAC','$VAR_FECHA_FAC','$VAR_LOCAL_PRO','$VAR_LOCA_CANT','2')");


echo "<TABLE border='3px' width='100%'>";
		echo "<tr>";
		echo "<th>Nro Boleta</th>";
		echo "<th>Cod Producto</th>";
		echo "<th>Cantidad</th>";
		echo "<th>Precio</th>";
		echo "<th>importe</th>";
		echo "</tr>";
$SQL_M_DETALLE=mysqli_query($conexion,"SELECT A.*, B.NOMBRE_PRODUCTO AS PRODUCTO FROM DETALLE_BOLETA AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND NRO_FACTURA='$VAR_NUM_FAC'");
while ($ARR_DE=mysqli_fetch_array($SQL_M_DETALLE)) 
{
		$_SESSION['factura']=$ARR_DE['NRO_FACTURA'];
		echo "<tr>";
		echo "<td>".$ARR_DE['NRO_FACTURA']."</td>";
		echo "<td>".$ARR_DE['PRODUCTO']."</td>";
		echo "<td>".$ARR_DE['CANTIDAD_PRODUCTO']."</td>";
		echo "<td>S/.".$ARR_DE['PRECIO_UNITARIO']."</td>";
		echo "<td>S/.".$ARR_DE['IMPORTE']."</td>";
		echo "<td><a href='mantenimiento/eliminar_detalle.php?id=".$ARR_DE['COD_PRODUCTO']."'>x</a>";
		echo "</tr>";
}

$SQL_SUB=mysqli_query($conexion,"SELECT SUM(IMPORTE) AS SUBTOTAL FROM DETALLE_BOLETA WHERE NRO_FACTURA='$VAR_NUM_FAC'");
$ARR_SUB=mysqli_fetch_array($SQL_SUB);
$TOTAL=$ARR_SUB['SUBTOTAL'];

$SUB_TOTAL=$TOTAL/1.18;

$IGV=$TOTAL-$SUB_TOTAL;
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>SUBTOTAL Soles</td>";
		echo "<td>S/.".number_format($SUB_TOTAL,2)."</td>";
		echo "</tr>";
		

		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>IGV Soles</td>";
		echo "<td>S/.".number_format($IGV,2)."</td>";
		echo "</tr>";
		


		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>TOTAL Soles</td>";
		echo "<td>S/.".number_format($TOTAL,2)."</td>";
		echo "</tr>";
		echo "</TABLE>";
$ESTADO_DE_PAGO=$_SESSION['estado'];
		if ($ESTADO_DE_PAGO=='P') {
			mysqli_query($conexion,"UPDATE  BOLETA 
							SET SUB_TOTAL='$SUB_TOTAL',IGV='$IGV',TOTAL='$TOTAL',SALDO='$TOTAL',ESTADO='P'
							WHERE NRO_FACTURA='$VAR_NUM_FAC'");
		}
		if ($ESTADO_DE_PAGO=='C') {
			mysqli_query($conexion,"UPDATE  BOLETA 
							SET SUB_TOTAL='$SUB_TOTAL',IGV='$IGV',TOTAL='$TOTAL',SALDO='0',ESTADO='C'
							WHERE NRO_FACTURA='$VAR_NUM_FAC'");
		}
		/*mysql_query("UPDATE  BOLETA 
							SET SUB_TOTAL='$SUB_TOTAL',IGV='$IGV',TOTAL='$TOTAL',SALDO='$TOTAL'
							WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);*/

	}
}
}
if (!isset($_POST['boton_agregar'])) {
echo "<TABLE border='3px' width='100%'>";
		echo "<tr>";
		echo "<th>Nro Boleta</th>";
		echo "<th>Cod Producto</th>";
		echo "<th>Cantidad</th>";
		echo "<th>Precio</th>";
		echo "<th>importe</th>";
		echo "</tr>";
$SQL_M_DETALLE=mysqli_query($conexion,"SELECT A.*, B.NOMBRE_PRODUCTO AS PRODUCTO FROM DETALLE_BOLETA AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND NRO_FACTURA='$VAR_NUM_FAC'");
while ($ARR_DE=mysqli_fetch_array($SQL_M_DETALLE)) 
{
		$_SESSION['factura']=$ARR_DE['NRO_FACTURA'];
		echo "<tr>";
		echo "<td>".$ARR_DE['NRO_FACTURA']."</td>";
		echo "<td>".$ARR_DE['PRODUCTO']."</td>";
		echo "<td>".$ARR_DE['CANTIDAD_PRODUCTO']."</td>";
		echo "<td>S/.".$ARR_DE['PRECIO_UNITARIO']."</td>";
		echo "<td>S/.".$ARR_DE['IMPORTE']."</td>";
		echo "<td><a href='mantenimiento/eliminar_detalle.php?id=".$ARR_DE['COD_PRODUCTO']."'>x</a>";
		echo "</tr>";
}

$SQL_SUB=mysqli_query($conexion,"SELECT SUM(IMPORTE) AS SUBTOTAL FROM DETALLE_BOLETA WHERE NRO_FACTURA='$VAR_NUM_FAC'");
$ARR_SUB=mysqli_fetch_array($SQL_SUB);
$TOTAL=$ARR_SUB['SUBTOTAL'];

$SUB_TOTAL=$TOTAL/1.18;

$IGV=$TOTAL-$SUB_TOTAL;
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>SUBTOTAL Soles</td>";
		echo "<td>S/.".number_format($SUB_TOTAL,2)."</td>";
		echo "</tr>";
		

		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>IGV Soles</td>";
		echo "<td>S/.".number_format($IGV,2)."</td>";
		echo "</tr>";
		


		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>TOTAL Soles</td>";
		echo "<td>S/.".number_format($TOTAL,2)."</td>";
		echo "</tr>";
		echo "</TABLE>";
}

?>
</body>
</html>





