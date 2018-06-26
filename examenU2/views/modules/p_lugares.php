<?php

if(!isset($_SESSION))  
    session_start(); 

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
		<br><br><br>
		<h3 class="card-title"></h3>
		<center>
			<div class="card card-info" style="width:80%">
				<div class="card-body">
					<table id="table" width="100%" border="0">
						<thead>
							<tr>
								<th>Id pago</th>
								<th>Alumna</th>
								<th>Nombre Madre</th>
								<th>Fecha Envio</th>
								<th>Folio</th>
							</tr>
						</thead>
						<tbody>
							<?php

							$vistaAlumno = new MvcController();
							$vistaAlumno -> vistaPublicPagoController();

							?>

						</tbody>
					</table>
				</div>
			</div>
		</center>

	</div>

</section>


