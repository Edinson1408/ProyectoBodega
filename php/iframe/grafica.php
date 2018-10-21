<?php
include ('conexion.php');
        $table_nom='grafica';
        function mysql_table_exist($tabla)
        {
            include('conexion.php');
            $sql ="SELECT COUNT(*) FROM '.$tabla.'";
            $result = mysql_query($sql);
            $num_rows = mysql_num_rows($result);
            if($num_rows>0)
            {
                return $i="1";
            }
            else
            {
                return $i="0";
            }
        }

        echo $i=mysql_table_exist($table_nom);
        echo $table_nom;
        if ($i=='1') {
         mysql_query("DROP TABLE $table_nom",$conexion);
        }
        else{
            mysql_query("CREATE TABLE  $table_nom(
                    CLASIFICACION char(6),
                    CANTIDAD int(11)
                )",$conexion);
            $rt=1;
        $consulta=mysql_query("SELECT SUM(CANTIDAD) AS SUMA FROM almacen WHERE COD_CLASIFICACION=$rt",$conexion);
        while ($fi=mysql_fetch_array($consulta)) {
            $canti=$fi['SUMA'];
            $rt+=1;
        mysql_query("INSERT INTO $table_nom VALUES ('$rt','$canti')",$conexion);
        }
    }
?>