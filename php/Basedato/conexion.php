<?php
class Conexion{

		public function Conectarse()
		{

			$servidor='localhost';
			$usuario_db='root';
			$password_db='1234';
			$bd='bodega';

			$link = mysqli_connect($servidor,$usuario_db,$password_db,$bd);
			return $link;
		}

		public function ArmarConsulta($sql)
		{
			$link=$this->Conectarse();
			$res=mysqli_query($link,$sql);
			while ($ARR=mysqli_fetch_array($res))
			{$Respuesta[]=$ARR;}
			if (isset($Respuesta)) { //por sia caso este vacia no genera nungun erro
				return $Respuesta;
			}else {
				return $Respuesta=array();
			}

		}
}


/*
class Conexion{

	var $servidor;
	var $baseDatos;
	var $usuario;
	var $clave;
	var $cn; //Conexion
	var $rs; //ResultaSet | Flag

	function Conexion(){
		$this->servidor 	= "localhost";
		$this->baseDatos	= "controlx";
		$this->usuario		= "root";
		$this->clave 		= "1234";
	}

	function abrir($db=''){
		$baseDatos = ($db=='') ?  $this->baseDatos : $db;
		$this->cn = new mysqli($this->servidor,
								$this->usuario,
								$this->clave,
								$baseDatos);
	}

	function ejecutar($sql,$db=''){
		$this->abrir($db);
		if ($this->cn->connect_error) { Die("Error de Conexion");}
		else
		$this->rs 	= 	$this->cn->query("SET NAMES 'utf8'");
		$this->rs 	= 	$this->cn->query("SET CHARACTER SET 'utf8'");
		$this->rs 	= 	$this->cn->query($sql);
		return $this->rs;
	}

	function cerrar(){
		$this->abrir();
		return $this->cn->close();
	}


}
	*/
?>
