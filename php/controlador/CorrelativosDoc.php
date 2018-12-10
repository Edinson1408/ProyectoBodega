<?php
require '../Basedato/conexion.php';
require '../modelo/CorrelativosM.php';

switch ($_POST['peticion']) {
    case 'Lista':
        
        require '../vista/CorrelativosDoc/CorrelaticosLista.php';
        break;
    
    default:
        # code...
        break;
}
?>