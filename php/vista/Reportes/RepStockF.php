<div class="container">
	<div class='row'>
		<div class='col s12'>
			<a href="#" class="btn btn-default btn-sm">HTML</a>
			<a href="pdf/stock_pdf.php" target="T_BLANK" class="btn btn-danger btn-sm">PDF</a>
			<a href="excel/stock_excel.php" class="btn btn-success btn-sm">Excel</a>
		</div>
	</div>

	<div class="panel panel-default" >
		<div class="row">
			<div class="col s12">
				<div class="titulo" style="margin-left: 10px;">
    				<h4>Reprote Stock</h4>
				</div>
			</div>
		</div>
		<form id='FormStock' method="POST">
			<div class="form-group">
				<div class='row'>
					<div class='col s6'>
						<select name="producto" id="">
							<option value="0">Todos los Productos</option>
							<option value="1">Por Producto</option>
						</select>
					</div>
					<div class='col s6'>
						Nombre Producto<input type="text" >
					</div>
				</div>
				<div class='row'>
					<div class='col s6'>
						<select name="" id="">
							<option value="0">Seleccione Categoria</option>
						</select>
					</div>
				</div>
			</div>			
		</form>
	</div>
</div>

