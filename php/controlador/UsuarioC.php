<?php
require '../Basedato/conexion.php';
require '../modelo/UsuarioM.php';
$ObjUsuario=new Usuarios();
switch ($_POST['peticion']) {
  case 'lista':
  $Usuarios=$ObjUsuario->ListaUsuario();

  require '../vista/UsuarioLista.php';
    break;
  case 'Agregar':
        $tituloModal='Agregar Usuario';
        $Nivel='';
        $NumDoc='';
        $NomUsuario='';
        $ApeUsuario='';
        $Direccion='';
        $Telefono='';
        $IdTurno='';
        $UserName='';
        $IdPersona='';
        $oculto='1';
        require '../vista/UsuarioCM.php';
    break;

  case 'Editar':
  $tituloModal='Editar Usuario';
    $IdPersona=$_POST['IdPersona'];
    $SqlUaurio=$ObjUsuario->MostrarUsuario($IdPersona);
    $Nivel=$SqlUaurio->IDCATEGORIA;
    $NumDoc=$SqlUaurio->NUMDOC;
    $NomUsuario=$SqlUaurio->NOMBRES;
    $ApeUsuario=$SqlUaurio->APELLIDOS;
    $Direccion=$SqlUaurio->DIRECCION;
    $Telefono=$SqlUaurio->TELEFONO;
    $IdTurno=$SqlUaurio->IDTURNO;
    $UserName=$SqlUaurio->NOMUSER;
    $oculto='2';
    require '../vista/UsuarioCM.php';
    break;
  case 'Insertar':
echo 'Insertado data';
      if($_POST['CampoOculto']==1)
      {
        //insertar
        $ObjUsuario->InsertarUsuario($_POST);
      }elseif ($_POST['CampoOculto']==2) {
        // actualizar
        $ObjUsuario->UpdateUsuario($_POST);
      }

    
    break;
  default:

    break;
}
?>
