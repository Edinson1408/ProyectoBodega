<?php
//hay que hacer las validaciones de los vacios
include("../../conexion.php");
include ('../seguridad.php');
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
	<script type="text/javascript" src='js/verifica_1.js'></script>
    <!-- Custom Fonts -->
    <link href="../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<style type="text/css">
		html{
			padding: 15px;
		}
		.btn{
			margin-top: 20px;
		}
		.container{
			width: 100%;
			padding: 10px;
		}
		#com{
			font-size: 2em;
		}
		.nota{
			padding-top: 10px;
			height: 50px;
			border-bottom: 3px solid #337ab7;
		}
		.form-control{
			border-radius: 0px;
		}
	</style>
</head>
<body>

<div class="nota">
	<i class="fa fa-pencil-square-o" id="com">Agregar nueva compra</i>
</div>
<div class="container">
<div class="form-group">
<div class="col-xs-2">
Fecha : <input type="date" class="form-control input-sm" name="" id="fe" value="<?php date_default_timezone_set('America/Bogota'); echo date('Y-m-d')?>">
</div>
<div class="col-xs-2">
Tipo Documento:	<select class="form-control input-sm" id="doc" disabled>
					<option>FACTURA</option>
				</select>
</div>
<div class="col-xs-2">
Serie<input type="text" class="form-control input-sm" name="" id="serie" >
</div>
<div class="col-xs-2">
Nro Documento <input type="text" class="form-control input-sm" name="" id="nro_doc" >
</div>
	<div class="col-xs-2">
	Cliente/Proveedor: <input list="cliente" class="form-control input-sm" id="clie" name="" onchange="mostrar_datos()">
		<datalist id="cliente">
				<?php
					$SQL_CLIENTE=mysql_query("SELECT * FROM CLIENTE",$conexion);
					while ($ARR_CLI=mysql_fetch_array($SQL_CLIENTE)) {
						echo "<option value='".$ARR_CLI['RUC_CLIENTE']."'>".$ARR_CLI['NOMBRE_CLIENTE']."</option>";
					}
				?>
		</datalist>
	</div>
<div class="col-xs-2">
Pago:<select class="form-control input-sm" id="pago">
				<option>Estado</option>
				<?php
				$sql_estado=mysql_query("SELECT * FROM estado",$conexion);
				while ($r=mysql_fetch_array($sql_estado)) {
					echo "<option value='".$r['ID_ESTADO']."'>".$r['NOMBRE_ESTADO']."</option>";
				}
				?>
				</select>
</div>
	<div id="mostrar_proveedor">
		
	</div>
	<div class="col-xs-2">
	<input type="submit" name="" class="btn btn-primary btn-sm" value="Verificar" onclick="verificar();">
	</div>
		<div id="div_ajax">
			
		</div>
</div>
</div>
</body>
</html>