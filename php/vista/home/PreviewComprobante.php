<?php
include('../../conexion.php');
session_start();
$nro=$_POST['codigo'];
?>
<style type="text/css">

	.contenedor {
		width: 100%;
		margin: auto;
	}

	.cabecera {
		text-align: center;
	}

	.ti {
		font-weight: bold;
		line-height: 1em;
		text-align: center;
		font-size: 18pt;
	}

	.in {
		line-height: 1em;
		text-align: center;
	}

	.cuerpo {
		width: 50%;
		margin: auto;
	}

	.cal {
		line-height: 1em;
	}

	.footer {
		text-align: center;
	}

	.to {
		font-weight: bold;
		line-height: 1em;
	}

	.d {
		line-height: 1em;
	}

	p {
		margin: 0;
	}
</style>

<body>
	<div class="contenedor">
		<div class="cabecera">
			<img src="iframe/img/imprimir.jpeg"></img>
			<BR>
			<p class='ti'>LUIGGI'S MARKET
				<BR>
			</p>
			<p class='in'>INVERSIONES VITTERI ORTIZ S.A.C<br>R.U.C.:20601965420<br>Cal. 30 B Mza. U2 Lote 01 Urb. Ciudad del Pescador
				<BR>Bellavista, Callao</p><br>
		</div>
		<div class="cuerpo">
			<p> BOLETA DE VENTA<br>
				<?php
					$_SESSION['clie']=$NomClie;
				?>
					N° BOLETA:
					<?php echo $NroCompro;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SERIE:001<br> Cliente:
					<?php echo utf8_encode($NomClie); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Dni:
					<?php echo $DniRucCli.'<br>';?> Fecha de Emision:
					<?php echo $FCompro; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
					<?php
								echo "Hora:".$HCompro."<br>";
								echo "************************************************";
					?>

				<TABLE>
					<tr>
						<td>Can.</td>
						<td>Descripción</td>
						<td style="margin-left: 65px;">P.U</td>
					</tr>
					<?php
						foreach ($DetCom as $Detalle ) {
							echo '<tr><td>'.$Detalle['CANTIDAD'].'</td><td>'.$Detalle['NOMBRE_PRODUCTO'].'</td><td style="margin-left: 65px;">'.$Detalle['PRECIO_VENTA'].'</td></tr>';
						}
					echo "</TABLE>************************************************<Br>";
					echo "<div class='cal'>";
					echo "<p class='d'>Sub Total: S/.".$SubCompro."<br>";
					echo "IGV: S/.".$IgvCompro."</p>";
					echo "<p class='to'>TOTAL: S/.".$TotCompro."</p><br>";
					echo '</div>';
?>
		</div>
		<div class="footer">
			¡Gracias por su compra en LUIGGI'S MARKET!<br> ******************************
			<br> Vuelva Pronto
		</div>
		<div class="bt">
			<?php
echo '</div>';
?>
				<a href="vista/home/PdfImprimir.php?id=<?php echo $NroCompro;?>" class='btn btn-default' target='T_Blank'><i class="fa fa-print fa-1" aria-hidden="true"> Imprimir</i></a>
		</div>
	</div>
