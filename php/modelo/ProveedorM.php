<?php
	class Proveedor extends Conexion
	{

		public function ListaProveedor()
		{
			$sql="SELECT PER.IDPERSONA,PER.NUMDOC,PER.TELEFONO,PER.CORREO,PRO.RAZONSOCIAL,PRO.DIRFISCAL,PRO.ESTADO FROM 
					persona  PER , proveedores  PRO
					WHERE PER.IDPERSONA=PRO.IDPERSONA";

			return $this->ArmarConsulta($sql);

		}

		public function MostrarProveedor($codP)

		{
			/*$sql="SELECT * FROM Proveedores where RUC_CLIENTE='$codP'";*/
			$sql="SELECT PER.IDPERSONA,PER.NUMDOC,PER.TELEFONO,PER.CORREO,PRO.RAZONSOCIAL,PRO.DIRFISCAL,PRO.ESTADO FROM 
			persona  PER , proveedores  PRO
			WHERE PER.IDPERSONA=PRO.IDPERSONA and PRO.IDPERSONA='$codP'";
			return $this->ArmarConsulta($sql);
		}

		public function InsertarProveedor($ruc,$nombre,$numero,$razon,$Direccion,$telefono,$correo)
		{
			$link=$this->Conectarse();
			$sql="INSERT INTO  proveedores VALUES ('$ruc','$nombre','$numero','$razon','$Direccion',$telefono,'$correo')";
			$res=mysqli_query($link,$sql);
		}

		public function UpdateProveedor($_Arr){
			print_r($_Arr);
		

			$PersonaUpdate="UPDATE persona SET
			NOMBRES='".$_Arr['Nomproveedor']."',
			TELEFONO='".$_Arr['telefono']."',
			CORREO='".$_Arr['correo']."',
			DIRECCION='".$_Arr['direccion']."'
			WHERE IDPERSONA='".$_Arr['Idpersona']."' ;";

			$ProveedorUpdate="UPDATE proveedores SET
			RAZONSOCIAL='".$_Arr['Nomproveedor']."',
			DIRFISCAL='".$_Arr['direccion']."',
			ESTADO='1'
			WHERE 
			IDPERSONA='".$_Arr['Idpersona']."';";
			$link=$this->Conectarse();
			mysqli_query($link,$PersonaUpdate);
			mysqli_query($link,$ProveedorUpdate);

		}

	}
?>
