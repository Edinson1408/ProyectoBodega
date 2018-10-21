<!DOCTYPE html>
<html>
<head>
<title>Cierre Caja</title>
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
<script type="text/javascript" src='js/jquery-3.2.1.min.js'></script>
<style type="text/css">
	html, body{
        background: rgb(236,240,245);
    }
	.btn{
		border-radius: 0;
	}
	.panel-default{
	    margin-top: 15px;
    }
    .titulo{
	    border-bottom: 2px solid #F2F2F2; 
	    margin-bottom: 5px;
    }
	.container{
	    width: 100%;
	}
	.table-striped{
		width: 98%;
		margin:auto; 
	}
	a.btn{
    	margin-left: 5px;
    }
</style>
</head>
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
//include('../../conexion.php');
//require_once("lib_paguinacion/zebra.php");
session_start();
//soy el usuario en el turno mañana
//tendremos que crear en el control unsa seesion de nobre del usuario
/*$VAR_USUARIO=$_SESSION['user'];
$SQL_USUARIO=mysql_query("SELECT * FROM USUARIO where user='$VAR_USUARIO'",$conexion);
$ARR_USUARIO=mysql_fetch_array($SQL_USUARIO);
$USER=$ARR_USUARIO['user'];
$CON_USER=$ARR_USUARIO['con_user'];
$NOM_USER=$ARR_USUARIO['nom_user'];
$APE_USER=$ARR_USUARIO['ape_user'];
$CORREO=$ARR_USUARIO['correo'];
$DIRECCION=$ARR_USUARIO['direccion'];
$TELEFONO=$ARR_USUARIO['telefono'];
$CATEGRIA=$ARR_USUARIO['categoria'];
$ID_TURNO=$ARR_USUARIO['ID_TURNO'];
date_default_timezone_set('America/Bogota'); 
$FECHA_HOY=date('Y-m-d');
$_SESSION['TURNO']=$ID_TURNO;
$_SESSION['HOY']=$FECHA_HOY;*/
?> 
<?php
//switch ($CATEGRIA) {
	switch (1) {
	case '1':
	?>
	<body>
	<div class="container">
	<div class="form-group">
	<div class="col-xs-10">
	</div>
	</div>
	<a href="pdf_fac_admin.php"  target="T_BLANK" class="btn btn-danger btn-sm">Boleta</a>
	<a href="pdf_deta_fac_admin.php"  target="T_BLANK" class="btn btn-danger btn-sm">DetalleBoleta</a>
	<a href="excel_caja.php"  target="T_BLANK" class="btn btn-danger btn-sm">ExcelMovimiento</a>
	<!--a href="pdf_deta_fac.php" target="T_BLANK"  class="btn btn-danger btn-sm">Boleta Detalladas</a-->
		<div class="panel panel-default" id="panel1">
		<div class="row">
		<div class="col-md-12">
		<div class="titulo" style="margin-left: 10px;">
		<h4 style="float: left;">Cierre de Cajas</h4>
		<form action="caja.php" method="POST">
			<select name="turn">
				<?php
				$sql_turno=mysql_query("SELECT * FROM TURNO",$conexion);{
					while ($r=mysql_fetch_array($sql_turno)) {
						echo '<option value="'.$r['ID_TURNO'].'">'.$r['DES_TUR'].'</option>';
					}
				}
				?>
			</select>
			<input type="submit" name="enviar">
		</form>
		<h3 style="float: right; margin-right: 10px;">
			<?php
			error_reporting(0);
			$tur=$_POST['turn'];
			$_SESSION['turno']=$_POST['turn'];
			$_SESSION['filtro']=$_POST['enviar'];
			if (isset($_POST['enviar'])) {
			$SQL_FACTURA=mysql_query("SELECT SUM(SUB_TOTAL) TOTALES FROM BOLETA 
				WHERE FECHA_FACTURA='$FECHA_HOY' AND ID_TURNO='$tur' AND PROCESO='2'",$conexion);
				while ($r=mysql_fetch_array($SQL_FACTURA)) {
					echo "Ventas Diarias: S/.".$r['TOTALES']."";
				}
			}
			if (!isset($_POST['enviar'])) {
			$SQL_FACTURA=mysql_query("SELECT SUM(TOTAL) TOTALES FROM BOLETA WHERE FECHA_FACTURA='$FECHA_HOY' AND PROCESO='2'",$conexion);
				while ($r=mysql_fetch_array($SQL_FACTURA)) {
					echo "Ventas Diarias: S/.".$r['TOTALES']."";
				}
			}
			?>
		</h3>
		</div>
		<table class="table table-bordered">
		<tr>
		<th width='90' style="line-height: 10pt;" >Turno</th>
		<th width='90' style="line-height: 10pt;" >Encargado</th>
		<th width='90' style="line-height: 10pt;" >Boleta</th>
		<th width='90' style="line-height: 10pt;" >Fecha</th>
		<th width='90' style="line-height: 10pt;" >Hora</th>
		<th width='90' style="line-height: 10pt;" >Cliente</th>
		<th width='90' style="line-height: 10pt;" >Total</th>
		<th width='90' style="line-height: 10pt;" >Detalles</th>
		</tr>
		<?php
		//falta la cehca de hoy
		if (isset($_POST['enviar'])) {
		$SQL_FACTURA=mysql_query("SELECT A.*, C.DES_TUR AS TURNO 
		FROM BOLETA AS A, TURNO AS C 
		WHERE (A.ID_TURNO=C.ID_TURNO) AND FECHA_FACTURA='$FECHA_HOY' AND A.ID_TURNO='$tur' order by A.ID_TURNO",$conexion);
		while ($ARR_FAC=mysql_fetch_array($SQL_FACTURA)) {
			$n_fac=$ARR_FAC['NRO_FACTURA'];
			$n_se=$ARR_FAC['SERIE_FACTURA'];
		?>
		<tr> 
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['TURNO'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['ENCARGADO'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['NRO_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['FECHA_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['HORA_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['RUC_CLIENTE'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['TOTAL'] ?></td>
		<td width='90' style="line-height: 10pt;" onClick="desplegar('<?php ECHO $n_fac  ?>');" >[+] </td> 
		</tr> 
		<?php
		}
		}
		if (!isset($_POST['enviar'])) {
		$query = mysql_query("SELECT A.*, C.DES_TUR AS TURNO 
		FROM BOLETA AS A, TURNO AS C 
		WHERE (A.ID_TURNO=C.ID_TURNO) AND FECHA_FACTURA='$FECHA_HOY' order by A.ID_TURNO",$conexion);
				$num_registros = mysql_num_rows($query);
				/*resultados por paguinas*/
				$resul_x_pagina = 8;
				$paginacion = new Zebra_Pagination();
				$paginacion->records($num_registros);
				$paginacion->records_per_page($resul_x_pagina);
		$SQL_FACTURA=mysql_query("SELECT A.*, C.DES_TUR AS TURNO 
		FROM BOLETA AS A, TURNO AS C 
		WHERE (A.ID_TURNO=C.ID_TURNO) AND FECHA_FACTURA='$FECHA_HOY' order by A.ID_TURNO LIMIT " .(($paginacion->get_page() - 1) * $resul_x_pagina). ",".$resul_x_pagina,$conexion);
		while ($ARR_FAC=mysql_fetch_array($SQL_FACTURA)) {
			$n_fac=$ARR_FAC['NRO_FACTURA'];
			$n_se=$ARR_FAC['SERIE_FACTURA'];
		?>
		<tr> 
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['TURNO'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['ENCARGADO'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['NRO_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['FECHA_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['HORA_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['RUC_CLIENTE'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['TOTAL'] ?></td>
		<td width='90' style="line-height: 10pt;" onClick="desplegar('<?php ECHO $n_fac  ?>');" >[+] </td> 
		</tr> 
		<?php
		}
		echo "</table>";
		$paginacion->render();
		}
		?>
		</div>
		</div>
		<div id="div_ajax"></div>
		</div>
	</div>
	</body>
	<?php
	break;
	case '2':
	?>
	<body>
	<div class="container">
	<div class="form-group">
	<div class="col-xs-10">
	</div>
	</div>
	<a href="pdf_fac.php"  target="T_BLANK" class="btn btn-danger btn-sm">
	<a href="pdf_deta_fac.php"  target="T_BLANK" class="btn btn-danger btn-sm">DetalleBoleta</a>Boletas</a>
	<!--a href="pdf_deta_fac.php" target="T_BLANK"  class="btn btn-danger btn-sm">Boletas Detalladas</a-->
		<div class="panel panel-default" id="panel1">
		<div class="row">
		<div class="col-md-12">
		<div class="titulo" style="margin-left: 10px;">
		<h4 style="float: left;">Cierre de Cajas</h4>
		<h3 style="float: right; margin-right: 10px;">
			<?php
			$SQL_FACTURA=mysql_query("SELECT SUM(SUB_TOTAL) TOTALES FROM BOLETA WHERE FECHA_FACTURA='$FECHA_HOY'  AND ID_TURNO='$ID_TURNO' AND PROCESO='2'",$conexion);
				while ($r=mysql_fetch_array($SQL_FACTURA)) {
					echo "Ventas Diarias: S/.".$r['TOTALES']."";
				}
			?>
		</h3>
		</div>
		<table class="table table-bordered">
		<tr>
		<th width='90' style="line-height: 10pt;" >Turno</th>
		<th width='90' style="line-height: 10pt;" >Encargado</th>
		<th width='90' style="line-height: 10pt;" >Boleta</th>
		<th width='90' style="line-height: 10pt;" >Fecha</th>
		<th width='90' style="line-height: 10pt;" >Hora</th>
		<th width='90' style="line-height: 10pt;" >Cliente</th>
		<th width='90' style="line-height: 10pt;" >Total</th>
		<th width='90' style="line-height: 10pt;" >Detalles</th>
		</tr>
		<?php
		//falta la cehca de hoy
		$SQL_FACTURA=mysql_query("SELECT A.*, C.DES_TUR AS TURNO 
		FROM BOLETA AS A, TURNO AS C 
		WHERE (A.ID_TURNO=C.ID_TURNO) AND FECHA_FACTURA='$FECHA_HOY' AND A.ID_TURNO='$ID_TURNO'",$conexion);
		while ($ARR_FAC=mysql_fetch_array($SQL_FACTURA)) {
			$n_fac=$ARR_FAC['NRO_FACTURA'];
			$n_se=$ARR_FAC['SERIE_FACTURA'];
		?>
		<tr> 
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['TURNO'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['ENCARGADO'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['NRO_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['FECHA_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['HORA_FACTURA'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['RUC_CLIENTE'] ?></td>
		<td width='90' style="line-height: 10pt;"><?php echo $ARR_FAC['TOTAL'] ?></td>
		<td width='90' style="line-height: 10pt;" onClick="desplegar('<?php ECHO $n_fac  ?>');" >[+] </td> 
		</tr> 
		<?php
		}
		?>
		</table>
		</div>
		</div>
		<div id="div_ajax"></div>
		</div>
	</div>
	</body>
		<?php
	break;
	
	default:
		# code...
		break;
}
?>

</html>
