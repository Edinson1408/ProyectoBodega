<?php 

class Compras extends Conexion
{
	
    public $Conexion;
  function __construct()
  {
    $this->Conexion=$this->Conectarse();

  }

  public function ListaCorrelativos()
  {
        $Sql="SELECT * FROM correlativos ";
        
  }

}
?>
