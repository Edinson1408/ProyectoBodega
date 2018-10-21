
<?php
include('conexion.php');
if (isset($_POST['boton'])) {

 $VAR_BOLETA= $_POST['boleta'];
 $VAR_ESTADO=$_POST['estado'];
 $VAR_FECHA_PA=$_POST['fecha_pago'];
 $VAR_AMORT=$_POST['amortizado'];
 $VAR_FE_BOL=$_POST['fecha_boleta'];
  
  
  if ($VAR_ESTADO=='C') {
    $SQL_BOLETA_TO=mysql_query("SELECT TOTAL FROM BOLETA WHERE NRO_FACTURA='$VAR_BOLETA'",$conexion);
    $ARR_BOL_T=mysql_fetch_array($SQL_BOLETA_TO);
    $MONTO_TOTAL=$ARR_BOL_T['TOTAL'];
    mysql_query("INSERT INTO DETALLE_CREDITO VALUES ('1','$VAR_BOLETA','$VAR_FE_BOL','$VAR_FECHA_PA','$MONTO_TOTAL','0')",$conexion);
    mysql_query("UPDATE BOLETA
                  SET ESTADO= 'C'
                  WHERE NRO_FACTURA = $VAR_BOLETA ",$conexion);
    echo "se cancelo todo<br>";
    /*echo "desea Imprimir el comprobante<br>";
    echo "<a>imprimir</a>";*/
  }

   if ($VAR_ESTADO=='P') 
        {
          /*MTRAIGO EL MONTO TOTAL PARA RESTARLO CON LO LO VA A PAGAR*/
    $SQL_BOLETA_TO=mysql_query("SELECT TOTAL,SALDO FROM BOLETA WHERE NRO_FACTURA='$VAR_BOLETA'",$conexion);
    $ARR_BOL_T=mysql_fetch_array($SQL_BOLETA_TO);
    $MONTO_TOTAL=$ARR_BOL_T['TOTAL'];
    $SALDO_AN=$ARR_BOL_T['SALDO'];
    /*LLAMEMOS A LOSANTIGUOS SALDOS PARA PODER MOSTRARLOS Y VER CUANDTO ME FALTA PAGAR*/
    /*RESTO EL TOTOAL DE LA DEUDA CON LO PAGADO EN EL MOMENTO */
    $SALDO=$SALDO_AN-$VAR_AMORT;
    mysql_query("INSERT INTO DETALLE_CREDITO VALUES ('1','$VAR_BOLETA','$VAR_FE_BOL','$VAR_FECHA_PA','$VAR_AMORT','$SALDO')",$conexion);
    mysql_query("UPDATE BOLETA
                  SET SALDO= '$SALDO'
                  WHERE NRO_FACTURA = $VAR_BOLETA ",$conexion);

    // le diremos que si su saldo es 0 entonces cambie a estado n
    $SQL_AMORTIZADOS=mysql_query("SELECT SUM(AMORTIZADO) AS ACOMULADO FROM DETALLE_CREDITO WHERE NRO_BOLETA='$VAR_BOLETA'",$conexion);
    $ARR_ACO=mysql_fetch_array($SQL_AMORTIZADOS);
    $VAR_ACOMULADO=$ARR_ACO['ACOMULADO'];
    $COMPARAR=$MONTO_TOTAL- $VAR_ACOMULADO;
    echo "<BR>SU DEUDA ES DE ".$COMPARAR."<BR>";
    if ($COMPARAR==0) {
        mysql_query("UPDATE BOLETA
                  SET ESTADO= 'C'
                  WHERE NRO_FACTURA = $VAR_BOLETA ",$conexion);
     } 
    
    /*echo "desea Imprimir el comprobante<br>";
    echo "<a>imprimir</a>";*/
          }
  
  
}
else 
{
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
  <script type="text/javascript" src='jquery-3.2.1.min.js'></script>
  <script type="text/javascript" src='js/bootstrap.js'></script>
  <style type="text/css">
    #panel3{
    border-top: 3px solid #5D6D7E  ;
    background: #ffffff;
    padding: 10px;
    }
  </style>
</head>
<body>
<div class="panel panel-default" id="panel3">
  <h4>Ingresar Pago</h4>

<form action="detalles.php" method="POST">
  <div class="form-group">
  <label class="control-label col-xs-2">Boleta
  </label>
  <div class="col-xs-4">
  <input type="number" name="boleta" class="form-control input-sm" value="<?php echo $_GET['boleta']; ?>">
  </div>
  </div>

  <div class="form-group">
  <label class="control-label col-xs-2">Fecha de Boleta
  </label>
  <div class="col-xs-4">
  <input type="date" name="fecha_boleta" class="form-control input-sm" value="<?php echo $_GET['fecha_bol']; ?>" >
  </div>
  </div>

  <div class="form-group">
  <div class="col-xs-4">
    <input type="radio" name="estado" value="C"> Cancelar Todo<br>
    <input type="radio" name="estado" value="P"> Cuota<br>
  </div>
  </div>

  <div class="form-group">
  <label class="control-label col-xs-2">Fecha de pago
  </label>
  <div class="col-xs-4">
    <input type="date" class="form-control input-sm"  name="fecha_pago">
  </div>
  </div>

  <div class="form-group">
  <label class="control-label col-xs-2">Monto
  </label>
  <div class="col-xs-4">
    <input type="text" class="form-control input-sm"   name="amortizado">
  </div>
  </div>
<input type="submit" name="boton" value="enviar">
</form>
</div>
</body>



</html>
 <?php }
 ?>
