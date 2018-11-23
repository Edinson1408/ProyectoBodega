<head>   
    <!-- Custom Fonts -->
<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        body{
            margin-top: 0px;
            background:transparent;
        }
            .table{
                width: 100%;
                margin: auto;
            }
    </style>
</head>

<div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <center><h1 class="page-header">
                            Stock <br><small> <!--nombre Producto--><?=$NomClasificacion?></small>
                        </h1></center>
                    </div>
                </div>
<div class="col-md-5">   
<table class="table table-bordered" >
	<tr>
		<th>Codigo</th>
		<th>Producto</th>
		<th>Stock</th>
        </tr>
	<?php
	//include('../../conexion.php');
	
	while ($f=mysqli_fetch_array($DatosDetalle)) {
		echo "<tr>";
			echo "<td width=20>".$f['CODPRODUCTO']."</td>";
			echo "<td width=20>".$f['NOMPRODUCTO']."</td>";
            echo "<td width=20>".$f['CANTIDAD']."</td>";
            echo "<td width=20>
            <i title='ver movimientos' class='material-icons'>visibility</i></td>";
		echo "</tr>";
	}
	?>
	
</table>
</div>
<div class="col-md-7">
<div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>



        <script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Stock, 2017 <?=$NomClasificacion?>'
    },
    tooltip: {
        pointFormat: '{series.name} {point.percentage:.1f}% '
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f}% ',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: '<?=$NomClasificacion?>',
        colorByPoint: true,
        data: [
        <?php
        require ("../../conexion.php");
        $sql=mysqli_query($conexion,"SELECT CP.*,Al.CANTIDAD,AL.CODPRODUCTO, PRO.NOMPRODUCTO FROM clasificacion_producto CP, almacen AL, producto  PRO
        WHERE  CP.CODCLASIFICACION=al.CODCLASIFICACION
        AND    AL.CODPRODUCTO=PRO.CODPRODUCTO
        AND CP.CODCLASIFICACION='$CodClasificacion'");
        while ($f=mysqli_fetch_array($sql)) {
        ?>
        {name:'<?php echo $f["NOMPRODUCTO"];?>', y:<?php echo $f["CANTIDAD"];?>},
        <?php
        }
        ?>
        ]
    }]
});
</script>
</div>
</div>
