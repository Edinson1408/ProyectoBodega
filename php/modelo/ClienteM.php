<?php
	class Clinte extends Conexion
	{

		public function ListaProveedor()
		{
			$sql="SELECT PER.IDPERSONA,PER.NUMDOC,PER.TELEFONO,CONCAT(PER.NOMBRES,' ',PER.APELLIDOS) AS RAZONSOCIAL ,PER.CORREO,
			CL.CELULAR,CL.FENACIMIENTO,CL.CIUDAD  FROM 
					persona  PER , cliente  CL
					WHERE PER.IDPERSONA=CL.IDPERSONA";

			return $this->ArmarConsulta($sql);

		}

		public function MostrarCliente($codP)

		{
			$link=$this->Conectarse();
			$Sql="SELECT PER.IDPERSONA,PER.IDTIPODOC,PER.NUMDOC,PER.TELEFONO,PER.CORREO,PER.NOMBRES,PER.APELLIDOS,PER.DIRECCION,
			CL.CELULAR,CL.FENACIMIENTO,CL.CIUDAD FROM 
			persona  PER , cliente  CL
			WHERE PER.IDPERSONA=CL.IDPERSONA and CL.IDPERSONA='$codP'";
			$res=mysqli_query($link,$Sql);
			$r=mysqli_fetch_object($res);
			return $r;
		}

		public function InsertaPersona ($link,$_Arr){
			
	
			$Nombre=($_Arr['Nomproveedor']=='')?$_Arr['NomCliente']:$_Arr['Nomproveedor'];
	
			 $Sql="INSERT INTO persona (NOMBRES,APELLIDOS,IDTIPODOC,NUMDOC,TELEFONO,CORREO,DIRECCION)  VALUES 
			(
				'".$Nombre."',
				'".$_Arr['ApeCliente']."',
				'".$_Arr['TipoDoc']."',
				'".$_Arr['RUCDNI']."',
				'".$_Arr['telefono']."',
				'".$_Arr['correo']."',
				'".$_Arr['direccion']."'
				)";
			mysqli_query($link,$Sql);
			return mysqli_insert_id($link);
		}

		public function InsertarCliente($_Arr)
		{
			$link=$this->Conectarse();
			$ultimoId=$this->InsertaPersona($link,$_Arr);

			$sql="INSERT INTO  cliente
			(IDPERSONA,
				CELULAR,
				FENACIMIENTO,
				CIUDAD)
			  VALUES 
			 (
				'".$ultimoId."',
				 '".$_Arr['Celular']."',
				 '".$_Arr['FNacimiento']."',
				 ' '
			 )";
			$res=mysqli_query($link,$sql);
		}

		public function UpdateCliente($_Arr){
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
