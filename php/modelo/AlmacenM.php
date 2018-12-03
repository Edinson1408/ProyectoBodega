<?php 
/**
 * Clase para las cajas 
 */
class Almacenes extends Conexion
{
	
public $Conexion;

  function __construct()
  {
    $this->Conexion=$this->Conectarse();

  }

  function DatosAlmace($IdAlmacen)
  {
    //$link=$Conexion->Conectarse();
    //segun el almacen mostraremos los calsificacion en cajas
    $Sql="SELECT CP.*,SUM(Al.CANTIDAD) AS CANTIDAD FROM clasificacion_producto CP, almacen AL
            WHERE  CP.CODCLASIFICACION=al.CODCLASIFICACION
            GROUP by CP.CODCLASIFICACION";
          return mysqli_query($this->Conexion,$Sql);
	
  }
  public function DetalleAlmacenP($CodClasificacion)
  {
    $Sql= "SELECT CP.*,Al.CANTIDAD,AL.CODPRODUCTO, PRO.NOMPRODUCTO FROM clasificacion_producto CP, almacen AL, producto  PRO
          WHERE  CP.CODCLASIFICACION=al.CODCLASIFICACION
          AND    AL.CODPRODUCTO=PRO.CODPRODUCTO
          AND CP.CODCLASIFICACION='$CodClasificacion' ";
          return mysqli_query($this->Conexion,$Sql);
  }
  public function MovimientosP($CodProducto)
  {
    // echo $Sql="SELECT  sum(Cantidad) as cantidads, fechacomprobante,idcomprobante,codproducto,proceso 
    //           from movimiento_almacen 
    //           where codproducto='$CodProducto'  
    //         group by  fechacomprobante, proceso DESC";
    $Sql="SELECT sum(Cantidad) as cantidads, fechacomprobante,idcomprobante,codproducto,proceso from movimiento_almacen 
    where codproducto='$CodProducto' group by fechacomprobante,
    IDCOMPROBANTE,PROCESO ORDER by FECHACOMPROBANTE, PROCESO DESC";
      return mysqli_query($this->Conexion,$Sql);
/*
SELECT sum(Cantidad) as cantidads, fechacomprobante,idcomprobante,codproducto,proceso from movimiento_almacen 
where codproducto='prod001' group by fechacomprobante,
IDCOMPROBANTE,PROCESO ORDER by FECHACOMPROBANTE, PROCESO DESC 
*/

      // $SqlIngreso="SELECT  sum(Cantidad), fechacomprobante,idcomprobante,codproducto,proceso from movimiento_almacen 
      //       where codproducto='$CodProducto'  
      //     group by  fechacomprobante";

      // $SqlSalida="SELECT  sum(Cantidad), fechacomprobante,idcomprobante,codproducto from movimiento_almacen 
      //     where codproducto='$CodProducto'  and proceso='1'
      // group by  fechacomprobante";


  }
}


?>

