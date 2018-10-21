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
}

?>