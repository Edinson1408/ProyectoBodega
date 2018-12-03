<?php
require '../Basedato/conexion.php';
require '../modelo/ClienteM.php';
$ObjCliente=new Clinte();
switch ($_POST['peticion']) {
  case 'lista':
    $Proveedores=$ObjCliente->ListaProveedor();
  require '../vista/ClienteLista.php';
    break;

  case 'agregar':
		$Ruc='';
		$NomPro='';
		$NEjecutivo='';
		$RazonSocial='';
		$Dir='';
		$Telefono='';
		$Correo='';
		$IdPersona='';
		$oculto='1';
		$tituloModal='Agregar Cliente';
    require '../vista/ClienteCM.php';
    break;
  case 'insertar':

    $ruc=$_POST['RUCDNI'];
    $nombre=$_POST['Nomproveedor'];
    $Direccion=$_POST['direccion'];
    $telefono=$_POST['telefono'];
    $correo=$_POST['correo'];
  if($_POST['CampoOculto']==1)
  {
    //insertar
      $ObjProveedor->InsertarProveedor($_POST);
  }elseif ($_POST['CampoOculto']==2) {
    // actualizar
    $ObjProveedor->UpdateProveedor($_POST);
  }
  break;
  default:

    break;
}
?>
