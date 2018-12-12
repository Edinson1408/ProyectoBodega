<?php 

class Correlativos extends Conexion
{
	
    public $Conexion;
  function __construct()
  {
    $this->Conexion=$this->Conectarse();

  }

  public function ListaCorrelativos()
  {
        $Sql="SELECT * FROM correlativosdoc ";
        $res=mysqli_query($this->Conexion,$Sql);
        $A=array();
        
        while ($r=mysqli_fetch_array($res)) {
          $A[]=$r;
        }

    return $A;
        
  }

}
?>
