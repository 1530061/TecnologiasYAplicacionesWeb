<div class="card card-info mx-auto" style="width:50%;">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Registrar Categoria</h3>
		</div>
	</div>
	<form method="post">
		<div class="card-body">
			<div class="form-group">
				<?php
					$registro = new MvcController();
					$registro -> registroBaseCategoriaController();
					$registro -> registroCategoriaController();
				?>
			</div>
		</div>
	</form>
	
</div>
<?php


if(isset($_GET["action"])){
	if($_GET["action"] == "ok_carrera"){
		echo "Registro Exitoso";
	}
}

?>

