
<div class="container">
		<div class="nota">
			<i class="fa fa-pencil-square-o" id="com">Seleccionar Mes</i>
		</div>
<form action="lista_ventas.php" method="POST">
		<div class="form-group">
		  <div class="col-xs-4">
			<select class="form-control" name="mes">
			    <option>Mes</option>
			    <?php
			    $meses = array(1 =>'Enero', 2 =>'Febrero',3 =>'Marzo' ,4 =>'Abril',5 =>'Mayo',6 =>'Junio',7 =>'Julio',8 =>'Agosto',9 =>'Septiembre',10 =>'octubre',11 =>'Noviembre',12 =>'Diciembre' );
			    for ($i=1; $i <=12  ; $i++) { 
			      echo "<option value='".$i."'>".$meses[$i]."</option>";

			     } 

			    ?>
			</select>
		  </div>
		  <div class="col-xs-4">
		       <select class="form-control" name="año">
		           <option>Año</option>
		           <?php
		           $año=2030; 
		           for ($i=2016; $i <$año ; $i++) { 
		                	echo "<option value='".$i."'>".$i."</option>";
		           }
		           ?>
		       </select>
		   </div>
		   <div class="col-xs-2">
			<input type="submit" name="enviar" class="btn btn-default">
		   </div>
</form>
</div>