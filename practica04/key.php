<?php
include_once('utilities.php');

$t=$_GET['t']; //Variable que representa el tipo de formulario(alumno=1/maestro=2)

//Llenado del arreglo user_access mediante la funcion fill_array la cual permite obtener los registros del archivo
//txt correspondiente al tipo que se este usando (alumno/maestro).
$user_access = fill_array($t);
$id = isset( $_GET['id'] ) ? $_GET['id'] : '';
if( !array_key_exists($id, $user_access) )
{
  die('No existe dicho usuario');
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
        <h3>Manejo de arreglos</h3>
          <p>Elemento de un arreglo</p>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
              </div>
              <ul class="pricing-table">
                <li class="title">Detalle de indice</li>
                <?//Se imprimen los atributos correspondientes al tipo que se este usando el arhivo (alumno/maestro) para el
                  //registro seleccionado?>
                <?php if($t==1){ ?>
                <li class="description"><?php echo $user_access[$id]['matricula'] ?></li>
                <li class="description"><?php echo $user_access[$id]['nombre'] ?></li>
                <li class="description"><?php echo $user_access[$id]['carrera'] ?></li>
                <li class="description"><?php echo $user_access[$id]['email'] ?></li>
                <li class="description"><?php echo $user_access[$id]['telefono'] ?></li>
                <?php }else if($t==2){ ?>
                <li class="description"><?php echo $user_access[$id]['num_empleado'] ?></li>
                <li class="description"><?php echo $user_access[$id]['carrera'] ?></li>
                <li class="description"><?php echo $user_access[$id]['nombre'] ?></li>
                <li class="description"><?php echo $user_access[$id]['telefono'] ?></li>
                <?php }?>
              </ul>
            </div>
          </section>
        </div>
      </div>
    </div>
     
    <?php require_once('footer.php'); ?>