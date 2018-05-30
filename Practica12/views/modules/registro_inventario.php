<h1>REGISTRO DE INVENTARIO</h1>

<form method="post">
	<?php
		$registro = new MvcController();
		$registro -> registroBaseInventarioController();
		$registro -> registroInventarioController();
	?>
</form>

<?php


if(isset($_GET["action"])){
	if($_GET["action"] == "ok_carrera"){
		echo "Registro Exitoso";
	}
}

?>
