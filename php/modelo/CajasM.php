<?php 


/**
 * Clase para las cajas 
 */
class Cajas extends Conexion
{
	
public $Link;

  function __construct()
  {
    $this->Link=$this->Conectarse();

  }

  function ObtenDatosUser($user)
  {
  	$sql=mysqli_query($this->Link,"SELECT * FROM usuario WHERE user='$user'");
	$array_user=mysqli_fetch_object($sql);
	$_SESSION['Turno']= $array_user->ID_TURNO;
	$_SESSION['Categoria']=$array_user->categoria;
	
  }
}


?>

