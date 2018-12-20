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
        $Sql="SELECT * FROM correlativos ";
        $res=mysqli_query($this->Conexion,$Sql);
        $A=array();
        
        while ($r=mysqli_fetch_array($res)) {
          $A[]=$r;
        }

    return $A;
        
  }

  public function UltimoCorrelativo($TipoDoc)
  {
       $Sql="SELECT SERIE,(NUM+1) as Numero FROM correlativos where IDTIPODOC='$TipoDoc'";
        $res=mysqli_query($this->Conexion,$Sql);
        
        while ($r=mysqli_fetch_array($res)) {
          $serie=$r['SERIE'];
          $Numero=$r['Numero'];

        }
        $A=array('Serie'=>$serie,'Numero'=>$Numero);
    return json_encode($A);
  }
  public function ActualizaUltimoC($TipoDoc,$Numero)
  {
      $Sql="UPDATE correlativos Set NUM='$Numero' where IDTIPODOC='$TipoDoc'";
      mysqli_query($this->Conexion,$Sql);
      
  }
}
?>
