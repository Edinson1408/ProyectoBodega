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
  	$Query=mysqli_query($this->Link,"SELECT * FROM factura");
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

}

?>