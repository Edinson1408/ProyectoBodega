<?php
switch ($_POST['peticion']) {
  case 'lista':
    
  require '../vista/UsuarioLista.php';
    break;

  default:

    break;
}
?>
