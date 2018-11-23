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
                                    <span class="pull-left" style='cursor:pointer'>Ver Detalles</span>
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
