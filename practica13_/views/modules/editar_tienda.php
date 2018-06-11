<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}
if(isset($_SESSION['id_tienda']))
    if($_SESSION['id_tienda']!='1'){
    	header("location:index.php?action=dashboard");
    	exit();
    }

?>

<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="index.php?action=tiendas">Tiendas</a></li>
      <li class="breadcrumb-item active">Editar Tienda</a></li>
    </ol>
  </div><!-- /.col -->
  <br><br>
</div>
<div class="card card-info mx-auto" style="width:50%;">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Editar Tienda</h3>
		</div>
	</div>
	<form method="post" id="cat">
		<div class="card-body">
			<div class="form-group">
	
			<?php

			$editarCarrera = new MvcController();
			$editarCarrera -> editarTiendaController();
			$editarCarrera -> actualizarTiendaController();

			?>
			</div>
		</div>
	</form>
	
</div>



