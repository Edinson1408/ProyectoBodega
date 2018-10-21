<!DOCTYPE html>
<html>
<head>
<title></title>
<script type="text/javascript" src='js/jquery-3.2.1.min.js'></script>
</head>
<body>
<a href="pdf_fac.php">Facturas</a>
<a href="pdf_deta_fac.php">Facturas Detalladas</a>
<script type="text/javascript">
	function desplegar(factura){
	var nfactura=factura;
	var url="mostar_detalle_f.php";

	//llego la hora de ajax
	$.ajax(
			{
				type:"post",
				url:url,
				data:{factura:nfactura},

				success:function(datos){
					$("#div_ajax").html(datos);
				}
			}

		)
}

</script>
<?php
include('../../../conexion.php');
session_start();
//soy el usuario en el turno mañana
//tendremos que crear en el control unsa seesion de nobre del usuario
$VAR_USUARIO=$_SESSION['user'];
$SQL_USUARIO=mysql_query("SELECT * FROM USUARIO where user='$VAR_USUARIO'",$conexion);
$ARR_USUARIO=mysql_fetch_array($SQL_USUARIO);


$USER=$ARR_USUARIO['user'];
$CON_USER=$ARR_USUARIO['con_user'];
$NOM_USER=$ARR_USUARIO['nom_user'];
$APE_USER=$ARR_USUARIO['ape_user'];
$CATEGRIA=$ARR_USUARIO['categoria'];
$ID_TURNO=$ARR_USUARIO['ID_TURNO'];

$FECHA_HOY=date('Y-m-d');
echo $FECHA_HOY;
$_SESSION['TURNO']=$ID_TURNO;
$_SESSION['HOY']=$FECHA_HOY;
?>
<body> 
<table border='1'>
<tr>
<td  width='90' >Boleta</td>
<td width='90' >Fecha</td>
<td width='90' >Cliente</td>
<td width='90' >Sub Total</td>
<td width='90' >Igv</td>
<td width='90' >Total</td>
</tr>


<?php
//falta la cehca de hoy

$SQL_FACTURA=mysql_query("SELECT * FROM FACTURA WHERE FECHA_FACTURA='2017-23-09' AND ID_TURNO='TUR1'",$conexion);

while ($ARR_FAC=mysql_fetch_array($SQL_FACTURA)) {
	
	$n_fac=$ARR_FAC['NRO_FACTURA'];
	$n_se=$ARR_FAC['SERIE_FACTURA'];
?>

<tr> 
<td width='90'><?php echo $ARR_FAC['NRO_FACTURA'] ?></td>
<td width='90'><?php echo $ARR_FAC['FECHA_FACTURA'] ?></td>
<td width='90'><?php echo $ARR_FAC['RUC_CLIENTE'] ?></td>
<td width='90'><?php echo $ARR_FAC['SUB_TOTAL'] ?></td>
<td width='90'><?php echo $ARR_FAC['IGV'] ?></td>
<td width='90'><?php echo $ARR_FAC['TOTAL'] ?></td>
<td width='90' onClick="desplegar('<?php ECHO $n_fac  ?>');" >[+] </td> 
</tr> 





<?php
}
?>


</table>

<div id="div_ajax"></div>



</table>
</body>
</html>
