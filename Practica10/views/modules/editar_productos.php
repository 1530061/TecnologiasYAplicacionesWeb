<?php

session_start();

if(!$_SESSION["validar"]){

	header("location:index.php?action=ingresar");

	exit();

}

?>

<h1>EDITAR USUARIO</h1>

<form method="post">
	
	<?php

	$editarProducto = new MvcController();
	$editarProducto -> editarProductoController();
	$editarProducto -> actualizarProductoController();

	?>

</form>



