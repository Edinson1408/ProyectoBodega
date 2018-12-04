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
        $tituloModal='Amortizar Cuenta ';
        require '../vista/Cuentas/FromAmortizar.php';
        break;
    default:
        # code...
        break;
}


?>