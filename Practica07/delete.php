<?php
	include_once('db/database_utilities.php');

	//Permite eliminar un usuario del sistema dependiendo de su id.
	if(isset($_GET['id']) && isset($_GET['t'])){
		delete($_GET['id'],$_GET['t']);
		header("location: listado.php?t=".$_GET['t']);
	}

?>