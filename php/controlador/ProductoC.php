<?php
require '../Basedato/conexion.php';
require '../modelo/ProductosM.php';

$objProducto = new Productos();

switch ($_POST['peticion']) {

	case 'lista':
		//$productos=$objProducto->ListarProducto();
		require '../vista/ProductosLista.php';
		break;



	case 'eliminar':

		//funcion eliminar
		$objProducto->EliminarProducto($_POST['codigo']);
		//Listamos nuevamente XD
		$productos=$objProducto->ListarProducto();
		require '../vista/ProductosLista.php';
		break;

	case 'editar':

		 $request=$objProducto->MostrarProducto($_POST['codigo']);
			foreach ($request as $Producto)
			{
				$NomProducto=$Producto['NOMPRODUCTO'];
				$Pc=$Producto['PRECIOCOMPRA'];
				$PV=$Producto['PRECIOVENTA'];
				$CodProducto=$Producto['CODPRODUCTO'];
				$NomTipo=$Producto['NOMBRE_TIPO'];
				$CodmTipo=$Producto['CODCLASIFICACION'];


			}
			$TipoProducto=$objProducto->TipoProducto();
			/*while($row=mysqli_fetch_object($request)):
			      $row->NOMBRE_PRODUCTO=utf8_encode($row->NOMBRE_PRODUCTO);
			      /*$row->Comentario=utf8_encode($row->Comentario);
			      //$row->CodOrg=utf8_encode($row->CodOrg);
			      $row->FCrea=utf8_encode($row->FCrea);
			      $row->IdCliente=utf8_encode($row->IdCliente);*/
			/*endwhile;	*/

			$oculto='2';
			$tituloModal='Editar Producto';
			require '../vista/ProductoCM.php';
		break;


	case 'agregar':
			$NomProducto='';
			$PU='';
			$PV='';
			$CodProducto='';

			$oculto='1';
			$tituloModal='Agregar Producto';
			$TipoProducto=$objProducto->TipoProducto();
			require '../vista/ProductoCM.php';

		break;

	case 'insertar':
	$codP=$_POST['CodProducto'];
	$nomP=$_POST['NomProducto'];
	$PcP=$_POST['PrecioCompra'];
	$pvP=$_POST['PrecioVenta'];
	$tiP=$_POST['TipoProducto'];

		if ($_POST['CampoOculto']==1) {
			$objProducto->InsertarProducto($codP,$nomP,$pvP,$PcP,$tiP);
		}elseif ($_POST['CampoOculto']==2) {
			echo $objProducto->EditarProducto($nomP,$PcP,$pvP,$tiP,$codP);
		}

		//echo 'aca se inserta';
		break;
	case 'AgregarTipoP':
		$tituloModal='Clasificación Producto';
		require '../vista/Productos/FormTipoProducto.php';
		break;
	case 'InsertarTipo':
	$CODCLASIFICACION=$_POST['CodTipo'];
	$NOMCLASIFICACION=$_POST['NomTipo'];
	$ICONO=$_POST['Icono'];
	$COLOR=$_POST['color'];
	$objProducto->AgregarTipoProducto($CODCLASIFICACION,$NOMCLASIFICACION,$ICONO,$COLOR);
		break;
	default:
		echo "no se encontraron peticiones";
		break;
}



?>
