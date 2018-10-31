<?php
include('../../conexion.php');
?>


   <!--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>-->
   <script src="hc/code/highcharts-more.js"></script>
   <script src="hc/code/highcharts.js"></script>
   <script src="hc/code/modules/exporting.js"></script>

   <!--<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">-->
   <!--<link rel="stylesheet" type="text/css" href="../../css/bootstrap.css">-->
   <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   <style type="text/css">
   *{
       margin: 0;
       padding: 0;
   }

   html, body{
       background: rgb(236,240,245);
   }
   .titulo{
       border-bottom: 0.5px solid #F2F2F2;
       margin-bottom: 5px;
   }
   .container{
       width: 100%;
   }
   .bg-purple {
   background-color: #605ca8 !important;
   }
   .bg-green{
   background-color: #00a65a !important;
   }
   .bg-yellow{
   background-color: #f39c12 !important;
   }
   .bg-aqua{
   background-color: #00c0ef !important;
   }
.info-box {
   display: block;
   min-height: 90px;
   background: #fff;
   width: 100%;
   box-shadow: 0 1px 1px rgba(0,0,0,0.1);
   border-radius: 2px;
   margin-bottom: 15px;
}
.info-box.bg-purple{
   color: #fff !important;
}
.info-box.bg-green{
   color: #fff !important;
}
.info-box.bg-yellow{
   color: #fff !important;
}
.info-box.bg-aqua{
   color: #fff !important;
}
.info-box-icon {

   border-top-left-radius: 2px;
   border-top-right-radius: 0;
   border-bottom-right-radius: 0;
   border-bottom-left-radius: 2px;
   display: block;
   float: left;
   height: 90px;
   width: 90px;
   text-align: center;
   font-size: 45px;
   line-height: 90px;
   background: rgba(0,0,0,0.2);
}
.info-box-content {
   padding: 5px 10px;
   margin-left: 90px;
}
.info-box-text {
   text-transform: uppercase;
}
.info-box-number {
   display: block;
   font-weight: bold;
   font-size: 18px;
}
.info-box .progress, .info-box .progress .progress-bar {
   border-radius: 0;
}
.info-box .progress {
   background: rgba(0,0,0,0.2);
   margin: 5px -10px 5px -10px;
   height: 2px;
}
.info-box .progress .progress-bar {
   background: #fff;
}
.info-box .progress, .info-box .progress .progress-bar {
   border-radius: 0;
}
.progress-bar {
   float: left;
   height: 100%;
   font-size: 12px;
   line-height: 20px;
   color: #fff;
   text-align: center;
   transition: width .6s ease;
}
.progress-description {
   margin: 0;
}
.progress-description, .info-box-text {
   display: block;
   font-size: 14px;
   white-space: nowrap;
   overflow: hidden;
   text-overflow: ellipsis;
}
.col-md-4{
   padding-right: 25px;
}
.table{
   width: 98%;
}
#panel1{
border-top: 3px solid #C2C2C2;
}
#panel2{
   border-top: 3px solid #337ab7;
}
#panel3{
   border-top: 3px solid #1DBF38;
}
a{
   text-decoration: none;
   color: #fff;
}
</style>
<div class="container">
 <!--<div class="row">
   <div class="col l6">
   </div>
 </div>-->
<div class="nota">
   <h3>Panel de Control</h3>
   <a href="../ingreso_ventas/salidav2.php" class="btn btn-primary" style="float: right;">Nueva Venta</a>
</div>


<div class="panel panel-default" id="panel1">
   <div class="titulo" style="margin-left: 10px">
   <h4>Reportes Generales <?php echo date('Y')?></h4>
 <div class="row">
   <div class="col l8 s12"> <!--hi Highcharts-->
       <div id="container"></div>
   </div><!--hi Highcharts-->
   <!--esto es para los almacenes-->
   <div class="col l4 s12">
       <div class="info-box bg-purple"><!--Inicio del modaro stock de productos-->
         <span class="info-box-icon"><i class="fa fa-tags"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Inventario</span>
           <span class="info-box-number">
             <a href="../inventario/seleccionar_fecha.php">VER<i class="fa fa-pencil-square-o" id="com" ></i></a>
           </span>
           <div class="progress">
             <div class="progress-bar" style="width: 100%"></div>
           </div>
           <span class="progress-description">
             <?php
               echo "<a href='../reportes/stock/stock.php'>Productos en stock: ".$ArrTotales['ProductoT']."</a>";
             ?>
           </span>
         </div>
       </div><!--Fin del modaro stock de productos-->

       <div class="info-box bg-green"> <!--Inicio del verde Ventas -->
         <span class="info-box-icon"><i class="fa fa-money"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Ventas 2017</span>
           <span class="info-box-number">
             <?php
             echo $ArrTotales['VentasT'];
             ?>
           </span>
           <div class="progress">
             <div class="progress-bar" style="width: 100%"></div>
           </div>
           <span class="progress-description">

               <a href='../reportes/rango_fechas/rang_fec_ventas.php'>Boletas Emitidas : <?php echo $ArrTotales['VentasT'];  ?></a>

         </span>
         </div>
       </div> <!--fin del verde venetas -->
       <div class="info-box bg-yellow"><!--Inicio del amarillo compras--->
         <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Compras 2017</span>
           <span class="info-box-number">
             <?php

               echo $ArrTotales['ComprasT'];

             ?>
           </span>
           <div class="progress">
             <div class="progress-bar" style="width: 100%"></div>
           </div>
           <span class="progress-description">
               <a href='../reportes/rango_fechas/rang_fec_compras.php'>Facturas Ingresadas : <?php echo $ArrTotales['ComprasT']; ?></a>
           </span>
         </div>
       </div><!--fin del amarillo compras--->
       <div class="info-box bg-aqua"><!--Inicio prooveedores-->
         <span class="info-box-icon"><i class="fa fa-user"></i></span>
         <div class="info-box-content">
           <span class="info-box-text">Proveedores</span>
           <span class="info-box-number">
             <?php
                   echo $ArrTotales['ProveedoresT'];
             ?>
           </span>
           <div class="progress">
             <div class="progress-bar" style="width: 100%"></div>
           </div>
           <span class="progress-description">
             <a href="../mantenimiento/proveedor/proveedor.php">Detalles</a> </span>
           </div>
       </div><!--Inicio prooveedores-->
   </div>
 </div>

</div>

<div class="row">
<div class="col l7 s12">
<div class="panel panel-default" id="panel2">
<div class="titulo" style="margin-left: 10px">
   <h4>Ultimas Ventas</h4>
   <table class="table">
       <tr>
           <th>Boleta N°</th>
           <th>Cliente</th>
           <th>Fecha</th>
           <th>Total</th>
           <th>Detalles</th>
       </tr>
         <?php
         foreach ($ultimasV as $VentasU ) {
               echo "<tr>";
                   echo "<td>".$VentasU['NUMCOMPROBANTE']."</td>";
                   echo "<td>".$VentasU['NOMBRE']."</td>";
                   echo "<td>".$VentasU['FECHACOMPROBANTE']."</td>";
                   echo "<td>".$VentasU['TOTAL']."</td>";
                   echo "<td><button onClick='verDetalle(".$VentasU['NUMCOMPROBANTE'].")'class='btn btn-default btn-xs' title='Detalle Factura'><i class ='icon ion-md-brush'></i></button></td>";
               echo "</tr>";
         }
         ?>
   </table>

    <div class="modal fade" id="modalDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             <h4 class="modal-title" id="myModalLabel"><b>Detalle</b></h4>
           </div>
           <div class="modal-body" id="datosAqui">
           </div>
         </div>
      </div>
  </div>
   <hr></hr>
   <div class="btn-group btn-group-sm">
   <a href="#" class="btn btn-default" style="float: left;">Nueva Venta</a>
   </div>
</div>
</div>
</div>
<div class="col l5">
<div class="panel panel-default" id="panel3">
<div class="titulo" style="margin-left: 10px">
   <h4>Productos más vendidos del dia</h4>
   <table class="table table-bordered">
       <tr>
           <th>Producto</th>
           <th>Cantidad</th>
       </tr>
   <?php

   date_default_timezone_set('America/Bogota');
   setlocale(LC_TIME, "spanish");
   echo "<p>" . strftime("%A, %d de %B de %Y") . "</p>\n";

   foreach ($ProMasVen as $MasVendidos ) {
       echo "<tr>";
           echo "<td style='line-height:5pt;'>".$MasVendidos['NOMBRE_PRODUCTO']."</td>";
           echo "<td style='line-height:5pt;'>".$MasVendidos['TOTAL']."</td>";
       echo "</tr>";
   }
   ?>
   </table>
   <a href="movimiento_productos/productos_vendidos.php" style="color: #337ab7;">Ver detalle</a>
</div>
</div>
</div>
</div>

<!--Modal opreviw de las tikest-->
<div id="modal1" class="modal" >
   <div class="modal-content" id="ModalPreviewTikets">
   </div>
</div>


<div id='datosAqui1'>

</div>
<!--button id="plain">Defecto</button>
<button id="inverted">Invertido</button>
<button id="polar">Pastel</button-->
<script type="text/javascript">
var chart = Highcharts.chart('container', {

   title: {
       text: 'Ventas del año'
   },

   subtitle: {
   <?php
       date_default_timezone_set('America/Bogota');
       $a=date('Y');
   ?>
       text: '<?php echo $a;?>'
   },

   xAxis: {
       categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octtubre', 'Noviembre', 'Diciembre']
   },

   series: [{
       type: 'column',
       colorByPoint: true,
       data:[
       <?php
       include('../../conexion.php');
       date_default_timezone_set('America/Bogota');
       $ano=date('Y');
           for ($m=1; $m <=12 ; $m++) {
               $sql_mes=mysqli_query($conexion,"SELECT COUNT(NUMCOMPROBANTE) AS TOTAL FROM comprobante_venta WHERE MONTH(FECHACOMPROBANTE)='$m' AND YEAR(FECHACOMPROBANTE)='$ano'");
               while ($rt=mysqli_fetch_array($sql_mes)) {
                 ?>
           <?php echo $rt['TOTAL'].",";?>
       <?php
               }
           }
       ?>
       ],
       showInLegend: false
   }]

});
$('#plain').click(function () {
   chart.update({
       chart: {
           inverted: false,
           polar: false
       },
       subtitle: {
           text: 'Plain'
       }
   });
});
$('#inverted').click(function () {
   chart.update({
       chart: {
           inverted: true,
           polar: false
       },
       subtitle: {
           text: 'Inverted'
       }
   });
});
$('#polar').click(function () {
   chart.update({
       chart: {
           inverted: false,
           polar: true
       },
       subtitle: {
           text: 'Polar'
       }
   });
});

$(document).ready(function(){
	// the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
	$('.modal').modal();
});

function verDetalle(codigo){
	var peticion='PreviewComprobante';
		$.ajax({
				type: 'POST',
				data: {'codigo':codigo,'peticion':peticion},
				url: 'controlador/HomeC.php',
				success: function(data){
					console.log(data);
						$('#ModalPreviewTikets').empty();
						$('#ModalPreviewTikets').append(data);
						$('#modal1').modal('open');
						$("#modal1").animate({ scrollTop: 0 }, 600);
						/*$('#modalDetalle').modal({
								show:true,
								backdrop:'static',
						});*/
				}
			});
		return false;
}


</script>
<!--<script src="iframe/js/java.js"></script>-->

   <!--<script src="../../js/jquery.js"></script>-->

   <!-- Bootstrap Core JavaScript -->
   <!--<script src="../../js/bootstrap.min.js"></script>-->
