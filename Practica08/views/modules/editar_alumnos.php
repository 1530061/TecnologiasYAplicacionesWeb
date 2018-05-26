<?php

session_start();

if(!$_SESSION["validar"]){

	header("location:index.php?action=ingresar");

	exit();

}

?>

<h1>EDITAR ALUMNO</h1>

<form method="post">
	
	<?php

	$editarMaestro = new MvcController();
	$editarMaestro -> editarAlumnoController();
	$editarMaestro -> actualizarAlumnoController();

	?>

</form>



