<?php 

/**
 * 
 */
class Compras extends Conexion
{
	
public $Link;
  function __construct()
  {
    $this->Link=$this->Conectarse();

  }
  
  public function MantenientoLista()
  {
  	$Query=mysqli_query($this->Link,"SELECT * FROM comprobante_compra");
		while ($tbl=mysqli_fetch_array($Query)) 
		{
			$Arr_tbl[]=$tbl;	
		}

		return $Arr_tbl;
  }

  public function MaxIdCompra()
  {
      $sql="SELECT max(NUMCOMPROBANTE+1) AS ID FROM COMPROBANTE_COMPRA ";
      $MaxId=mysqli_fetch_object(mysqli_query($this->Link,$sql));

       return $MaxId->ID;
  }

  public function AutoCompleteProveedores($Numdoc)
  {
      /*Consulta al clientes para autocompletar*/
      //$Sql="SELECT * FROM CLIENTE where RUC_DNI like '%".$Numdoc."%'  ORDER BY RUC_DNI DESC";
      $Sql="SELECT PRO.IDPROVEEDOR,PRO.IDPERSONA,PE.NOMBRES as NOMBRE_C,PE.NUMDOC as RUC_DNI
      FROM 
      proveedores  PRO 
      INNER JOIN PERSONA PE 
      ON PRO.IDPERSONA=PE.IDPERSONA   and 
        PE.NUMDOC  like  '%".$Numdoc."%' ";
      $query=mysqli_query($this->Link,$Sql);
      return $query;
      
  }

  public function InsertaComprobanteC($_ARR)
  {
    session_start();
     $Sql="INSERT INTO comprobante_compra
          (IDEMPRESA,
          IDESTADO,
          TIPODOC,
          NUMCOMPROBANTE,
          SERIECOMPROBANTE,
          IDPROVEEDOR,
          NOMPROVEEDOR,
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
    for ($i=1; $i <=50 ; $i++) { 
      if(isset($_ARR['CodProducto'.$i])){
         $Sql="INSERT INTO comprobante_compra_detalle
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
              CANTIDAD=CANTIDAD+$Cantidad
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
            '2' )";

      mysqli_query($this->Link,$Sql);
    }

    function HistorialComprasR($mes,$año)
    {
        $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA 
          FROM 
          comprobante_compra CV
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


    function HistorialComprasRango($inicio,$fin)
    {
         $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA 
          FROM 
          comprobante_compra CV
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
    

}

?>