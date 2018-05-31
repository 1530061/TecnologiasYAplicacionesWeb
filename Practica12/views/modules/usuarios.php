<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<div class="card card-info" style="width:100%">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Usuarios</h3>
		</div>
		<div class="d-inline-block pull-right"">
		  <a href="index.php?action=registro_usuario"><button class="btn btn-block btn-success">Agregar Nuevo Usuario</button></a>
		</div>
	</div>
	<div class="card-body">
		
		<table id="table" width="100%" border="0">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Usuario</th>
					<th>E-mail</th>
					<th>Fecha Agregado</th>
					<th>¿Editar?</th>
					<th>¿Eliminar?</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$vistaAlumno = new MvcController();
				$vistaAlumno -> vistaProductoController();
				$vistaAlumno -> borrarProductoController();

				?>

			</tbody>
		</table>
	</div>
			<?php

if(isset($_GET["action"])){
	if($_GET["action"] == "cambio"){
		echo "Cambio Exitoso";
	}
}


?>
