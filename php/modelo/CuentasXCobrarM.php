<?php 

class Cuentas extends Conexion
{
    public $Conexion;
    function __construct()
    {
        $this->Conexion=$this->Conectarse();

    }

    public function ListarXCobrar()
    {
        $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA ,
        (SELECT IFNULL(SUM(AMO.MONAMORTIZACION),0) FROM amortizaciones AMO where CV.IDCOMPROBANTE=AMO.IDCOMPROBANTE) as MONAMORTIZACION,
        (CV.TOTAL - (SELECT  IFNULL(SUM(AMO.MONAMORTIZACION),0) FROM amortizaciones AMO where CV.IDCOMPROBANTE=AMO.IDCOMPROBANTE)) as SALDOX
        FROM 
        comprobante_venta CV
        LEFT JOIN usuario US ON CV.IDUSUARIO=US.IDUSUARIO
        LEFT JOIN persona PER ON PER.IDPERSONA=US.IDPERSONA
        LEFT JOIN turno TU ON US.IDTURNO=TU.IDTURNO
        LEFT JOIN documentos DOC ON CV.TIPODOC=DOC.IDTIPODOC
        WHERE CV.IDESTADO='2' HAVING SALDOX>0";
        $A=array();
        $res=mysqli_query($this->Conexion,$Sql);
        while ($r=mysqli_fetch_array($res)) {
            $A[]=$r;
        }
        return $A;
    }

    public function ListaCobradas()
    {
        $Sql="SELECT CV.*,concat(PER.NOMBRES,' ',PER.APELLIDOS) as ENCARGADO ,TU.NOMTURNO,DOC.ABREBIATURA ,
        (SELECT SUM(AMO.MONAMORTIZACION) FROM amortizaciones AMO where CV.IDCOMPROBANTE=AMO.IDCOMPROBANTE) as MONAMORTIZACION,
        (CV.TOTAL - (SELECT SUM(AMO.MONAMORTIZACION) FROM amortizaciones AMO where CV.IDCOMPROBANTE=AMO.IDCOMPROBANTE)) as SALDO
        FROM 
        comprobante_venta CV
        LEFT JOIN usuario US ON CV.IDUSUARIO=US.IDUSUARIO
        LEFT JOIN persona PER ON PER.IDPERSONA=US.IDPERSONA
        LEFT JOIN turno TU ON US.IDTURNO=TU.IDTURNO
        LEFT JOIN documentos DOC ON CV.TIPODOC=DOC.IDTIPODOC
        WHERE CV.IDESTADO='2' HAVING SALDO<0";
        $res=mysqli_query($this->Conexion,$Sql);
        $A=array();
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
        $Sql="INSERT INTO amortizaciones(
            IDCOMPROBANTE,
            FEAMORTIZACION,
            MONAMORTIZACION,
            IDUSUARIO,
            OBSERVACION
        )
        VALUE
        (
            '".$_ARR['IdComprobante']."',
            '".$_ARR['FechaR']."',
            '".$_ARR['Monto']."',
            '".$_SESSION['IdUsuario']."',
            '".$_ARR['observacion']."'
        )
        ";
        mysqli_query($this->Conexion,$Sql);
        echo $Sql;
    }

    public function ListaAmortizaciones($IdComprobante)
    {
        $Sql="SELECT * FROM amortizaciones WHERE IDCOMPROBANTE='$IdComprobante'";
        $res=mysqli_query($this->Conexion,$Sql);
        $A=array();
        while ($r=mysqli_fetch_array($res)) {$A[]=$r;}
        return $A;
        
        
        
    }
}



?>