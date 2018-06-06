<?php

session_start();

if(!$_SESSION["validar"]){

	header("location:index.php?action=ingresar");

	exit();

}

?>

<div class="card card-info mx-auto" style="width:50%;">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Editar Usuario</h3>
		</div>
	</div>
	<form method="post">
		<div class="card-body">
			<div class="form-group">
	
			<?php

			$editarCarrera = new MvcController();
			$editarCarrera -> editarUsuarioController();
			$editarCarrera -> actualizarUsuarioController();

			?>

			</div>
		</div>
	</form>
	
</div>


