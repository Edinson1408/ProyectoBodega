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
      CLIENTE  CL ,PERSONA PE
       where CL.IDPERSONA=PE.IDPERSONA and 
        PE.NUMDOC  like  '%".$Numdoc."%' ";
      $query=mysqli_query($this->Link,$Sql);
      return $query;
      
  }

    public function InsertaComprobantev($_ARR)
    {
        session_start();
      // CliDoc=88888888&
        //IdPersona , SubTotal , Igv , Total
        //CodigoBarras=c&CodProducto1=PRO001&Cantidad1=1  
        
        $Sql="INSERT INTO comprobante_venta
            (IDEMPRESA,
            IDESTADO,
            TIPODOC,
            NUMCOMPROBANTE,
            SERIECOMPROBANTE,
            IDCLIENTE,
            NOMCLIENTE,
            FECHACOMPROBANTE,
            SUBTOTAL,
            IGV,
            TOTAL,
            IDUSUARIO
            )
            VALUES (
              '1',
              '".$_ARR['Estado']."',
              '".$_ARR['TipoDoc']."',
              '".$_ARR['NumCompro']."',
              '".$_ARR['Serie']."',
              '".$_ARR['IdPersona']."',
              '".$_ARR['NombreCLiente']."',
              '".$_ARR['FecComprobante']."',
              '".$_ARR['SubTotal']."',
              '".$_ARR['Igv']."',
              '".$_ARR['Total']."',
              '".$_SESSION['IdUsuario']."'
                  )";
          mysqli_query($this->Link,$Sql);
            //obtener el ultimo id 
          return mysqli_insert_id($this->Link);
            //echo $Sql;
    }
    public function InsertaDetalle($UltimoId,$_ARR)
    {
      //por mientras valera 1
      //$UltimoId=1;
        //CodigoBarras=c&CodProducto1=PRO001&Cantidad1=1  
          for ($i=1; $i <=50 ; $i++) { 
            if(isset($_ARR['CodProducto'.$i])){
              $Sql="INSERT INTO comprobante_venta_detalle
              (IDCOMPROBANTE,
              CODPRODUCTO,
              IDEMPRESA,
              IDESTADO,
              CANTIDAD,
              PRECIOVENTA,
              IMPORTE
              ) VALUES (
                '".$UltimoId."',
                '".$_ARR['CodProducto'.$i]."',
                '1',
                '1',
                '".$_ARR['Cantidad'.$i]."',
                '".$_ARR['PrecioVenta'.$i]."',
                '".$_ARR['Importe'.$i]."'
                )";
              //echo $Sql;
              mysqli_query($this->Link,$Sql);
              //disminuye almacen 
              $this->ActualizaAlmacen($_ARR['CodProducto'.$i],$_ARR['Cantidad'.$i]);
            }
          }

      
    }

    public function ActualizaAlmacen($CodProducto,$Cantidad)
    {
        $Sql="UPDATE almacen SET
              CANTIDAD=CANTIDAD-$Cantidad
              WHERE CODPRODUCTO='$CodProducto'";
        mysqli_query($this->Link,$Sql);
        
    }

}


 ?>
