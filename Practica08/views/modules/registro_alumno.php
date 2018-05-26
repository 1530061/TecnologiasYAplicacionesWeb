<h1>REGISTRO DE ALUMNO</h1>

<form method="post">
	<?php
		$registro = new MvcController();
		$registro -> registroBaseAlumnoController();
		$registro -> registroAlumnoController();
	?>
</form>

<?php


if(isset($_GET["action"])){
	if($_GET["action"] == "ok_alumno"){
		echo "Registro Exitoso";
	}
}

?>
