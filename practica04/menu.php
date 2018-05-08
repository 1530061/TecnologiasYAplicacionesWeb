<?php
$t=$_GET['t']; //Variable que representa el tipo de formulario(alumno=1/maestro=2)
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu Principal |  Bienvenidos</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <?php require_once('header.php'); ?>

    <div class="row">
 
      <div >
        <h3>Menu Principal</h3>
         
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
				<div class="row">
				</div>
				  <center>
  					<a href="./alta.php?t=<?php echo($t)?>" class="button radius big secondary">Alta</a>
  					<a href="./listado.php?t=<?php echo($t)?>" class="button radius big secondary">Listado</a>
        	</center>
          </div>
          </section>
        </div>
      </div>

    </div>
    

    <?php require_once('footer.php'); ?>