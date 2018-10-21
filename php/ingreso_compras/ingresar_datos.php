<?php
include('../../conexion.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
		<script type="text/javascript" src='js/jquery-3.2.1.min.js'></script>
	
	<script type="text/javascript">
		function mostrar_proucto(){
	var producto=document.getElementById("produc").value;
	var url="mostrar_datos.php";

	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{n_producto:producto},

				success:function(datos){
					$("#mostrar_producto").html(datos);
				}
			}

		)
}
	</script>
		<style type="text/css">

		.btn{
			margin-top: 20px;
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
<body>
<p>
<h4>Ingresar Detalle</h4>
</p>
<div>
<form method="POST" action="ingresar_datos.php">
<div class="form-group">
<div class="col-xs-4">
Producto : 
<input list="producto" class="form-control input-sm" id="produc" name="pro" onchange="mostrar_proucto()">
					<datalist id="producto">
					  <?php
						  	$SQL_PRODUCTO=mysql_query("SELECT * FROM PRODUCTO",$conexion);
						  	while ($ARR_PRO=mysql_fetch_array($SQL_PRODUCTO)) 
						  	{
						  		echo "<option value='".$ARR_PRO['COD_PRODUCTO']."'>".$ARR_PRO['NOMBRE_PRODUCTO']."</option>";
						  	}
					  ?>
					</datalist>
<div id="mostrar_producto">
	
</div>
</div>
<div class="col-xs-4">
cantidad : <input type="text"  class="form-control input-sm" id="cantidad" name="canti">
</div>
<div class="col-xs-4">
<input type="submit" name="boton_agregar" class="btn btn-primary" value="Agregar" >
</div>
</div>
</form>
</div>
</div>
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
/* AQUI TENFO QUE HACER UN I SI EL PRODUCTO TIENE STOCK*/

if (isset($_POST['boton_agregar'])) {
	//trayendo las variables de sessiones 
$VAR_SERIE=$_SESSION['serie'];
$VAR_NUM_FAC=$_SESSION['numero_fac'];
$VAR_RUC_CLI=$_SESSION['cliente'];
$VAR_FECHA_FAC=$_SESSION['fecha'];
$VAR_LOCAL_PRO=$_POST['pro'];
$VAR_LOCA_CANT=$_POST['canti'];
$encargado=$_SESSION['nom_user'];

// DEBEMOS VER SI LA FACTURA EXITE PAR PODER AGREFARLA , ESTO SE HACE PARA YA NO CHANCAR LA BASE
// SU BIEN ES SIERTO ESTO SE ISI EN EL DOCUMENTO MOSTRAR DETALLE , PERO ESO ERA PARA MOSTRAR 
//Y ESTE SERA PARA INGRESAR 
$SQL_VERIF_FAC=mysql_query("SELECT * FROM FACTURA WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
$NUM_VERIFICADO=mysql_num_rows($SQL_VERIF_FAC);
//INICIO IF
		if ($NUM_VERIFICADO==0) // SI ES 0 QUIERE DECIR QUE NO EXISTE ENTONCES SE AGREGA PUES PAPU xd 
		{
			//INSERTANDO LOS DATOS DE LA CATURA
			mysql_query("INSERT INTO FACTURA VALUES ('$VAR_NUM_FAC','$VAR_SERIE','70944692','$VAR_RUC_CLI','$VAR_FECHA_FAC','00','00','00','1','$encargado','','')",$conexion);

		}
//FIN IF

// COMO YA AGREGAMOS LA FACTURA ENTONCES AGREGAREMOS SU DETALLE
//PRIEMO EXTRAER LOS DATOS DEL MALDITO PRODUCTO JAJAA PARA PONER SU PRECIO UNITATIO xd
$SQL_DATOS_PRO=mysql_query("SELECT * FROM PRODUCTO WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'",$conexion);
$ARRY_DA_PRO=mysql_fetch_array($SQL_DATOS_PRO);
//CALSE DE PRODUCTO
$VAR_CALSE=$ARRY_DA_PRO['CLASE_PRODUCTO'];
//AHORA A EXTRAER LOS DATOS xd
$VAR_PRECIO_UNI=$ARRY_DA_PRO['PRECIO_UNITARIO'];
//IMPORTE PAPU
$VAR_IMPORTE_PR=$VAR_PRECIO_UNI*$VAR_LOCA_CANT;

//POR FIN INSERTAMOS xD
		mysql_query("INSERT INTO DETALLE_FACTURA VALUES ('$VAR_NUM_FAC','$VAR_LOCAL_PRO','$VAR_LOCA_CANT','$VAR_PRECIO_UNI','$VAR_IMPORTE_PR','1')",$conexion);
//INGRESANDO AL ALAMACEN
		// AQUI DEVEMOS PREGUNTAR SI EXITE EL PRODUTO
		// SI NO EXITE , ENTONCES TEMOS QUE AGREGARLO 
		// SI EXISTE , ENTONCES DEVEMOS ACTUALIZAR LA TABLA Y SUMARLE AL CANTIDAD QUE EMOS INGRESADO
		$SQL_VE_ALMACEN=mysql_query("SELECT * FROM ALMACEN WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'",$conexion);
		

		$NUM_VE_ALMACEN=mysql_num_rows($SQL_VE_ALMACEN);
		if ($NUM_VE_ALMACEN==0) 
		{ //si el porcto es cero es que no exite , entonces lo insertamos 
			mysql_query("INSERT INTO ALMACEN VALUES ('','$VAR_CALSE','$VAR_LOCAL_PRO','$VAR_LOCA_CANT')",$conexion);
			
		}
		else
		{
			//AQUI AREMOS EL UPDATE POR QUE EL PRODUCTO YA EXIXTE
			// SOLO EXTRAERE EL CAMPO DE CANTIDAD // ESTA ES LA ULTIMA CANTIDAD QUE TIENE EN EL MOENTO 
			//EXTRER DATOS DE CONSUALTA
			$ARR_VE_ALMACEN=mysql_fetch_array($SQL_VE_ALMACEN);
			
			$CANTIDAD_REAL=$ARR_VE_ALMACEN['CANTIDAD'];
			//AUMENTAMOS LA CANTIDAD CON LA CANTIDAD DE LA COANSULTA + LA CANTIDAD QUE SE INGRESO
			$CANTIDAD_AUME=$CANTIDAD_REAL+$VAR_LOCA_CANT;

			//HAREMOS EL UPDATE PAPU , PASITO A PASITO SUBE SUABESITO xd
			mysql_query("UPDATE  ALMACEN 
							SET CANTIDAD='$CANTIDAD_AUME'
							WHERE COD_PRODUCTO='$VAR_LOCAL_PRO'",$conexion);
			mysql_query("INSERT INTO movimiento_almacen VALUES ('','$VAR_NUM_FAC','$VAR_FECHA_FAC','$VAR_LOCAL_PRO','$VAR_LOCA_CANT','1')",$conexion);

	
		}



echo "<TABLE border='3px' width='100%'>";
		echo "<tr>";
		echo "<td>Cod Producto</td>";
		echo "<td>Descripcion</td>";
		echo "<td>Cantidad</td>";
		echo "<td>Precio</td>";
		echo "<td>importe</td>";
		echo "</tr>";
$SQL_M_DETALLE=mysql_query("SELECT a.*,B.NOMBRE_PRODUCTO FROM DETALLE_FACTURA AS a, PRODUCTO AS b WHERE a.COD_PRODUCTO=b.COD_PRODUCTO AND NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
while ($ARR_DE=mysql_fetch_array($SQL_M_DETALLE)) 
{
		echo "<tr>";
		$_SESSION['factura']=$ARR_DE['NRO_FACTURA'];
		echo "<td>".$ARR_DE['COD_PRODUCTO']."</td>";
		echo "<td>".$ARR_DE['NOMBRE_PRODUCTO']."</td>";
		echo "<td>".$ARR_DE['CANTIDAD_PRODUCTO']."</td>";
		echo "<td>S/".$ARR_DE['PRECIO_UNITARIO']."</td>";
		echo "<td>S/".$ARR_DE['IMPORTE']."</td>";
		echo "<td><a href='mantenimiento/eliminar.php?id=".$ARR_DE['COD_PRODUCTO']."'>x</a>";
		echo "</tr>";
}

$SQL_SUB=mysql_query("SELECT SUM(IMPORTE) AS SUBTOTAL FROM DETALLE_FACTURA WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
$ARR_SUB=mysql_fetch_array($SQL_SUB);
$TOTAL=$ARR_SUB['SUBTOTAL'];

$SUB_TOTAL=$TOTAL/1.18;

$IGV=$TOTAL-$SUB_TOTAL;
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>TOTAL Soles </td>";
		echo "<td>S/.".$TOTAL."</td>";
		echo "</tr>";
		
		echo "</TABLE>";
$ESTADO_DE_PAGO=$_SESSION['pagos'];
if ($ESTADO_DE_PAGO=='P') {
		mysql_query("UPDATE  FACTURA 
							SET SUB_TOTAL='$SUB_TOTAL',IGV='$IGV',TOTAL='$TOTAL',ESTADO='P'
							WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
}
if ($ESTADO_DE_PAGO=='C') {
		mysql_query("UPDATE  FACTURA 
							SET SUB_TOTAL='$SUB_TOTAL',IGV='$IGV',TOTAL='$TOTAL',SALDO='0', ESTADO='C'
							WHERE NRO_FACTURA='$VAR_NUM_FAC'",$conexion);
}
}





?>




</body>
</html>





