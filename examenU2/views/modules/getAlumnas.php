<?php
require_once "../../models/enlaces.php";
require_once "../../models/crud.php";
require_once "../../controllers/controller.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if(isset($_POST['call'])){
	if(!empty($_POST['call'])){
		$registro = new MvcController();
		echo($registro -> getAlumnasFromId($_POST['call']));
		exit;
	}
}
?>p