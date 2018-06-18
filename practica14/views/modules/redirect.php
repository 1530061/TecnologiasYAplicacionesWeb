<?php
	//Permite el redireccionar de entre la tienda superadmin a una tienda comun.
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	} 

	$_SESSION['id_tienda']=$_GET['id'];
	$_SESSION['sa']="1";

	$vistaAlumno = new MvcController();
	$vistaAlumno -> updateTiendaName($_SESSION['id_tienda']);

	header("location:index.php?action=dashboard");
?>