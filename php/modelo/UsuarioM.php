<?php
class Usuarios extends Conexion
{
	
public $Conexion;

  function __construct()
  {
    $this->Conexion=$this->Conectarse();

  }

  public function ListaUsuario()
  {
    $Sql="SELECT u.IDPERSONA,U.IDUSUARIO,U.IDCATEGORIA,U.NOMUSER,T.NOMTURNO ,P.NUMDOC,CONCAT(P.NOMBRES,' ',P.APELLIDOS) AS NOMBRES
        FROM usuario U LEFT JOIN turno T ON U.IDTURNO=T.IDTURNO
        INNER JOIN persona P ON U.IDPERSONA=P.IDPERSONA";
       
        $res= mysqli_query($this->Conexion,$Sql);
        while ($ARR=mysqli_fetch_array($res))
        {$Respuesta[]=$ARR;}
        return $Respuesta;
  }
  public function MostrarUsuario($IdPersona)
  {
    $Sql="SELECT u.IDPERSONA,U.IDUSUARIO,U.IDCATEGORIA,U.NOMUSER,T.IDTURNO,T.NOMTURNO ,P.NUMDOC,P.NOMBRES,P.APELLIDOS,
    P.DIRECCION,P.TELEFONO
    FROM usuario U LEFT JOIN turno T ON U.IDTURNO=T.IDTURNO
    INNER JOIN persona P ON U.IDPERSONA=P.IDPERSONA where U.IDPERSONA='$IdPersona'";
    $res= mysqli_query($this->Conexion,$Sql);
    return mysqli_fetch_object($res);

  }

	public function InsertaPersona ($link,$_Arr){
			
	
			$Nombre=($_Arr['Nomproveedor']=='')?$_Arr['NomCliente']:$_Arr['Nomproveedor'];
	
			 $Sql="INSERT INTO persona (NOMBRES,APELLIDOS,IDTIPODOC,NUMDOC,TELEFONO,CORREO,DIRECCION)  VALUES 
			(
				'".$Nombre."',
				'".$_Arr['ApeCliente']."',
				'".$_Arr['TipoDoc']."',
				'".$_Arr['RUCDNI']."',
				'".$_Arr['telefono']."',
				'".$_Arr['correo']."',
				'".$_Arr['direccion']."'
				)";
			mysqli_query($link,$Sql);
			return mysqli_insert_id($link);
    }
    
}


?>