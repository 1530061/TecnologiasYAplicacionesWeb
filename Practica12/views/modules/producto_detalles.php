<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<div class="card card-info" style="width:100%">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Detalles de Producto</h3>
		</div>
	</div>
	<div class="card-body">
			
		<?php

		$editarCarrera = new MvcController();
		$editarCarrera -> productoDetallesController();
		$editarCarrera -> vistaProductoDetallesController();
		
		

		?>
	</div>
<?php

if(isset($_GET["action"])){
	if($_GET["action"] == "cambio"){
		echo "Cambio Exitoso";
	}
}


?>
