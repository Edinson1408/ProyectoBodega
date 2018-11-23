<head>

    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="hc/code/highcharts-more.js"></script>
    <script src="hc/code/highcharts.js"></script>
    <script src="hc/code/modules/exporting.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
<body>
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
	include('../../conexion.php');
	$sql=mysqli_query($conexion,"SELECT CP.*,Al.CANTIDAD,AL.CODPRODUCTO, PRO.NOMPRODUCTO FROM clasificacion_producto CP, almacen AL, producto  PRO
    WHERE  CP.CODCLASIFICACION=al.CODCLASIFICACION
    AND    AL.CODPRODUCTO=PRO.CODPRODUCTO
    AND CP.CODCLASIFICACION='$CodClasificacion' ");
	while ($f=mysqli_fetch_array($sql)) {
		echo "<tr>";
			echo "<td width=20>".$f['CODPRODUCTO']."</td>";
			echo "<td width=20>".$f['NOMPRODUCTO']."</td>";
			echo "<td width=20>".$f['CANTIDAD']."</td>";
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
        text: 'Stock, 2017 Galletas'
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
        name: 'Galletas',
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

    <!-- jQuery -->
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../js/plugins/morris/raphael.min.js"></script>
    <script src="../js/plugins/morris/morris.min.js"></script>
    <script src="../js/plugins/morris/morris-data.js"></script>

</body>

</html>
