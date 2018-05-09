<?php
	include_once('db/database_utilities.php');

	//En caso de que se encuentre el id al llamar esta funcion se disparara el evento de eliminar el registro en la base de datos.
	if(isset($_GET['id'])){
		delete($_GET['id']);
		header("location: index.php");
	}

?>