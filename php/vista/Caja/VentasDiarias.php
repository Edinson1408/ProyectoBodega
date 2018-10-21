<?php
include('../../conexion.php');
//Estas Sessiones deben estar al logearse 
// session_start();
// $usuario=$_SESSION['user'];
// $sql_usuario=mysqli_query("SELECT * FROM usuario WHERE user='$usuario'",$conexion);
// $array_user=mysql_fetch_array($sql_usuario);
// $turno=$array_user['ID_TURNO'];
// $categoria=$array_user['categoria'];
?>


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
    </style>


<div class="container-fluid">
<form action="cierre_caja.php" method="POST">
	<div class="row">
	<div class="col-xs-2">
	<input type="date" name="inicio" class="form-control input-sm">
	</div>
	<div class="col-xs-2">
	<input type="submit" name="buscar" value="Buscar" class="btn btn_default btn-sm">
	</div>
	</div>
</form>
		<?php
		
		
		// $_SESSION['fecha']=$_POST['inicio'];
		// $inicio=$_POST['inicio'];
		switch ($categoria) {
			case '1':	

		// if (isset($_POST['buscar']))
		// {

		?>
		<h4>Ventas del día <?php //echo $inicio;?></h4>
	<div class="row">
	<div class="col-md-8">
		<table class="table table-bordered">
			<tr>
				<th style='line-height:6pt;'>Encargado</th>
				<th style='line-height:6pt;'>Boleta N°</th>
				<th style='line-height:6pt;'>Fecha</th>
				<th style='line-height:6pt;'>Hora</th>
				<th style='line-height:6pt;'>Cliente</th>
				<th style='line-height:6pt;'>Total</th>
				<th style='line-height:6pt;'>Estado</th>
			</tr>
		<?php
				$sql_cierre=mysqli_query($conexion,"SELECT A.*, B.NOMBRE_C AS NOMBRE, C.DES_TUR AS TURNO, D.NOMBRE_ESTADO AS ESTADO FROM BOLETA AS A, CLIENTE_1 AS B, TURNO AS C, ESTADO AS D WHERE A.RUC_CLIENTE=B.RUC_DNI AND A.ESTADO=D.ID_ESTADO AND A.ID_TURNO=C.ID_TURNO  ORDER BY A.ID_TURNO");
				//AND FECHA_FACTURA='$inicio'
				while ($f=mysqli_fetch_array($sql_cierre)) {
					echo "<tr>";
						echo "<td style='line-height:5pt;'>".$f['ENCARGADO']."</td>";
						echo "<td style='line-height:5pt;'>".$f['NRO_FACTURA']."</td>";
						echo "<td style='line-height:5pt;'>".$f['FECHA_FACTURA']."</td>";
						echo "<td style='line-height:5pt;'>".$f['HORA_FACTURA']."</td>";
						echo "<td style='line-height:5pt;'>".$f['NOMBRE']."</td>";
						echo "<td style='line-height:5pt;'>S/. ".$f['TOTAL']."</td>";
						echo "<td style='line-height:5pt;'>".$f['ESTADO']."</td>";
					echo "</tr>";
				}

		?>
		</table>
		<a href="pdf/diario.php" class="btn btn-danger btn-sm" target="T_Blank">PDF</a>
		<a href="excel/diario.php" class="btn btn-success btn-sm" target="T_Blank">Excel</a>
		<a href="excel/movimiento.php" class="btn btn-success btn-sm" target="T_Blank">ExcelMovimiento</a>
	</div>
	<div class="col-md-4">
		<table class="table table-bordered">
			<tr>
				<th colspan="3" style="font-size:2em;">Saldo diario</th>
			</tr>
			<?php
				$sql_turno=mysqli_query($conexion,"SELECT SUM(TOTAL) AS TOTALES FROM BOLETA ");
				//WHERE FECHA_FACTURA='$inicio'
				$r=mysqli_fetch_array($sql_turno);
					echo "<tr>";
						echo "<td colspan='3' style='text-align: center; font-size:4em;'>S/.".$r['TOTALES']."</td>";
					echo "</tr>";
			?>
			<tr>
				<th>Mañana</th>
				<th>Tarde</th>
				<th>Noche</th>
			</tr>
			<?php
				$sql_dia=mysqli_query($conexion,"SELECT SUM(TOTAL) AS DIA FROM BOLETA WHERE  ID_TURNO='TUR1'");
				//FECHA_FACTURA='$inicio' AND para el filtro
				$d=mysqli_fetch_array($sql_dia);
					echo "<tr>";
						echo "<td>S/.".$d['DIA']."</td>";
				$sql_tarde=mysqli_query($conexion,"SELECT SUM(TOTAL) AS TARDE FROM BOLETA WHERE  ID_TURNO='TUR2'");
				//FECHA_FACTURA='$inicio' AND
				$t=mysqli_fetch_array($sql_tarde);
						echo "<td>S/.".$t['TARDE']."</td>";
				$sql_noche=mysqli_query($conexion,"SELECT SUM(TOTAL) AS NOCHE FROM BOLETA WHERE  ID_TURNO='TUR3'");
				//ECHA_FACTURA='$inicio' AND
				$n=mysqli_fetch_array($sql_noche);
						echo "<td>S/.".$n['NOCHE']."</td>";
					echo "</tr>";
			//} if del buscador 
			?>
		</table>
	</div>
	</div>
		<?php
				break;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			case '2':
		if (isset($_POST['buscar'])){
		?>
		<h4>Ventas del día <?php echo $inicio;?></h4>
	<div class="row">
	<div class="col-md-8">
		<table class="table table-bordered">
			<tr>
				<th style='line-height:6pt;'>Encargado</th>
				<th style='line-height:6pt;'>Boleta N°</th>
				<th style='line-height:6pt;'>Fecha</th>
				<th style='line-height:6pt;'>Hora</th>
				<th style='line-height:6pt;'>Cliente</th>
				<th style='line-height:6pt;'>Total</th>
				<th style='line-height:6pt;'>Estado</th>
			</tr>
		<?php
				$sql_cierre=mysql_query("SELECT A.*, B.NOMBRE_C AS NOMBRE, C.DES_TUR AS TURNO, D.NOMBRE_ESTADO AS ESTADO FROM BOLETA AS A, CLIENTE_1 AS B, TURNO AS C, ESTADO AS D WHERE A.RUC_CLIENTE=B.RUC_DNI AND A.ESTADO=D.ID_ESTADO AND A.ID_TURNO=C.ID_TURNO AND FECHA_FACTURA='$inicio' AND A.ID_TURNO='$turno' ORDER BY A.ID_TURNO",$conexion);
				while ($f=mysql_fetch_array($sql_cierre)) {
					echo "<tr>";
						echo "<td style='line-height:5pt;'>".$f['ENCARGADO']."</td>";
						echo "<td style='line-height:5pt;'>".$f['NRO_FACTURA']."</td>";
						echo "<td style='line-height:5pt;'>".$f['FECHA_FACTURA']."</td>";
						echo "<td style='line-height:5pt;'>".$f['HORA_FACTURA']."</td>";
						echo "<td style='line-height:5pt;'>".$f['NOMBRE']."</td>";
						echo "<td style='line-height:5pt;'>S/. ".$f['TOTAL']."</td>";
						echo "<td style='line-height:5pt;'>".$f['ESTADO']."</td>";
					echo "</tr>";
				}
		?>
		</table>
		<a href="pdf/diario.php" class="btn btn-danger" target="T_Blank">PDF</a>
		<a href="#" class="btn btn-success">Excel</a>
	</div>
	<div class="col-md-4">
		<table class="table table-bordered">
			<tr>
				<th colspan="3" style="font-size:2em;">Saldo del turno</th>
			</tr>
			<?php
				$sql_turno=mysql_query("SELECT SUM(TOTAL) AS TOTALES FROM BOLETA WHERE ID_TURNO='$turno' AND FECHA_FACTURA='$inicio'",$conexion);
				$r=mysql_fetch_array($sql_turno);
					echo "<tr>";
						echo "<td colspan='3' style='text-align: center; font-size:4em;'>S/.".$r['TOTALES']."</td>";
					echo "</tr>";
				}
			?>

		</table>
	</div>
	</div>
		<?php
		break;
		}?>
</div>
