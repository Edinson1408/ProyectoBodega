<?php
	class Proveedor extends Conexion
	{

		public function ListaProveedor()
		{
			$sql="SELECT * FROM Proveedores order by NOMBRE_CLIENTE ASC";

			return $this->ArmarConsulta($sql);

		}

		public function MostrarProveedor($codP)

		{
			$sql="SELECT * FROM Proveedores where RUC_CLIENTE='$codP'";
			return $this->ArmarConsulta($sql);
		}

		public function InsertarProveedor($ruc,$nombre,$numero,$razon,$Direccion,$telefono,$correo)
		{
			$link=$this->Conectarse();
			$sql="INSERT INTO  proveedores VALUES ('$ruc','$nombre','$numero','$razon','$Direccion',$telefono,'$correo')";
			$res=mysqli_query($link,$sql);
		}

	}
?>
