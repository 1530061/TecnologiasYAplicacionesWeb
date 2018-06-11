<?php
  //Permite el redireccionar de entre la tienda superadmin a una tienda comun.
 	
	if(isset($_POST['data'])){
		require_once "../../models/enlaces.php";
		require_once "../../models/crud.php";
		require_once "../../controllers/controller.php";
		$verificar = new MvcController();
		echo($verificar -> insertSale($_POST['data']));
		//var_dump($_POST['data']);

	}

?>