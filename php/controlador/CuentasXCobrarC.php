<?php
require '../Basedato/conexion.php';
require '../modelo/CuentasXCobrarM.php';
$ObjCuentas=new Cuentas();
switch ($_POST['peticion']) {
    case 'lista':
        $ListaCuentas=$ObjCuentas->Listar();
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
        $ObjCuentas->ListaAmortizaciones($IdComprobante);
        break;
    default:
        # code...
        break;
}


?>