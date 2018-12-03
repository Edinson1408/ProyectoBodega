<?php
	class Clinte extends Conexion
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

		public function InsertaPersona ($link,$_Arr){
			
			 $Sql="INSERT INTO persona (NOMBRES,IDTIPODOC,NUMDOC,TELEFONO,CORREO,DIRECCION)  VALUES 
			(
				'".$_Arr['Nomproveedor']."',
				'4',
				'".$_Arr['RUCDNI']."',
				'".$_Arr['telefono']."',
				'".$_Arr['correo']."',
				'".$_Arr['direccion']."'
				)";
			mysqli_query($link,$Sql);
			return mysqli_insert_id($link);
		}

		public function InsertarProveedor($_Arr)
		{
			$link=$this->Conectarse();
			$ultimoId=$this->InsertaPersona($link,$_Arr);

			$sql="INSERT INTO  proveedores
			(IDPERSONA,
				RAZONSOCIAL,
				DIRFISCAL,
				ESTADO)
			  VALUES 
			 (
				'".$ultimoId."',
				 '".$_Arr['Nomproveedor']."',
				 '".$_Arr['direccion']."',
				 '1'
			 )";
			
			
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


		public function EliminarPersona($IdPersona)
		{
			echo $Sql="DELETE FROM persona where IDPERSONA='".intval($IdPersona)."'";
			$link=$this->Conectarse();
			mysqli_query($link,$Sql);
		
		}

	}
?>
