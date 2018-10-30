<?php

/**
 *
 */
class VentasM extends Conexion
{
  public $Link;
  function __construct()
  {
    $this->Link=$this->Conectarse();

  }
  
  public function MaxIdVenta()
  {
      $sql="SELECT max(NUMCOMPROBANTE+1) AS ID FROM COMPROBANTE_VENTA ";
      $MaxId=mysqli_fetch_object(mysqli_query($this->Link,$sql));

       return $MaxId->ID;
  }

  public function SqlVista()
  {
    $sql="SELECT A.*, B.NOMBRE_C AS NOMBRE, C.DES_TUR AS TURNO
          FROM BOLETA AS A, CLIENTE_1 AS B, TURNO AS C WHERE A.RUC_CLIENTE=B.RUC_DNI
          AND A.ID_TURNO=C.ID_TURNO ";
    return $this->ArmarConsulta($sql);
  }

  public function RangoF($inicio,$final)
  {
    $sql="SELECT A.*, B.NOMBRE_C AS NOMBRE, C.DES_TUR AS
                            TURNO FROM BOLETA AS A, CLIENTE_1 AS B, TURNO AS C WHERE
                            A.RUC_CLIENTE=B.RUC_DNI AND A.ID_TURNO=C.ID_TURNO AND
                            (FECHA_FACTURA BETWEEN '$inicio' AND '$final')";
        return $this->ArmarConsulta($sql);
  }

  public function AutoCompleteClientes($Numdoc)
  {
      /*Consulta al clientes para autocompletar*/
      //$Sql="SELECT * FROM CLIENTE where RUC_DNI like '%".$Numdoc."%'  ORDER BY RUC_DNI DESC";
      $Sql="SELECT CL.IDCLIENTE,CL.IDPERSONA,CONCAT(PE.NOMBRES,' ',PE.APELLIDOS,' ') as NOMBRE_C,PE.NUMDOC as RUC_DNI
      FROM 
      CLIENTE  CL 
      INNER JOIN PERSONA PE 
      ON CL.IDPERSONA=PE.IDPERSONA";
      $query=mysqli_query($this->Link,$Sql);
      return $query;
      
  }

}


 ?>
