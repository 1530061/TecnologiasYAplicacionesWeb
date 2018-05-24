<?php

session_start();

if(!$_SESSION["validar"]){

	header("location:index.php?action=ingresar");

	exit();

}

?>

<h1>REGISTRO DE PRODUCTOS</h1>

<form method="post">
	
	<input type="text" placeholder="Product Name" name="nombreProd" required>

	<input type="text" placeholder="Description" name="descProduc" required>
	<input type="number" placeholder="Buy price" min="0" name="BuyPrice" required>
	<input type="number" placeholder="Sale price" min="0" name="SalePrice" required>
	<input type="number" placeholder="Price" min="0" name="Proce" required>

	<input type="submit" value="Enviar">

</form>

<?php
//Enviar los datos al controlador MvcController (es la clase principal de controller.php)
$registro = new MvcController();
//se invoca la función registroProductosController de la clase MvcController:
$registro -> registroProductosController();

if(isset($_GET["action"])){

	if($_GET["action"] == "done"){

		echo "Registro Exitoso";
	
	}

}

?>
