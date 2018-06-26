<?php
if(!isset($_SESSION)) 
    session_start(); 
 
if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="index.php?action=grupos">Grupos</a></li>
      <li class="breadcrumb-item active">Agregar Grupo</a></li>
    </ol>
  </div><!-- /.col -->
  <br><br>
</div>
<div class="card card-info mx-auto" style="width:50%;">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Registrar Grupo</h3>
		</div>
	</div>
	<form method="post">
		<div class="card-body">
			<div class="form-group">
				<?php
					$registro = new MvcController();
					$registro -> registroBaseGrupoController();
					$registro -> registroGrupoController();
				?>
			</div>
		</div>
	</form>
	
</div>
<?php


if(isset($_GET["action"])){
	if($_GET["action"] == "ok_grupo"){
		echo "Registro Exitoso";
	}
}

?>

