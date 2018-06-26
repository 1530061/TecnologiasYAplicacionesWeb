<?php

if(!isset($_SESSION))  
    session_start(); 
else if($_SESSION["validar"]){
	header("location:index.php?action=dashboard");
	exit();
}

//echo("<script>alert('hola');</script>");

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Examen</title>
  <!-- Tell the browser to be responsive to screen width -->
</head>
<section class="content">
	<div class="card">
		<div class="card-header" style="background-color: purple">
			<div class="row">
				<div class="col-6">
					<h3 style="color:white"> Danzlife </h3>
				</div>
				<div class="col-6" align="right">
						<a href="index.php?action=p_agregar_pago" class="btn" style="background-color: white">Inicio</a>
						<a href="index.php?action=p_lugares" class="btn" style="background-color: white">Lugares</a>
						<a href="index.php?action=ingresar" class="btn" style="background-color: white">Ingresar</a>
				</div>
			</div>
		</div>

	</div>
</section>


<?php
	$registro = new MvcController();
	$registro -> registroPagoController();

	$st_grupo = $registro -> getSelect();
?>

<div class="container-fluid">
  	<center>
		<section class="content" style="width:90%">
	      <div class="container-fluid">
	        <div class="card card-primary card-outline">
	        	<form method="post" enctype="multipart/form-data">
			          <div class="card-header">
			            <h3 class="card-title">Formulario de Envio de Comprobantes</h3>
			            <h2>Festival Verano 2018</h2>
			          </div> <!-- /.card-body -->
			          <div class="card-body" align="left">
			          	<br>
			          	<label for="id_grupo">Seleccione grupo</label>
			            <select id="grupos" class="form-control js-example-basic-multiple" name="id_grupo" required>
						  <?php echo($st_grupo) ?>
						</select>
						<br>
						<label for="id_grupo">Seleccione alumna</label>
						<select id="alumnas" class="form-control js-example-basic-multiple" name="id_alumna" required>
						  
						</select>
						<br>
						<div class="row">
							<div class="col-md-6">
								<label for="nombre_mama">Nombre de la mama</label>
								<input class = "form-control" type="text" name="nombre_mama" required>
							</div>
							<div class="col-md-6">
								<label for="apellido_mama">Apellido de la mama</label>
								<input class = "form-control"  type="text" name="apellido_mama" required>
							</div>
						</div>
						
						<div class="form-group">
		                  
							<label for="fecha_pago">Fecha de pago</label>
							<div class="input-group">
								<div class="input-group-prepend">
								  <span class="input-group-text">
								    <i class="fa fa-calendar"></i>
								  </span>
								</div>
							<input type="datetime" name="fecha_pago" class="form-control pull-right" id="dtp" required>
							</div>
		                  <!-- /.input group -->
		                </div>
		                <label>Comprobante de folio:</label>
		                <br>
		                <input type="file" name="fileToUpload" id="fileToUpload" required>
		                <br><br>
		                <label for="folio">Folio de autorizacion:</label>
						<input class = "form-control"  type="text" name="folio" required>
						<br>
		                 <input type="submit" class="btn btn-primary" value="Aceptar">
						
						
			          </div><!-- /.card-body -->
			         </form>
	        </div>
	      </div><!-- /.container-fluid -->
	    </section>
	</center>
</div>


<script>
	var selects = document.getElementById("grupos");
	$( document ).ready(function() {  
		$.ajax({
				async: false,
				cache: false,
				type: "POST",
				url: "./views/modules/getAlumnas.php",
				data: { "call":selects.options[selects.selectedIndex].value},
				success: function (data, response) {
					console.log(data);
					$("#alumnas").html(data);
				},error: function(){
					$("#alumnas").html("");
				}
			});
		$("#alumnas").val(0); 
	});

	$(document).on('change','#grupos',function(){
		 
  
		$.ajax({
			async: false,
			cache: false,
			type: "POST",
			url: "./views/modules/getAlumnas.php",
			data: { "call":selects.options[selects.selectedIndex].value},
			success: function (data, response) {
				console.log(data);
				$("#alumnas").html(data);
			},error: function(){
				$("#alumnas").html("");
			}
		});
    });

   


</script>
