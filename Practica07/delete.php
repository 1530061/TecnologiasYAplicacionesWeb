<?php
	include_once('db/database_utilities.php');

	//En caso de que se encuentre el id al llamar esta funcion se disparara el evento de eliminar el registro en la base de datos.
	if(isset($_GET['id']) && isset($_GET['t'])){
		delete($_GET['id'],$_GET['t']);
		header("location: listado.php?t=".$_GET['t']);
	}

?>