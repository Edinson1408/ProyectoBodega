<?php
require '../Basedato/conexion.php';
require '../modelo/ProveedorM.php';

$ObjProveedor=new Proveedor();

switch ($_POST['peticion']) {
	case 'lista':
		$Proveedores=$ObjProveedor->ListaProveedor();
		require "../vista/ProveedorLista.php";
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
		$tituloModal='Agregar Proveedor';
		require '../vista/ProveedorCM.php';


		break;

	case 'editar':
		$tituloModal='Editar Proveedores';
		$request=$ObjProveedor->MostrarProveedor($_POST['codigo']);
		$IdPersona=$_POST['codigo'];
		 foreach ($request as $Proveedor)
		 {
			 $Ruc=$Proveedor['NUMDOC'];
			 $NomPro=$Proveedor['RAZONSOCIAL'];
			 $Dir=$Proveedor['DIRFISCAL'];
			 $Telefono=$Proveedor['TELEFONO'];
			 $Correo=$Proveedor['CORREO'];


		 }
		$oculto='2';

		require '../vista/ProveedorCM.php';
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


	case 'eliminar':
			
			$ObjProveedor->EliminarPersona($_POST['codigo']);


	break;


		break;
	default:
		# code...
		break;
}
?>
