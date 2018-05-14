<?php
include_once('db/database_utilities.php');

$t=$_GET['t'];
//Se revisa que las variables nombre y email se esten recibiendo mediante el metodo POST para despues continuar
//con la insercion de los valores ingresados en la base de datos, para finalmente redireccionar al inicio
if(isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['posicion']) && isset($_POST['carrera'])&& isset($_POST['email'])){
  add($_POST['id'],$_POST['nombre'],$_POST['posicion'],$_POST['carrera'],$_POST['email'],$t);
  header("location: listado.php?t=".$_GET['t']."");
}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Curso PHP |  Bienvenidos</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <?php require_once('header.php'); ?>

    <div class="row">
 
      <div class="large-9 columns">
        <h3>Agregar Nuevo Usuario</h3>
        <br>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
                <form method="POST" action="add.php?t=<?php echo($t)?>">
                  <label for="id">Id:</label>
                  <input type="text" name="id"><br>
                  <label for="nombre">Nombre:</label>
                  <input type="text" name="nombre"><br>
                  <label for="posicion">Posicion:</label>
                  <input type="text" name="posicion"><br>
                  <label for="carrera">Carrera:</label>
                  <input type="text" name="carrera"><br>
                  <label for="email">Email:</label>
                  <input type="email" name="email"><br>
                  <button type="submit" class="success">Guardar</button>
                </form>
            </div>
          </section>
        </div>
      </div>
    </div>
     
    <?php require_once('footer.php'); ?>