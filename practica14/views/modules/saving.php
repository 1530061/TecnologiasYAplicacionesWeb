<?php

	if(isset($_POST['data'])){
		require_once "../../models/enlaces.php";
		require_once "../../models/crud.php";
		require_once "../../controllers/controller.php";
		if(!isset($_SESSION)) 
		{ 
		    session_start(); 
		} 

		$verificar = new MvcController();
		echo($verificar -> insertSale($_POST['data']));
		//var_dump($_POST['data']);

	}

?>