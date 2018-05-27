<h1>REGISTRO DE TUTORIA</h1>
<?php
session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}
?>

<form id="tutoriaForm" method="post">
	<?php
		$registro = new MvcController();
		$registro -> registroBaseTutoriaController();
		$registro -> registroTutoriaController();
	?>
</form>

<?php


if(isset($_GET["action"])){
	if($_GET["action"] == "ok_tutoria"){
		echo "Registro Exitoso";
	}
}

?>
