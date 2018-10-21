<?php
 include('../../../conexion.php');       
?>
<!DOCTYPE html>
<html>
<head>
	<title>Productos más vendidos</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../../css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <style type="text/css">
        html, body{
            background: rgb(236,240,245);
        }
        .form-control{
            border-radius: 0;
        }
        .btn{
            border-radius: 0;
        }
        .panel-default{
            margin-top: 45px;
            border-top: 3px solid #3498DB;
        }
        .titulo{
            border-bottom: 2px solid #CACFD2; 
            margin-bottom: 5px;
        }
        .table{
          width: 98%;
          margin:auto;

        }
        a.btn{
            float: right;
        }
        .separador{
            height: 30px;
        }
    </style>
</head>
<body>
    <form action="productos_vendidos.php" method="POST">
        <div class="form-group">
        <div class="col-xs-3">
            <input type="date" name="fecha_inicio" class="form-control input-sm">
        </div>
        </div>
        <div class="form-group">
        <div class="col-xs-3">
            <input type="date" name="fecha_final" class="form-control input-sm">
        </div>
        </div>
        <div class="form-group">
        <div class="col-xs-3">
            <input type="submit" name="enviar" class="btn btn-default btn-sm">
        </div>
        </div>
    </form>
<div class="container-fluid">
    <div class="panel panel-default">
    <div class="row">
    <div class="col-md-12">
    <div class="titulo" style="margin-left: 10px;">
    <?php
    error_reporting(0);
    date_default_timezone_set('America/Bogota'); 
    $dia=date('Y-m-d');
    $inicio=$_POST['fecha_inicio'];
    $final=$_POST['fecha_final'];
    if (!isset($_POST['enviar'])) {
    setlocale(LC_TIME, "spanish");
    echo "<p><strong>" . strftime("%A, %d de %B del %Y") . "</strong></p>";
    ?>
    <h5>Productos vendidos </h5>
    </div>
        <table class="table table-bordered">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>P.U</th>
                <th>Saldo</th>
            </tr>
            <?php
            $sql_reporte=mysql_query("SELECT P.*, SUM(D.CANTIDAD_PRODUCTO) AS TOTAL, SUM(D.CANTIDAD_PRODUCTO) * D.PRECIO_UNITARIO AS PRECIO,  B.FECHA_FACTURA
                                    FROM PRODUCTO AS P, DETALLE_BOLETA AS D, BOLETA AS B
                                    WHERE P.COD_PRODUCTO=D.COD_PRODUCTO AND D.NRO_FACTURA=B.NRO_FACTURA AND B.FECHA_FACTURA='$dia'
                                    GROUP BY P.NOMBRE_PRODUCTO ORDER BY TOTAL DESC ",$conexion);
            while ($r=mysql_fetch_array($sql_reporte)) {
            echo "<tr>";
                echo "<td style='line-height:5pt;'>".$r['NOMBRE_PRODUCTO']."</td>";
                echo "<td style='line-height:5pt;'>".$r['TOTAL']."</td>";
                echo "<td style='line-height:5pt;'>".$r['PRECIO_VENTA']."</td>";
                echo "<td style='line-height:5pt;'>".$r['PRECIO']."</td>";

            echo "</tr>";
            }
        }

        if (isset($_POST['enviar'])) {
        
        echo "<p><strong>Desde : </strong>" .$inicio."<strong> ////*//// Hasta : </strong>".$final."</p>";
        ?>
        <h5>Productos vendidos </h5>
        </div>
            <table class="table table-bordered">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                                    <th>P.U</th>
                <th>Saldo</th>
                </tr>
            <?php
            $sql_reporte=mysql_query("SELECT P.*, SUM(D.CANTIDAD_PRODUCTO) AS TOTAL, SUM(D.CANTIDAD_PRODUCTO) * D.PRECIO_UNITARIO AS PRECIO, B.FECHA_FACTURA
                                    FROM PRODUCTO AS P, DETALLE_BOLETA AS D, BOLETA AS B
                                    WHERE P.COD_PRODUCTO=D.COD_PRODUCTO AND D.NRO_FACTURA=B.NRO_FACTURA AND B.FECHA_FACTURA BETWEEN '$inicio' AND '$final'
                                    GROUP BY P.NOMBRE_PRODUCTO ORDER BY TOTAL DESC",$conexion);
            while ($r=mysql_fetch_array($sql_reporte)) {
            echo "<tr>";
                echo "<td style='line-height:5pt;'>".$r['NOMBRE_PRODUCTO']."</td>";
                echo "<td style='line-height:5pt;'>".$r['TOTAL']."</td>";
                echo "<td style='line-height:5pt;'>".$r['PRECIO_VENTA']."</td>";
                echo "<td style='line-height:5pt;'>".$r['PRECIO']."</td>";

            echo "</tr>";
            }
        }
        ?>
        </table>
    <div class="separador"></div>
    </div>
    </div>
    </div>
</div>
</body>
</html>