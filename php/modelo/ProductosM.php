<?php


	class Productos extends Conexion
	{

		public function ListarProducto()
		{
			$sql="SELECT a.*, b.CLASE_PRODUCTO AS NOMBRE FROM producto as a, clasificacion_producto as b WHERE a.CLASE_PRODUCTO=b.COD_CLASIFICACION Order by a.Nombre_producto  limit 10";
			return $this->ArmarConsulta($sql);

		}

		public function MostrarProducto($codP)

		{
				$sql="SELECT a.*, b.CLASE_PRODUCTO as NOMBRE_TIPO,b.COD_CLASIFICACION  FROM producto as a, clasificacion_producto as b WHERE a.CLASE_PRODUCTO=b.COD_CLASIFICACION  and a.COD_PRODUCTO='$codP'";
				return $this->ArmarConsulta($sql);
		}

		public function EliminarProducto($codigo)
		{
			$link=$this->Conectarse();
			$sql="DELETE FROM producto where COD_PRODUCTO='$codigo'";
			$res=mysqli_query($link,$sql);

		}

		public function EditarProducto($nomP,$puP,$pvP,$tiP,$codP)
		{
			$link=$this->Conectarse();
			$sql="UPDATE producto SET
					NOMBRE_PRODUCTO='$nomP',
					PRECIO_UNITARIO='$puP',
					PRECIO_VENTA='$pvP',
					CLASE_PRODUCTO='$tiP'
					WHERE COD_PRODUCTO='$codP' ;";
			mysqli_query($link,$sql);
			//return $sql;

		}

		public function InsertarProducto($codP,$nomP,$pvP,$puP,$tiP)
		{
			$link=$this->Conectarse();
			$sql="INSERT INTO producto VALUES ('$codP','$nomP','$pvP','$puP','$tiP')";
			mysqli_query($link,$sql);

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

	}

?>
