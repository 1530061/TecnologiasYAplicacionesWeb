<?php
include_once('db/database_utilities.php');

$id = isset( $_GET['id'] ) ? $_GET['id'] : '';  //Se revisa que el id del usuario se encuentre mediante el metodo get.
$r = search($id); //Se realiza una busqueda en la base de datos donde se obtienen los atributos del registro con el id ingresado.

//Se revisa que la variable nombre y email, se encuentren definidas, para posteriormente realizar la actualizacino y al final se
//realiza un redireccionado a la pagina principal.
if(isset($_POST['nombre']) && isset($_POST['email'])){
  update($id,$_POST['nombre'],$_POST['email']);
  header("location:index.php");
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
                <form method="POST" action="update.php?id=<?php echo($id)?>">
                  <label for="nombre">Nombre:</label>
                  <input type="text" name="nombre" value="<?php echo($r['nombre'])?>"><br>
                  <label for="email">Email:</label>
                  <input type="email" name="email" value="<?php echo($r['correo'])?>"><br>
                  <button type="submit" class="success">Actualizar</button>
                </form>
            </div>
          </section>
        </div>
      </div>
    </div>
     
    <?php require_once('footer.php'); ?>