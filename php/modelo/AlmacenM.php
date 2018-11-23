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
}


?>

