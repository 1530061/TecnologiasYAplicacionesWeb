<?php
include('alumno.php');
include('maestro.php');

$t=$_GET['t']; //Variable que representa el tipo (alumno=1/maestro=2)

//Se revisa que el archivo fue llamado mediante el metodo el metodo post y se revisan que las variables no esten vacias, para despues crear un objeto correspondiente
//a el tipo de uso que se le este dando a la pagina(alumno/maestro) y finalmente se hace un guardado en el archivo txt.
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  if($t==1 && !empty($_POST['matricula']) && !empty($_POST['nombre']) && !empty($_POST['carrera']) && !empty($_POST['email']) && !empty($_POST['telefono'])){
    $a = new alumno($_POST['matricula'],$_POST['nombre'],$_POST['carrera'],$_POST['email'],$_POST['telefono']);
    $a->save();
  }else if($t==2 && !empty($_POST['num_empleado']) && !empty($_POST['carrera']) && !empty($_POST['nombre']) && !empty($_POST['telefono'])){
    $m = new maestro($_POST['num_empleado'], $_POST['carrera'], $_POST['nombre'], $_POST['telefono']);
    $m->save();
  }
}

?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alta</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <?php require_once('header.php'); ?>

     
    <div class="row">
 
      <div class="large-9 columns">
        <?php
          if($t==1)
            echo("<h3>Alta Alumno</h3>");
          else if($t==2)
            echo("<h3>Alta Maestro</h3>");
          else
            echo("<h3>No se encontro</h3>");
        ?>

        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
    				  <form action="./alta.php?t=<?php echo($t) ?>" method="post">
                <?//Dependiendo de el tipo de uso que se le este dando al formulario, se imprimen los valores correspondientes?>
                <?php if($t==1){ ?>
                <label for="matricula">Matricula: </label>
                <input type="text" name="matricula"></label>
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre"></label>
                <label for="carrera">Carrera: </label>
                <input type="text" name="carrera"></label>
                <label for="email">Email: </label>
                <input type="email" name="email"></label>
                <label for="telefono">Telefono: </label>
                <input type="text" name="telefono"></label>
                <?php }else if($t==2){ ?>
                <label for="num_empleado">Numero Empleado: </label>
                <input type="text" name="num_empleado"></label>
                <label for="carrera">Carrera: </label>
                <input type="text" name="carrera"></label>
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre"></label>
                <label for="telefono">Email: </label>
                <input type="email" name="telefono"></label>
                <?php }else{header('Location: ./alta.php?t=1');} ?>
                <input class="button radius big primary" style="float:right;" type="submit" value="Submit">
              </form>
            </div>
          </section>
        </div>
        
        
      </div>

    </div>
    

    <?php require_once('footer.php'); ?>