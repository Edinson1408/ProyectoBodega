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
				$link=$this->Conectarse();
				$sqlUV="SELECT A.*,A.NOMCLIENTE AS NOMBRE
				FROM comprobante_venta AS A
				ORDER BY A.FECHACOMPROBANTE  DESC LIMIT 10";
				 $A=array();
				 $res=mysqli_query($link,$sqlUV);
				 while($r=mysqli_fetch_array($res))
					 {
					   $A[]=$r;
					 }
				 return $A;
			}

			public function ProductoMasVendidos($dia)
			{
				$link=$this->Conectarse();
			 	$sql_ventasD="SELECT P.*, SUM(D.CANTIDAD) AS TOTAL, B.FECHACOMPROBANTE
		                                FROM PRODUCTO AS P, comprobante_venta_detalle AS D, comprobante_venta AS B
		                                WHERE P.CODPRODUCTO=D.CODPRODUCTO AND D.IDCOMPROBANTE=B.IDCOMPROBANTE AND B.FECHACOMPROBANTE='$dia'
		                                GROUP BY P.NOMPRODUCTO ORDER BY TOTAL DESC LIMIT 15";



							$A=array();
							$res=mysqli_query($link,$sql_ventasD);
							while($r=mysqli_fetch_array($res))
								{
								$A[]=$r;
								}
							return $A;
			}

			public function PreviewComprobante($CodComprobante)
			{
					$link=$this->Conectarse();
					 $sql="SELECT A.*, P.NUMDOC , A.NOMCLIENTE 
					FROM comprobante_venta AS A , persona as P
						WHERE  A.IDCLIENTE=P.IDPERSONA AND
						A.IDCOMPROBANTE='$CodComprobante'";
					
					$res=mysqli_query($link,$sql);
					return mysqli_fetch_object($res);
			}

			public function PreviewComprobanteDe($CodComprobante)
			{
				$link=$this->Conectarse();

						$sql="SELECT SUM(DB.CANTIDAD) AS CANTIDAD,
									SUM(DB.IMPORTE) AS IMPO, DB.CODPRODUCTO,PR.NOMPRODUCTO,PR.PRECIOVENTA
									FROM comprobante_venta_detalle DB, PRODUCTO PR
									WHERE DB.IDCOMPROBANTE='$CodComprobante'
									AND DB.CODPRODUCTO=PR.CODPRODUCTO
									GROUP BY DB.CODPRODUCTO";
						$A=array();
						$res=mysqli_query($link,$sql);
						while($r=mysqli_fetch_array($res))
							{
							  $A[]=$r;
							}
						return $A;
			}





  }
?>
