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
    $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA 
          FROM 
          comprobante_venta CV
          LEFT JOIN usuario US ON CV.IDUSUARIO=US.IDUSUARIO
          LEFT JOIN persona PER ON PER.IDPERSONA=US.IDPERSONA
          LEFT JOIN turno TU ON US.IDTURNO=TU.IDTURNO
          LEFT JOIN documentos DOC ON CV.TIPODOC=DOC.IDTIPODOC WHERE ESTADO != 'Anulado' ";
          $res=mysqli_query($this->Link,$Sql);
          $A=array();
          while ($r=mysqli_fetch_array($res)) {
                $A[]=$r;
          }
          return $A;
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
              $this->MovimientoAlmacen($_ARR['CodProducto'.$i],'',$UltimoId,$_ARR['FecComprobante'],$_ARR['Cantidad'.$i]);
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

    public function MovimientoAlmacen($CodProducto,$CodClasificacion,$IdComprobante,$Fecha,$Cantidad)
    {
         $Sql="INSERT INTO movimiento_almacen (
            IDMIALMACEN,
            CODPRODUCTO,
            CODCLASIFICACION,
            IDCOMPROBANTE,
            FECHACOMPROBANTE,
            CANTIDAD,
            PROCESO
            ) VALUES
            ('1',
            '$CodProducto',
            '$CodClasificacion',
            '$IdComprobante',
            '$Fecha',
            '$Cantidad',
            '1' )";

      mysqli_query($this->Link,$Sql);
    }

    function HistorialVentasR($mes,$año)
    {
        $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA 
          FROM 
          comprobante_venta CV
          LEFT JOIN usuario US ON CV.IDUSUARIO=US.IDUSUARIO
          LEFT JOIN persona PER ON PER.IDPERSONA=US.IDPERSONA
          LEFT JOIN turno TU ON US.IDTURNO=TU.IDTURNO
          LEFT JOIN documentos DOC ON CV.TIPODOC=DOC.IDTIPODOC
          WHERE MONTH(FECHACOMPROBANTE)='$mes' AND YEAR(FECHACOMPROBANTE)='$año'";
          $res=mysqli_query($this->Link,$Sql);
          $A=array();
          while($r=mysqli_fetch_array($res))
          {
            $A[]=$r;
          }
          return $A;
    }
    function HistorialVentasRango($inicio,$fin)
    {
         $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA 
          FROM 
          comprobante_venta CV
          LEFT JOIN usuario US ON CV.IDUSUARIO=US.IDUSUARIO
          LEFT JOIN persona PER ON PER.IDPERSONA=US.IDPERSONA
          LEFT JOIN turno TU ON US.IDTURNO=TU.IDTURNO
          LEFT JOIN documentos DOC ON CV.TIPODOC=DOC.IDTIPODOC
          WHERE  FECHACOMPROBANTE BETWEEN '$inicio' AND '$fin' ";
          $res=mysqli_query($this->Link,$Sql);
          $A=array();
          while($r=mysqli_fetch_array($res))
          {
            $A[]=$r;
          }
          return $A;
    }

    public function AnularVenta($IdComprobante)
    {

      $sqlDel="DELETE FROM movimiento_almacen WHERE IDCOMPROBANTE='$IdComprobante'";
      mysqli_query($this->Link,$sqlDel);

       $Sql="UPDATE comprobante_venta SET 
        ESTADO='Anulado' WHERE IDCOMPROBANTE='$IdComprobante';";
        mysqli_query($this->Link,$Sql);

        $SqlDetalle="SELECT * FROM comprobante_venta_detalle WHERE IDCOMPROBANTE='$IdComprobante';";
        $res=mysqli_query($this->Link,$SqlDetalle);
        while ($r=mysqli_fetch_array($res)) {
            $this->DevolucionAlmacen($r['CODPRODUCTO'],$r['CANTIDAD']);
        }


    }
    private function DevolucionAlmacen($CodProducto,$Cantidad)
    {
       echo  $Sql="UPDATE almacen 
          SET CANTIDAD =(CANTIDAD +$Cantidad)
          where CODPRODUCTO ='$CodProducto' ";
          mysqli_query($this->Link,$Sql);
    }
    public function AnularVentaBusqueda($IdBusqueda,$Busqueda,$busquedaF)
    {
      switch ($IdBusqueda) {
        case '1':
            $Where="	NUMCOMPROBANTE like '%".$Busqueda."%' ";
          break;
        case '2':
            $Where="	SERIECOMPROBANTE like '%".$Busqueda."%' ";
          break;
        case '3':
              $Where="	SERIECOMPROBANTE like '%".$Busqueda."%' ";
          break;
        case '4':
            $Where="	FECHACOMPROBANTE='$busquedaF' ";
          break;
      }
      $Sql="SELECT * from comprobante_venta where $Where";  
      $A=array();
      $res=mysqli_query($this->Link,$Sql);
      while($r=mysqli_fetch_array($res))
          {
            $A[]=$r;
          }
      return $A;
    }
}


 ?>
