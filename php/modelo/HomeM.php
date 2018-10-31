<?php
	class Home extends Conexion
  {

			public function Cajas()
      {
				$link=$this->Conectarse();
				$sql="SELECT COUNT(CODPRODUCTO) as cantidad FROM almacen";
				$res=mysqli_query($link,$sql);
				$ProductoT=mysqli_fetch_object($res);
				//ventas
  			$sql_venta=mysqli_query($link,"SELECT COUNT(*) AS VENTAS FROM comprobante_venta");
				$VentaT=mysqli_fetch_object($sql_venta);
				//Compras
				$sql_compras=mysqli_query($link,"SELECT COUNT(*) AS COMPRAS FROM comprobante_compra ");
				$ComprasT=mysqli_fetch_object($sql_compras);
				//prooveedores
				$sql_proveedores=mysqli_query($link,"SELECT COUNT(*) AS TOTAL FROM proveedores ");
				$ProveedoresT=mysqli_fetch_object($sql_proveedores);
				return  array('ProductoT' =>  $ProductoT->cantidad,'VentasT'=>$VentaT->VENTAS,'ComprasT'=>$ComprasT->COMPRAS,'ProveedoresT'=>$ProveedoresT->TOTAL);
      }

			public function UltimasVentas()
			{
				$sqlUV="SELECT A.*,A.NOMCLIENTE AS NOMBRE
				FROM comprobante_venta AS A
				ORDER BY A.FECHACOMPROBANTE  DESC LIMIT 10";
				return $this->ArmarConsulta($sqlUV);
			}

			public function ProductoMasVendidos($dia)
			{
			 	$sql_ventasD="SELECT P.*, SUM(D.CANTIDAD_PRODUCTO) AS TOTAL, B.FECHA_FACTURA
		                                FROM PRODUCTO AS P, DETALLE_BOLETA AS D, BOLETA AS B
		                                WHERE P.COD_PRODUCTO=D.COD_PRODUCTO AND D.NRO_FACTURA=B.NRO_FACTURA AND B.FECHA_FACTURA='$dia'
		                                GROUP BY P.NOMBRE_PRODUCTO ORDER BY TOTAL DESC LIMIT 15";

							//return $this->ArmarConsulta($sql_ventasD);
			}

			public function PreviewComprobante($CodComprobante)
			{
					$link=$this->Conectarse();
					$sql="SELECT A.*, B.NOMBRE_C AS CLIENTE FROM BOLETA AS A, CLIENTE_1 AS B
						WHERE A.RUC_CLIENTE=B.RUC_DNI AND NRO_FACTURA='$CodComprobante'";
					$res=mysqli_query($link,$sql);
					return mysqli_fetch_object($res);
			}

			public function PreviewComprobanteDe($CodComprobante)
			{

						$sql="SELECT SUM(DB.CANTIDAD_PRODUCTO) AS CANTIDAD,
									SUM(DB.IMPORTE) AS IMPO, DB.COD_PRODUCTO,NOMBRE_PRODUCTO,PRECIO_VENTA
									FROM DETALLE_BOLETA DB, PRODUCTO PR
									WHERE DB.NRO_FACTURA='$CodComprobante'
									AND DB.COD_PRODUCTO=PR.COD_PRODUCTO
									GROUP BY DB.COD_PRODUCTO";
						return $this->ArmarConsulta($sql);
			}





  }
?>
