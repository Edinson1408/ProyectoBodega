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

	public function InsertaPersona($_Arr){
    $Sql="INSERT INTO persona (NOMBRES,APELLIDOS,IDTIPODOC,NUMDOC,TELEFONO,CORREO,DIRECCION)  VALUES 
			(
				'".$_Arr['NomCliente']."',
				'".$_Arr['ApeCliente']."',
				'3',
				'".$_Arr['RUCDNI']."',
				'".$_Arr['telefono']."',
				'',
				'".$_Arr['direccion']."'
				)";
			mysqli_query($this->Conexion,$Sql);
			return mysqli_insert_id($this->Conexion);
    }
    public function InsertarUsuario($_Arr)
		{
			$ultimoId=$this->InsertaPersona($_Arr);
      $sql="INSERT INTO  usuario
        (IDPERSONA,
          IDTURNO,
          IDCATEGORIA,
          NOMUSER,
          CONUSUARIO)
          VALUES 
          (
            '".$ultimoId."',
            '".$_Arr['IdTurno']."',
            '".$_Arr['IdCategoria']."',
            '".$_Arr['UserName']."',
            md5('".$_Arr['Pass']."')
          )";
			$res=mysqli_query($this->Conexion,$sql);
    }
    
    public function UpdateUsuario($_Arr){
			$PersonaUpdate="UPDATE persona SET
			NOMBRES='".$_Arr['NomCliente']."',
      APELLIDOS='".$_Arr['ApeCliente']."',
      NUMDOC='".$_Arr['RUCDNI']."',
			TELEFONO='".$_Arr['telefono']."',
			DIRECCION='".$_Arr['direccion']."'
      WHERE IDPERSONA='".$_Arr['Idpersona']."';";

      if($_Arr['Pass']=='')
      {
          $UsuarioUpdate="UPDATE usuario SET
          IDTURNO='".$_Arr['IdTurno']."',
          IDCATEGORIA='".$_Arr['IdCategoria']."',
          NOMUSER='".$_Arr['UserName']."'
          WHERE 
          IDPERSONA='".$_Arr['Idpersona']."';";
      }
      else
      {
          $UsuarioUpdate="UPDATE usuario SET
          IDTURNO='".$_Arr['IdTurno']."',
          IDCATEGORIA='".$_Arr['IdCategoria']."',
          NOMUSER='".$_Arr['UserName']."',
          CONUSUARIO='".$_Arr['Pass']."'
          WHERE 
          IDPERSONA='".$_Arr['Idpersona']."';";
      }
			
      echo $PersonaUpdate;
      echo $UsuarioUpdate;
			mysqli_query($this->Conexion,$PersonaUpdate);
			mysqli_query($this->Conexion,$UsuarioUpdate);

		}

}


?>