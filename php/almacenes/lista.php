<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
<div class="panel-group" id="accordion">
      <?php
      include('../../conexion.php');
      $sql_stock=mysql_query("SELECT * FROM CLASIFICACION_PRODUCTO order by COD_CLASIFICACION",$conexion);
      while ($r=mysql_fetch_array($sql_stock)) {
      	$nom=$r['CLASE_PRODUCTO'];
      	$cod=$r['COD_CLASIFICACION'];
      	echo "<div class='panel panel-default'>
    <div class='panel-heading'>
      <h4 class='panel-title'>
              <a data-toggle='collapse' data-parent='#accordion' href='#collapse".$r['COD_CLASIFICACION']."'>
        ".$nom."</a>
      </h4>
    </div>
        <div id='collapse".$r['COD_CLASIFICACION']."' class='panel-collapse collapse'>
      <div class='panel-body'></div>
    </div>
  </div>";
       echo $cod;
      }
      ?>
</div>
</div>
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>