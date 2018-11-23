<!DOCTYPE html>
<html lang="en">
<?php
//include('../../conexion.php');

?>
<head>
  <!-- Bootstrap Core CSS -->
    <link href="almacenes/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="almacenes/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="almacenes/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
    </style>
</head>

<body>
      <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <center><h1 class="page-header">
                            Bodega <br><small>Productos</small>
                        </h1></center>
                    </div>
                </div>

            <div class="row">
                <?php
                    while($r=mysqli_fetch_array($DatosStock))
                    {
                        
                 ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <!--Icono-->
                                        <h2><i class="glyphicon glyphicon-book"></i> </h2>   
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                            <?=$r['CANTIDAD']?>
                                        </div>
                                        <div><?=$r['NOMCLASIFICACION']?></div>
                                    </div>
                                </div>
                            </div>
                            <!--<a href="productos/galleta.php" target="tiframe">-->
                            <a onclick="VerDetalleAl('<?=$r['0']?>','<?=$r['NOMCLASIFICACION']?>')">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                <?php
                   }
                ?>
            </div>
    </div>


                <!-- <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">

                           <h2><i class="glyphicon glyphicon-book"></i> </h2>  
                                        
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                         <?php   
                                         //$con=mysqli_query("SELECT count(CODPRODUCTO) AS TOTAL FROM almacen WHERE CODCLASIFICACION='BEBI'",$conexion);
                                          //$f=mysqli_fetch_array($con);
                                          //  echo $f['TOTAL']
        
                                                ?>

                                        </div>
                                        <div>Galletas</div>
                                    </div>
                                </div>
                            </div>
                            <a href="productos/galleta.php" target="tiframe">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-beer fa-4x" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                         <?php   
                                         ///$con=mysql_query("SELECT count(COD_ALMACEN) AS TOTAL FROM almacen WHERE COD_CLASIFICACION='1'",$conexion);
                                         // $f=mysql_fetch_array($con);
                                 //echo $f['TOTAL']
        
                                                ?>

                                        </div>
                                        <div>Licor</div>
                                    </div>
                                </div>
                            </div>
                            <a href="productos/licor.php" target="tiframe">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-glass fa-4x" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                         <?php   
                                         //$con=mysql_query("SELECT count(COD_ALMACEN) AS TOTAL FROM almacen WHERE COD_CLASIFICACION='3'",$conexion);
                                         // $f=mysql_fetch_array($con);
                                        //echo $f['TOTAL']
        
                                                ?>

                                        </div>
                                        <div>Gaseosas</div>
                                    </div>
                                </div>
                            </div>
                            <a href="productos/gaseosa.php" target="tiframe">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalles</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div> -->
    
            <!-- /.container-fluid -->


        <!-- /#page-wrapper -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

<script>
VerDetalleAl=(CodClasificacion,NomClasificacion)=>
{
    let peticion='DetalleAlmacen';

     $.ajax({
                url:"controlador/AlmacenC.php",
                method:"POST",
                data:{peticion:peticion,CodClasificacion:CodClasificacion,NomClasificacion:NomClasificacion},
                success: function(resultado){
                    $("#contenidobody").html(resultado);

                }
            });

   
    //console.log(ss);
    
}
</script>

</html>
