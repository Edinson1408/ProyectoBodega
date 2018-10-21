<!DOCTYPE html>
<html>
<head>
	<title></title>
    <link rel="stylesheet" type="text/css" href="../../../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../../css/bootstrap.css">
    <link href="../../../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      .form-control{
        border-radius: 0;
      }
      .tab-pane{
        padding-top: 15px;
      }
    *{
        margin: 0;
        padding: 10;
    }
    .btn{
      margin-top: 12px;
      margin-left: 73px;
    }
    html, body{
        background: rgb(236,240,245);
        padding: 20px;
    }
    .titulo{
        border-bottom: 0.5px solid #F2F2F2; 
        margin-bottom: 5px;
    }
    .container{
        width: 100%;
        background: #ffffff;
    }
    .table{
      width: 98%;
      margin:auto; 
    }
    #panel2{
    border-top: 3px solid #337ab7;
}
    </style>
</head>
<body>
<div class="container">
      <?php
include('../../../conexion.php');
        $id=$_REQUEST['id'];
        $sql_pro=mysql_query("SELECT a.*, b.DE_CATEGORIA AS NOMBRE, c.DES_TUR as TURNO FROM USUARIO AS a, CATEGORIA as b, TURNO as c WHERE a.CATEGORIA=b.ID_CATEGORIA AND a.ID_TURNO=c.ID_TURNO AND a.con_user='$id'",$conexion);
        $r=mysql_fetch_array($sql_pro);
      ?>
      <div class="titulo" style="margin-left: 10px">
        <h4>Modificar usuario : <?php echo $r['nom_user'];?></h4>
      </div>
        <form action="mod_proceso.php?id=<?php echo $r['con_user']?>" method="POST" class="form-horizontal">
            <div class="form-group">
            <label class="control-label col-xs-3">Usuario
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="user" placeholder="usuario01" value="<?php echo $r['user'];?>">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Contraseña
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm" name="contra" placeholder="123abc" value="<?php echo $r['con_user'];?>">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Cargo
            </label>
            <div class="col-xs-6">
            <select class="form-control input-sm" name="cargo">
              <option value="<?php echo $r['categoria'];?>"><?php echo $r['NOMBRE'];?></option>
              <?php
              $user=mysql_query("SELECT * FROM categoria",$conexion);
              while ($y=mysql_fetch_array($user)) {
              echo "<option value='".$y['ID_CATEGORIA']."'>".$y['DE_CATEGORIA']."</option>";
              }
              ?>
            </select>
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-xs-3">Turno
            </label>
            <div class="col-xs-6">
            <select class="form-control input-sm" name="turno">
              <option value="<?php echo $r['ID_TURNO'];?>"><?php echo $r['TURNO'];?></option>
              <?php
              $user=mysql_query("SELECT * FROM TURNO",$conexion);
              while ($e=mysql_fetch_array($user)) {
              echo "<option value='".$e['ID_TURNO']."'>".$e['DES_TUR']."</option>";
              }
              ?>
            </select>
            </div>
            </div>
            <div class="form-group">
            <label class="control-label col-xs-3">Nombre
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="nom" placeholder="Renato Luggi" value="<?php echo $r['nom_user'];?>" >
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Apellido
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="ape" placeholder="Gallardo Perez" value="<?php echo $r['ape_user'];?>">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Correo
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="email" placeholder="ejemplo@hotmail.com" value="<?php echo $r['correo'];?>">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Telefono
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="tel" placeholder="949948588" value="<?php echo $r['telefono'];?>">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Dirección
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="dir" placeholder="Jr.ejemplo1111" value="<?php echo $r['direccion'];?>">
            </div>
            </div>
            <center><input type="submit" name="modificar" class="btn btn-primary" value="Modificar" style="border-radius: 0; "></center>
        </form>
</div>
    <script src="../../../js/jquery.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
</body>
</html>