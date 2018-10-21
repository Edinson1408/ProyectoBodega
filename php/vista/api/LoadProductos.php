<?php 
class LazyLoad 
{
  public $link;

  public function __construct(){
   
    $this->link=mysqli_connect("localhost","root","1234","bodega");
    call_user_func(array($this,array_keys($_REQUEST)[0])); 
  }

  
  private function get(){
    

   
    

    if(!isset($_REQUEST['start'])):
      $_REQUEST['start']=0;
    endif;

  
      $sql="SELECT a.*, b.CLASE_PRODUCTO AS NOMBRE FROM producto as a, clasificacion_producto as b WHERE a.CLASE_PRODUCTO=b.COD_CLASIFICACION Order by a.Nombre_producto  ASc limit {$_REQUEST['start']},15";

    $request=mysqli_query($this->link,$sql);

?>
<?php

      while ($ListaProdu=mysqli_fetch_array($request)):
      /*while($row=mysqli_fetch_object($request)):
        $row->Nombre=utf8_encode($row->Nombre);
        /*$row->NameDB=utf8_encode($row->NameDB);
        $row->CodOrg=utf8_encode($row->CodOrg);
        /*$row->Direccion=utf8_encode($row->Direccion);*/
                  
        echo "<tr>
          <td>".$ListaProdu['NOMBRE']."</td>
          <td>".$ListaProdu['NOMBRE_PRODUCTO']."</td>
          
          <td><a title='Editar' onclick=(editar('".$ListaProdu['COD_PRODUCTO']."')) style='cursor:pointer;'> 
          <i class='material-icons'>edit</i></a></td> 
          <td><a title='Eliminar' style='cursor:pointer;' onclick=(eliminar('".$ListaProdu['COD_PRODUCTO']."'))><i class='material-icons'>delete</i></a></td>
          </tr>";
    ?>

        



          
    <?php
    endwhile;
 
  }


}
new LazyLoad;
?>