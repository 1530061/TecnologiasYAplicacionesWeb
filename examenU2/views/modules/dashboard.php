<?php

if(!isset($_SESSION))  
    session_start(); 

if(!isset($_SESSION["validar"]) && !$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}


?>

<div class="container-fluid">
  <h3>Bienvenido</h3>
	<div class="row">
    	<img src="./views/dist/img/danzlife.jpeg" alt="Danzlife" height="500" width="500">
  	</div>
</div>
