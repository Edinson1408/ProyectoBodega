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

		$oculto='1';
		$tituloModal='Agregar Proveedor';
		require '../vista/ProveedorCM.php';


		break;

	case 'editar':
		$tituloModal='Editar Proveedores';
		$request=$ObjProveedor->MostrarProveedor($_POST['codigo']);
		 foreach ($request as $Proveedor)
		 {
			 $Ruc=$Proveedor['RUC_CLIENTE'];
			 $NomPro=$Proveedor['NOMBRE_CLIENTE'];
			 $NEjecutivo=$Proveedor['NUM_EJE'];
			 $RazonSocial=$Proveedor['NOM_EJE'];
			 $Dir=$Proveedor['DIRECCION_CLIENTE'];
			 $Telefono=$Proveedor['TELEFONO_CLIENTE'];
			 $Correo=$Proveedor['CORREO_CLIENTE'];


		 }
		$oculto='2';

		require '../vista/ProveedorCM.php';
		break;

	case 'insertar':

				$ruc=$_POST['RUCDNI'];
				$nombre=$_POST['Nomproveedor'];
				$numero=$_POST['NEjecutivo'];
				$razon=$_POST['RazonSocial'];
				$Direccion=$_POST['direccion'];
				$telefono=$_POST['telefono'];
				$correo=$_POST['correo'];
			if($_POST['CampoOculto']==1)
			{
				//insertar
					$ObjProveedor->InsertarProveedor($ruc,$nombre,$numero,$razon,$Direccion,$telefono,$correo);
			}elseif ($_POST['CampoOculto']==2) {
				// actualizar
			}





		break;
	default:
		# code...
		break;
}
?>
