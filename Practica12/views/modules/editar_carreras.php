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

	$editarCarrera = new MvcController();
	$editarCarrera -> editarCarreraController();
	$editarCarrera -> actualizarCarreraController();

	?>

</form>



