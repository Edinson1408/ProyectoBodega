<table class='table'>
    <tr>
        <td>Fecha</td>
        <td>Ingreso</td>
        <td>Egreso</td>
        <td>Saldo</td>
    </tr>
   
     <?php 
     $saldo=0;
        while($r=mysqli_fetch_array($res))
        {
            echo "<tr>";
            echo "<td>".$r['fechacomprobante']."</td>";
            if ($r['proceso']==2)
            {
                
                echo "<td>".$r['cantidads']."</td>";
                echo "<td></td>";
                echo "<td>".$r['cantidads']."</td>";
            }else{
                echo "<td></td>";
                echo "<td>".$r['cantidads']."</td>";
                echo "<td>".$saldo=$saldo-$r['cantidads']."</td>";
            }
            echo "</tr>";
        }
     ?>       
    
</table>