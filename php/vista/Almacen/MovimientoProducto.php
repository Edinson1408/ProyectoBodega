<table class='table'>
    <tr>
        <td>Fecha</td>
        <td>Comprobante</td>
        <td>Ingreso</td>
        <td>Egreso</td>
        <td>Saldo</td>
    </tr>
   
     <?php 
     $saldos=0;
        while($r=mysqli_fetch_array($res))
        {
            
            
            if ($r['proceso']==2)
            {
                echo "<tr>";
                echo "<td>".$r['fechacomprobante']."</td>";
                //echo "<td>".$r['idcomprobante']."</td>";
                echo " <td><i class='material-icons'>how_to_vote</i></td>";
                echo "<td>".$r['cantidads']."</td>";
                echo "<td></td>";
                echo "<td>".$saldos=abs($saldos)+abs($r['cantidads'])."</td>";
                echo "</tr>";
            }else{
                echo "<tr>";
                echo "<td>".$r['fechacomprobante']."</td>";
                //echo "<td>".$r['idcomprobante']."</td>";
                echo " <td><i class='material-icons'>how_to_vote</i></td>";
                echo "<td></td>";
                echo "<td>".$r['cantidads']."</td>";
                echo "<td>".$saldos=abs($saldos)-abs($r['cantidads'])."</td>";
                echo "</tr>";
            }
            
        }
     ?>       
    
</table>