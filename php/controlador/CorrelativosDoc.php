<?php
require '../Basedato/conexion.php';
require '../modelo/CorrelativosM.php';
$ObjCorrelativo= new Correlativos();

switch ($_POST['peticion']) {
    case 'Lista':
        $ListaCorrelativos=$ObjCorrelativo->ListaCorrelativos();
        require '../vista/CorrelativosDoc/CorrelativosLista.php';
        break;
    
    default:
        # code...
        break;
}
?>