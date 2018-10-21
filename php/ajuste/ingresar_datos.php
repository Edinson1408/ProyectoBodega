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
<h4>Detalle</h4>
</p>
<form method="POST" action="ingresar_datos.php" name="formu">
<div class="form-group">
<div class="col-xs-4">
Producto : 
<input list="producto" class="form-control input-sm" id="pro" name="pro">
					<datalist id="producto">
					  <?php
						  	$SQL_PRODUCTO=mysql_query("SELECT * FROM PRODUCTO",$conexion);
						  	while ($ARR_PRO=mysql_fetch_array($SQL_PRODUCTO)) 
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
if (isset($_POST['boton_agregar'])) {
	//trayendo las variables de sessiones 
$VAR_SERIE=$_SESSION['numero_ser'];;
$VAR_NUM_FAC=$_SESSION['numero_fac'];
$VAR_FECHA_FAC=$_SESSION['fecha'];
$VAR_LOCAL_PRO=$_POST['pro'];
$VAR_LOCA_CANT=$_POST['canti'];
$encargado=$_SESSION['nom_user'];
// DEBEMOS VER SI LA FACTURA EXITE PAR PODER AGREFARLA , ESTO SE HACE PARA YA NO CHANCAR LA BASE
// SU BIEN ES SIERTO ESTO SE ISI EN EL DOCUMENTO MOSTRAR DETALLE , PERO ESO ERA PARA MOSTRAR 
//Y ESTE SERA PARA INGRESAR 
$SQL_VERIF_FAC=mysql_query("SELECT * FROM AJUSTE WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
$NUM_VERIFICADO=mysql_num_rows($SQL_VERIF_FAC);
date_default_timezone_set('America/Bogota'); 
$hora = date('G:i:s');
//INICIO IF
		if ($NUM_VERIFICADO==0) // SI ES 0 QUIERE DECIR QUE NO EXISTE ENTONCES SE AGREGA PUES PAPU xd 
		{
			//INSERTANDO LOS DATOS DE LA CATURA
			mysql_query("INSERT INTO AJUSTE VALUES ('$VAR_NUM_FAC','$VAR_SERIE','$VAR_FECHA_FAC','$hora','00','00','00','$encargado')",$conexion);

		}
//FIN IF

// COMO YA AGREGAMOS LA FACTURA ENTONCES AGREGAREMOS SU DETALLE
//PRIEMO EXTRAER LOS DATOS DEL MALDITO PRODUCTO JAJAA PARA PONER SU PRECIO UNITATIO xd
$SQL_DATOS_PRO=mysql_query("SELECT * FROM PRODUCTO WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'",$conexion);
$ARRY_DA_PRO=mysql_fetch_array($SQL_DATOS_PRO);
//CALSE DE PRODUCTO
$VAR_CALSE=$ARRY_DA_PRO['CLASE_PRODUCTO'];
//AHORA A EXTRAER LOS DATOS xd
$VAR_PRECIO_UNI=$ARRY_DA_PRO['PRECIO_VENTA'];
//IMPORTE PAPU
$VAR_IMPORTE_PR=$VAR_PRECIO_UNI*$VAR_LOCA_CANT;

$CAN_INGRE=mysql_query("SELECT SUM(cantidad) AS INGRESO FROM CANTIDAD_INGRESO WHERE cod_producto='$VAR_LOCAL_PRO'",$conexion);
$CAN_SALID=mysql_query("SELECT SUM(cantidad) AS SALIDAS FROM CANTIDAD_SALIDA WHERE cod_producto='$VAR_LOCAL_PRO'",$conexion);
$ARR_INGRE=mysql_fetch_array($CAN_INGRE);
$ARR_SALID=mysql_fetch_array($CAN_SALID);

$CANTIDAD_PRODUCTO=$ARR_INGRE['INGRESO']-$ARR_SALID['SALIDAS'];

//POR FIN INSERTAMOS xD
if ($CANTIDAD_PRODUCTO < $VAR_LOCA_CANT) {
	echo "<BR> STOCK INSUFICIENTE EN ALMACEN";
}	
else{	
		mysql_query("INSERT INTO DETALLE_AJUSTE VALUES ('$VAR_NUM_FAC','$VAR_LOCAL_PRO','$VAR_LOCA_CANT','$VAR_PRECIO_UNI','$VAR_IMPORTE_PR')",$conexion);

//DISMINUYENDO EL ALAMACEN
		// AQUI DEVEMOS PREGUNTAR SI EXITE EL PRODUTO
		// SI NO EXITE , ENTONCES TEMOS QUE AGREGARLO 
		// SI EXISTE , ENTONCES DEVEMOS ACTUALIZAR LA TABLA Y SUMARLE AL CANTIDAD QUE EMOS INGRESADO
		$SQL_VE_ALMACEN=mysql_query("SELECT * FROM ALMACEN WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'",$conexion);
		

		$NUM_VE_ALMACEN=mysql_num_rows($SQL_VE_ALMACEN);
		if ($NUM_VE_ALMACEN==0) 
		{ //si el porcto es cero es que no exite , entonces lo insertamos 
			echo "<BR>ESTE PRODUTO NO EXISTE NO SE PUEDE DESCONTAR DELALMACEN";
			
		}
		else
		{
			//AQUI AREMOS EL UPDATE POR QUE EL PRODUCTO YA EXIXTE
			// SOLO EXTRAERE EL CAMPO DE CANTIDAD // ESTA ES LA ULTIMA CANTIDAD QUE TIENE EN EL MOENTO 
			//EXTRER DATOS DE CONSUALTA
			$ARR_VE_ALMACEN=mysql_fetch_array($SQL_VE_ALMACEN);
			
			$CANTIDAD_REAL=$ARR_VE_ALMACEN['CANTIDAD'];
			//DISMINUIMOS LA CANTIDAD CON LA CANTIDAD DE LA COANSULTA - LA CANTIDAD QUE SE INGRESO
			$CANTIDAD_DIS=$CANTIDAD_REAL-$VAR_LOCA_CANT;

			//HAREMOS EL UPDATE PAPU , PASITO A PASITO SUBE SUABESITO xd
			mysql_query("UPDATE  ALMACEN 
							SET CANTIDAD='$CANTIDAD_DIS'
							WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'",$conexion);
			mysql_query("INSERT INTO movimiento_almacen VALUES ('','$VAR_NUM_FAC','$VAR_FECHA_FAC','$VAR_LOCAL_PRO','$VAR_LOCA_CANT','2')",$conexion);


echo "<TABLE border='3px' width='100%'>";
		echo "<tr>";
		echo "<th>Nro Boleta</th>";
		echo "<th>Cod Producto</th>";
		echo "<th>Cantidad</th>";
		echo "<th>Precio</th>";
		echo "<th>importe</th>";
		echo "</tr>";
$SQL_M_DETALLE=mysql_query("SELECT A.*, B.NOMBRE_PRODUCTO AS PRODUCTO FROM DETALLE_AJUSTE AS A, PRODUCTO AS B WHERE A.COD_PRODUCTO=B.COD_PRODUCTO AND NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
while ($ARR_DE=mysql_fetch_array($SQL_M_DETALLE)) 
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

$SQL_SUB=mysql_query("SELECT SUM(IMPORTE) AS SUBTOTAL FROM DETALLE_BOLETA WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
$ARR_SUB=mysql_fetch_array($SQL_SUB);
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
		mysql_query("UPDATE  AJUSTE 
							SET SUB_TOTAL='$SUB_TOTAL',IGV='$IGV',TOTAL='$TOTAL',
							WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
		}

	}
}
}
?>
</body>
</html>





