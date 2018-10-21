<?php


/**
* 
*/
class mantenimiento_factura
{
	private $conexion=null;
	

	function __construct()
	{
		include('conexion.php');
	}

	function get_tabla($tabla)
	{
		$Query=mysql_query("SELECT * FROM factura",$this->conexion);
		while ($tbl=mysql_fetch_array($Query)) 
		{
			$Arr_tbl[]=$tbl;	
		}

		return $Arr_tbl;
	}

	function get_detalle($factura)
	{
		$Query=mysql_query("SELECT a.*,b.NOMBRE_PRODUCTO FROM detalle_factura as a, producto as b WHERE a.COD_PRODUCTO=b.COD_PRODUCTO and nro_factura='$factura'",$this->conexion);
		while ($tbl=mysql_fetch_array($Query)) 
		{
			$Arr_tbl[]=$tbl;	
		}

		return $Arr_tbl;
	}


	function eliminar_factura($fac,$serie,$pro)
	{
		mysql_query("DELETE FROM factura where nro_factura='$fac'
												and serie_factura ='$serie'
												and ruc_cliente='$pro'",$this->conexion);
		mysql_query("DELETE FROM detalle_factura WHERE nro_factura='$fac'",$this->conexion);
	}


	function disminuir_almacen($cod_producto,$n)
	{
		$Query=mysql_query("SELECT cantidad FROM almacen WHERE  cod_producto='$cod_producto'",$this->conexion);

		$cantidad_amterior=mysql_fetch_array($Query);
		$CA=$cantidad_amterior['cantidad'];
		$n;
		$Nuv_cantidad=$CA-$n;
		$Nuv_cantidad;

		mysql_query("UPDATE almacen SET  cantidad='$Nuv_cantidad' WHERE cod_producto='$cod_producto' ",$this->conexion);
	}



	function aumentar_almacen($cod_producto,$n)
	{
		$Query=mysql_query("SELECT cantidad FROM almacen WHERE  cod_producto='$cod_producto'",$this->conexion);

		$cantidad_amterior=mysql_fetch_array($Query);
		$CA=$cantidad_amterior['cantidad'];
		$n;
		$Nuv_cantidad=$CA+$n;
		$Nuv_cantidad;
		mysql_query("UPDATE almacen SET  cantidad='$Nuv_cantidad' WHERE cod_producto='$cod_producto' ",$this->conexion);


	}

	function actu_importe_de($factura,$cod_producto,$precio_u,$cantidad_n)
	{
			$nuevo_importe=$precio_u*$cantidad_n;

			mysql_query("UPDATE detalle_factura SET importe='$nuevo_importe' where nro_factura='$factura' and cod_producto='$cod_producto' ",$this->conexion);
	}

	function actulizar_factura_monto($factura,$serie,$proveedor)
	{
		$Query=mysql_query("SELECT SUM(importe) as suma FROM detalle_factura where nro_factura='$factura' ",$this->conexion);
		$num=mysql_fetch_array($Query);
		$sub_total=$num['suma'];
		$igv=$sub_total*0.18;
		$total=$sub_total+$igv;

		mysql_query("UPDATE factura SET sub_total='$sub_total' , igv='$igv' , total='$total' WHERE nro_factura='$factura' and serie_factura='$serie' and ruc_cliente='$proveedor' ",$this->conexion);

	}

	function actualizar_todo($cod_factura,$cod_producto,$cantidad_nueva,$cantidad_anterior,$precio_u,$serie,$proveedor)
	{
		//actualizar el detalle
		$SQL_EDI_DETALLE=mysql_query("UPDATE detalle_factura set cantidad_producto='$cantidad_nueva' where nro_factura='$cod_factura' and cod_producto='$cod_producto'",$this->conexion);
		//actualizar movimiento
		$SQL_movi_de=mysql_query("UPDATE movimiento_almacen set cantidad_producto='$cantidad_nueva' where nro_factura='$cod_factura' and cod_producto='$cod_producto'",$this->conexion);

		$this->disminuir_almacen($cod_producto,$cantidad_anterior);
		$this->aumentar_almacen($cod_producto,$cantidad_nueva);
		$this->actu_importe_de($cod_factura,$cod_producto,$precio_u,$cantidad_nueva);
		$this->actulizar_factura_monto($cod_factura,$serie,$proveedor);

	}
}




?>