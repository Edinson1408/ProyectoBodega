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
        LEFT JOIN documentos DOC ON CV.TIPODOC=DOC.IDTIPODOC
        WHERE CV.IDESTADO='2'";
        $res=mysqli_query($this->Conexion,$Sql);
        while ($r=mysqli_fetch_array($res)) {
            $A[]=$r;
        }
        return $A;
    }

    public function InsertaAmortizacion($_ARR)
    {
        session_start();
        
        $_ARR['FechaR'];
        $_ARR['Monto'];
        $_SESSION['IdUsuario'];
        $_ARR['observacion'];
        $Sql="INSERT INTO (
            IDCOMPROBANTE,
            FEAMORTIZACION,
            MONAMORTIZACION,
            IDUSUARIO,
            OBSERVACION
        )
        VALUE
        (
            '".$_ARR['IdComprobante']."',
            '".$_ARR['Monto']."',
            '".$_SESSION['IdUsuario']."',
            '".$_ARR['observacion']."',
        )
        ";
        
        
    }

    public function ListaAmortizaciones($IdComprobante)
    {
        $Sql="SELECT * FROM amortizaciones WHERE IDCOMPROBANTE='$IdComprobante'";
        $res=mysqli_query($this->Conexion,$Sql);
        $NumRow=mysqli_num_rows($res);
        if ($NumRow=='0') {
            return 'Fallo';
        }
        else
        {
            while ($r=mysqli_fetch_array($res)) {$A[]=$r;}
            return $A;
        }
        
        
    }
}



?>