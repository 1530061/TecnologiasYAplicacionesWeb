<h1>REGISTRO DE CARRERA</h1>

<form method="post">
	<?php
		$registro = new MvcController();
		$registro -> registroBaseCarreraController();
		$registro -> registroCarreraController();
	?>
</form>

<?php


if(isset($_GET["action"])){
	if($_GET["action"] == "ok_carrera"){
		echo "Registro Exitoso";
	}
}

?>
