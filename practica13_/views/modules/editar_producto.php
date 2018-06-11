<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}
if(isset($_SESSION['id_tienda']))
    if($_SESSION['id_tienda']=='1'){
    	header("location:index.php?action=tiendas");
    	exit();
    }

if(isset($_POST['codigo_a_verificar'])){
	require_once "../../models/enlaces.php";
	require_once "../../models/crud.php";
	require_once "../../controllers/controller.php";
	$verificar = new MvcController();
	echo($verificar -> checkAvailabilityOfProductCode($_POST['codigo_a_verificar']));

}else{

?>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="index.php?action=inventario">Inventario</a></li>
      <li class="breadcrumb-item active">Editar Producto</a></li>
      
    </ol>
  </div><!-- /.col -->
  <br><br>
</div>
<div class="card card-info mx-auto" style="width:50%;">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Editar Producto</h3>
		</div>
	</div>
	<form method="post">
		<div class="card-body">
			<div class="form-group">
	
			
			<?php

			$editarCarrera = new MvcController();
			$editarCarrera -> editarProductoController();
			$editarCarrera -> actualizarProductoController();

			?>
			</div>
		</div>
	</form>
	
</div>
<?php } ?>

