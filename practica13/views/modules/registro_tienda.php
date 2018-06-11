<?php
session_start();

if(isset($_SESSION['id_tienda']))
    if($_SESSION['id_tienda']!='1'){
    	header("location:index.php?action=tiendas");
    	exit();
    }
?>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="index.php?action=tiendas">Tiendas</a></li>
      <li class="breadcrumb-item active">Agregar Tienda</a></li>
    </ol>
  </div><!-- /.col -->
  <br><br>
</div>
<div class="card card-info mx-auto" style="width:50%;">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Registrar Categoria</h3>
		</div>
	</div>
	<form method="post">
		<div class="card-body">
			<div class="form-group">
				<?php
					$registro = new MvcController();
					$registro -> registroBaseTiendaController();
					$registro -> registroTiendaController();
				?>
			</div>
		</div>
	</form>
	
</div>
<?php


if(isset($_GET["action"])){
	if($_GET["action"] == "ok_tienda"){
		echo "Registro Exitoso";
	}
}

?>

