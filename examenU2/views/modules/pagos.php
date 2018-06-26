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
      <li class="breadcrumb-item active">Pagos</a></li>
    </ol>
  </div><!-- /.col -->
  <br><br>
</div>
<div class="card card-info" style="width:100%">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Pagos</h3>
		</div>
		<div class="d-inline-block float-right"">
		  <a href="index.php?action=p_agregar_pago"><button class="btn btn-block btn-success">Agregar Nuevo Pago</button></a>
		</div>
	</div>
	<div class="card-body">
		
		<table id="table" width="100%" border="0">
			<thead>
				<tr>
					<th>Id pago</th>
					<th>Alumna</th>
					<th>Nombre Madre</th>
					<th>Fecha Pago</th>
					<th>Fecha Envio</th>
					<th>Folio</th>
					<th>Ver Imagen</th>
					<th>¿Editar?</th>
					<th>¿Eliminar?</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$vistaAlumno = new MvcController();
				$vistaAlumno -> vistaPagoController();
				$vistaAlumno -> borrarPagoController();

				?>

			</tbody>
		</table>
	</div>
</div>
<?php

if(isset($_GET["action"])){
	if($_GET["action"] == "cambio_grupo"){
		echo "Cambio Exitoso";
	}
}


?>
