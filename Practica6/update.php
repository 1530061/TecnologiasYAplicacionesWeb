<?php
include_once('db/database_utilities.php');

$id = isset( $_GET['id'] ) ? $_GET['id'] : '';  //Se revisa que el id del usuario se encuentre mediante el metodo get.
$r = search($id); //Se realiza una busqueda en la base de datos donde se obtienen los atributos del registro con el id ingresado.


//Se revisa que la variable nombre y email, se encuentren definidas, para posteriormente realizar la actualizacino y al final se
//realiza un redireccionado a la pagina principal.
if(isset($_POST['nombre']) && isset($_POST['email'])){

  //Se realiza la actualizacion del registro haciendo uso de la funcion update
  update($id,$_POST['nombre'],$_POST['posicion'],$_POST['carrera'],$_POST['email']);

  //Al termino de la actualizacion se redirige a la pagina anterior en el listado
  header("location: listado.php?t=".$_GET['t']);
  
}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Curso PHP |  Modificar Jugador</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <?php require_once('header.php'); ?>

    <div class="row">
 
      <div class="large-9 columns">
        <h3>Modificar Jugador</h3>
        <br>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
                <?php
                  echo('<form method="POST" action="update.php?id='.$id.'&t='.$_GET['t'].'">');
                ?>
                  <label for="id">Id:</label>
                  <input type="text" name="id" value="<?php echo($r['id'])?>"><br>
                  <label for="nombre">Id:</label>
                  <input type="text" name="nombre" value="<?php echo($r['nombre'])?>"><br>
                  <label for="posicion">Posicion:</label>
                  <input type="text" name="posicion" value="<?php echo($r['posicion'])?>"><br>
                  <label for="carrera">Carrera:</label>
                  <input type="text" name="carrera" value="<?php echo($r['carrera'])?>"><br>
                  <label for="email">Email:</label>
                  <input type="email" name="email" value="<?php echo($r['email'])?>"><br>
                  <button type="submit" class="success" onClick="wait();">Modificar</button>
                </form>
            </div>
          </section>
        </div>
      </div>
    </div>
     
   <script type="text/javascript">
        //Funcion que permite cancelar el evento en caso de querer modificar un registro.
        function wait(){
          var r = confirm("¿Desea modificar el usuario?");
          if (!r) 
              event.preventDefault();
        }
    </script>


    <?php require_once('footer.php'); ?>