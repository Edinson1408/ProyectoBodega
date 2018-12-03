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
    $TipoDoc='';
		$NumDoc='';
    $NomPro='';
    $Apellido='';
		$NEjecutivo='';
		$RazonSocial='';
		$Dir='';
		$Telefono='';
		$Correo='';
    $IdPersona='';
    $Celular='';
    $oculto='1';
    $FNacimiento='';
    $tituloModal='Agregar Cliente';
    require '../vista/ClienteCM.php';
    
    break;
  case 'editar':
      $tituloModal='Editar Cliente';
      $objeMysqCl=$ObjCliente->MostrarCliente($_POST['codigo']);
      $TipoDoc=$objeMysqCl->IDTIPODOC;
      $NumDoc=$objeMysqCl->NUMDOC;
      $NomPro=$objeMysqCl->NOMBRES;
      $Apellido=$objeMysqCl->APELLIDOS;
      $Dir=$objeMysqCl->DIRECCION;
      $Telefono=$objeMysqCl->TELEFONO;
      $Correo=$objeMysqCl->CORREO;
      $IdPersona=$objeMysqCl->IDPERSONA;
      $Celular=$objeMysqCl->CELULAR;
      
      $FNacimiento=$objeMysqCl->FENACIMIENTO;
      $oculto='2';
      
    require '../vista/ClienteCM.php';
  break;
  
  case 'insertar':
    $ruc=$_POST['RUCDNI'];
    $nombre=$_POST['Nomproveedor'];
    $Direccion=$_POST['direccion'];
    $telefono=$_POST['telefono'];
    $correo=$_POST['correo'];
    //NomCliente
    //ApeCliente
    //Celular
    //FNacimiento
  if($_POST['CampoOculto']==1)
  {
    //insertar
      $ObjCliente->InsertarCliente($_POST);
  }elseif ($_POST['CampoOculto']==2) {
    // actualizar
    //$ObjCliente->UpdateCliente($_POST);
  }
  break;
  default:

    break;
}
?>
