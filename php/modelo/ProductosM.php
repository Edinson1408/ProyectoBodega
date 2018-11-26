<?php

class Productos extends Conexion
	{
		public $Conexion;
		
		function __construct()
		{
			$this->Conexion=$this->Conectarse();
		} 
		public function ListarProducto()
		{
			$sql="SELECT a.*, b.CLASE_PRODUCTO AS NOMBRE FROM producto as a, clasificacion_producto as b WHERE a.CLASE_PRODUCTO=b.COD_CLASIFICACION Order by a.Nombre_producto  limit 10";
			//return $this->ArmarConsulta($sql);

		}

		public function MostrarProducto($codP)

		{
				$sql="SELECT a.*, b.NOMCLASIFICACION as NOMBRE_TIPO,b.CODCLASIFICACION  
					FROM producto as a, clasificacion_producto as b WHERE 
					a.CODCLASIFICACION=b.CODCLASIFICACION  and a.CODPRODUCTO='$codP'";
				return $this->ArmarConsulta($sql);
		}

		public function EliminarProducto($codigo)
		{
			$link=$this->Conectarse();
			$sql="DELETE FROM producto where CODPRODUCTO='$codigo'";
			$res=mysqli_query($link,$sql);

		}

		public function EditarProducto($nomP,$PcP,$pvP,$tiP,$codP)
		{
			$link=$this->Conectarse();
			 $sql="UPDATE producto SET
					NOMPRODUCTO='$nomP',
					PRECIOVENTA='$pvP',
					PRECIOCOMPRA='$PcP',
					CODCLASIFICACION='$tiP'
					WHERE CODPRODUCTO='$codP' ;";
			mysqli_query($link,$sql);
			//return $sql;

		}

		public function InsertarProducto($codP,$nomP,$pvP,$puP,$tiP)
		{
			$link=$this->Conectarse();
			$sql="INSERT INTO producto
			(CODPRODUCTO,
			NOMPRODUCTO,
			PRECIOVENTA,
			PRECIOCOMPRA,
			CODCLASIFICACION
			)VALUES 
			('$codP','$nomP','$pvP','$puP','$tiP')";
			mysqli_query($link,$sql);
			//Insertando tambien al almacen
			$SqlAlmacen="INSERT INTO almacen (CODPRODUCTO,CODCLASIFICACION,CANTIDAD)
			VALUES (
				'$codP',
				'$tiP',
				'0')";
			mysqli_query($link,$SqlAlmacen);
		}

		public function TipoProducto()
		{
			$sql="SELECT * from clasificacion_producto";
			return $this->ArmarConsulta($sql);
		}

		public function AutoCompletadoProducto($buscador)
		{
			$link=$this->Conectarse();
			$Sql="SELECT PRO.*,AL.CANTIDAD FROM producto PRO, almacen AL where AL.CODPRODUCTO=PRO.CODPRODUCTO AND 
			PRO.NOMPRODUCTO  like '%".$buscador."%'  limit 3";


			$query=mysqli_query($link,$Sql);
			// while ($res=mysqli_fetch_array($query))
			// 	{$arr[]=$res;}
				return $query;



		}
		public function AddGrilla($CodProducto)
		{
			$link=$this->Conectarse();
			$Sql="SELECT p.*,a.CANTIDAD FROM producto p, almacen a WHERE a.CODPRODUCTO=p.CODPRODUCTO AND p.CODPRODUCTO='$CodProducto' ";
			$query=mysqli_query($link,$Sql);
			$res=mysqli_fetch_array($query);
			echo json_encode($res);

		}

		public function ValidaStockP($CodProducto)
		{
			$link=$this->Conectarse();
			$Sql="SELECT CANTIDAD FROM almacen where CODPRODUCTO='$CodProducto' ";
			$query=mysqli_query($link,$Sql);
			$res=mysqli_fetch_array($query);
			return $res['CANTIDAD'];

		}

		public function AgregarTipoProducto($CODCLASIFICACION,$NOMCLASIFICACION,$ICONO,$COLOR)
		{
			$Sql="INSERT INTO clasificacion_producto
				VALUES 
				(
					'$CODCLASIFICACION',
					'$NOMCLASIFICACION',
					'$ICONO',
					'$COLOR'
				)";
				mysqli_query($this->Conexion,$Sql);
		}

	}

?>
