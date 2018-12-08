<?php
require '../Basedato/conexion.php';
require '../modelo/CuentasXCobrarM.php';
$ObjCuentas=new Cuentas();
switch ($_POST['peticion']) {
    case 'lista':
        $titulo="Cuentas por Cobrar";
        $ListaCuentas=$ObjCuentas->ListarXCobrar();
        $titulo2="Cuentas Cobradas";
        $ListaCuentasCobradas=$ObjCuentas->ListaCobradas();
        require '../vista/Cuentas/CuentasXCobrarLista.php';
        break;
    
    case 'ListaCobradas':
        $titulo="Cuentas Cobradas";
        $ListaCuentas=$ObjCuentas->ListaCobradas();
        require '../vista/Cuentas/CuentasXCobrarLista.php';
        break;
    
    case 'FormAmortizar':
        $Saldo=$_POST['Saldo'];
        $IdComprobante=$_POST['IdComprobante'];
        $tituloModal='Amortizar Cuenta ';
        require '../vista/Cuentas/FromAmortizar.php';
        break;

    case 'InsertarAmortizacion':
            $ObjCuentas->InsertaAmortizacion($_POST);
        break;
    
    case 'MostarAmortizaciones':
        $IdComprobante=$_POST['IdComprobante'];
        $ListaAmortizacion=$ObjCuentas->ListaAmortizaciones($IdComprobante);
        require '../vista/Cuentas/ListaAmortizaciones.php';
        break;
    default:
        # code...
        break;
}


?>