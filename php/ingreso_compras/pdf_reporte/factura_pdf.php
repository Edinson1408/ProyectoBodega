<!DOCTYPE html>
<html>
<head>
	<title></title>	
</head>
<body>
<?php
require_once('../../pdf/mpdf.php');
include('../../../conexion.php');
$factura=$_GET['id'];
$html.="<p>Hola, soy la factura '".$factura."' . =)</p>"
?>
</body>
</html>