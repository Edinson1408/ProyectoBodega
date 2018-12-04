<?php 

class Cuentas extends Conexion
{
    public $Conexion;
    function __construct()
    {
        $this->Conexion=$this->Conectarse();

    }

    public function Listar()
    {
        $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA FROM 
        comprobante_venta CV
        LEFT JOIN usuario US ON CV.IDUSUARIO=US.IDUSUARIO
        LEFT JOIN persona PER ON PER.IDPERSONA=US.IDPERSONA
        LEFT JOIN turno TU ON US.IDTURNO=TU.IDTURNO
        LEFT JOIN documentos DOC ON CV.TIPODOC=DOC.IDTIPODOC";
        $res=mysqli_query($this->Conexion,$Sql);
        while ($r=mysqli_fetch_array($res)) {
            $A[]=$r;
        }
        return $A;
    }
}



?>