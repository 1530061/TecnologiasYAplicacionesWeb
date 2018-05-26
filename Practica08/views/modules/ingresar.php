<h1>INGRESAR</h1>
	<form method="post">
		<input type="email" placeholder="Email" name="emailIngreso" required>
		<input type="password" placeholder="Contraseña" name="passwordIngreso" required>
		<input type="submit" value="Enviar">
	</form>
<?php

$ingreso = new MvcController();
$ingreso -> ingresoMaestroController();

if(isset($_GET["action"])){
	if($_GET["action"] == "fallo"){
		echo "Fallo al ingresar";
	}
}

?>