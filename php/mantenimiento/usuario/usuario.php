<?php
include('../../seguridad1.php');
include('../../../conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>usuario</title>
    <meta charset="utf-8">
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
    }
    .titulo{
        border-bottom: 0.5px solid #F2F2F2; 
        margin-bottom: 5px;
    }
    .container{
        width: 100%;
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
<div class="row">
<div class="col-md-10">
<div class="nota">
    <h3>Lista de Usuarios</h3>
</div>
</div>
<div class="col-md-2">
<div class="contenedor-modal">
  <button type="button" class="btn btn-default" data-toggle="modal" data-target="#miModal">+Nuevo</button>
</div>
</div>
</div>
<div class="panel panel-default" id="panel2">
<div class="row">
<div class="col-md-12">
<div class="titulo" style="margin-left: 10px">
    <h4>Lista de usuarios</h4>
</div>
<table class="table table-striped">
<tr>
  <th>Nombre</th>
  <th>Apellido</th>
  <th>Usuario</th>
  <th>Contraseña</th>
  <th>Cargo</th>
  <th>Modificar</th>
  <th>Eliminar</th>
</tr>
<?php
$sql_user=mysql_query("SELECT a.*, b.DE_CATEGORIA AS NOMBRE FROM USUARIO AS a, CATEGORIA as b WHERE a.CATEGORIA=b.ID_CATEGORIA ",$conexion);
while ($r=mysql_fetch_array($sql_user)) {
  echo "<tr>";
    echo "<td>".$r['nom_user']."<a></td>";
    echo "<td>".$r['ape_user']."</td>";
    echo "<td>".$r['user']."</td>";
    echo "<td>".$r['con_user']."</td>";
    echo "<td>".$r['NOMBRE']."</td>";
?>
  <td><a href="modificar.php?id=<?php echo $r['con_user'];?>" class="btn btn-default btn-xs" title="Editar Usuario"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i></a></td>
  <td><a href="eliminar.php?id=<?php echo $r['con_user'];?>" class="btn btn-default btn-xs" title="Eliminar Usuario"><i class="glyphicon glyphicon-remove-circle" aria-hidden="true"></i></a></td>
<?php
  echo "</tr>";
}
?>
</table>
</div>
</div>
</div>
<!--MODALREGISTRAR-->
<div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
      </div>
      <div class="modal-body">
        <form action="registrar_usuario.php" method="POST" class="form-horizontal">
        <ul class="nav nav-tabs">
          <li class="active" ><a data-toggle="tab" href="#registra" id="bord">Usuario</a></li>
          <li ><a data-toggle="tab" href="#menu1" id="bord">Contacto</a></li>
        </ul>

        <div class="tab-content">
          <div id="registra" class="tab-pane fade in active">
            <div class="form-group">
            <label class="control-label col-xs-3">Usuario
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="user" placeholder="usuario01" required>
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Contraseña
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm" name="contra" placeholder="123abc" required>
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Cargo
            </label>
            <div class="col-xs-6">
            <select class="form-control input-sm" name="cargo">
              <option>Cargo</option>
              <?php
              $user=mysql_query("SELECT * FROM categoria",$conexion);
              while ($r=mysql_fetch_array($user)) {
              echo "<option value='".$r['ID_CATEGORIA']."'>".$r['DE_CATEGORIA']."</option>";
              }
              ?>
            </select>
            </div>
            </div>
>            <div class="form-group">
            <label class="control-label col-xs-3">Turno
            </label>
            <div class="col-xs-6">
            <select class="form-control input-sm" name="turno">
              <option>Turno</option>
              <?php
              $user=mysql_query("SELECT * FROM TURNO",$conexion);
              while ($r=mysql_fetch_array($user)) {
              echo "<option value='".$r['ID_TURNO']."'>".$r['DES_TUR']."</option>";
              }
              ?>
            </select>
            </div>
            </div>
          </div>
          <div id="menu1" class="tab-pane fade">
            <div class="form-group">
            <label class="control-label col-xs-3">Nombre
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="nom" placeholder="Renato Luggi">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Apellido
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="ape" placeholder="Gallardo Perez">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Correo
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="email" placeholder="ejemplo@hotmail.com">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Telefono
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="tel" placeholder="949948588">
            </div>
            </div>

            <div class="form-group">
            <label class="control-label col-xs-3">Dirección
            </label>
            <div class="col-xs-6">
            <input type="text" class="form-control input-sm"  name="dir" placeholder="Jr.ejemplo1111">
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <input type="submit" name="registrar" class="btn btn-primary" value="Registrar">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </form>
      </div>
    </div>
  </div>

</div>
    <script src="../../../js/jquery.js"></script>
    <script src="../../../js/bootstrap.min.js"></script>
</body>
</html>