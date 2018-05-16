<?php
session_start();
require_once("db/database_utilities.php");

//Se revisa que la sesion halla sido iniciada
if(!isset($_SESSION['username'])){
    header("location: login.php");
}
$t = $_GET["t"];

$id = isset( $_GET['id'] ) ? $_GET['id'] : '';  //Se revisa que el id del usuario se encuentre mediante el metodo get.
$r = search($id,$t); //Se realiza una busqueda en la base de datos donde se obtienen los atributos del registro con el id ingresado.

//Dependiendo del caso que se este usando el formulario se realiza un guardado de usuario o de producto.
if($t==1){
  if(isset($_POST['name']) && isset($_POST['last_name']) && isset($_POST['ap_m']) && isset($_POST['user']) && isset($_POST['password'])){
    update_user($id,$_POST['name'],$_POST['last_name'],$_POST['ap_m'],$_POST['user'],md5($_POST['password']));
    header("location: listado.php?t=".$_GET['t']);  
  }
}else if($t==2){
  if(isset($_POST['name']) && isset($_POST['price'])){
    update_product($id,$_POST['name'],$_POST['price']);
    header("location: listado.php?t=".$_GET['t']);  
  }
}
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 07 - Modificar</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <?php require_once('header.php'); ?>

    <div class="row">
 
      <div class="large-9 columns">
        <?php
          if($t==1){
            echo("<h3>Modificar Usuario<h3>");
          }else if($t==2){
            echo("<h3>Modificar Producto<h3>");
          }
        ?>
        <br>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
                <?php
                  echo('<form method="POST" action="update.php?id='.$id.'&t='.$_GET['t'].'">');
                ?>
                  

                <?php
                if($t==1){
                ?>
                  <label for="name">Nombre:</label>
                  <input type="text" name="name" required value="<?php if(isset($r['nombre']))echo($r['nombre']) ?>"><br>
                  <label for="last_name">Apellido Paterno:</label>
                  <input type="text" name="last_name" required value="<?php if(isset($r['apellido_paterno']))echo($r['apellido_paterno']) ?>"><br>
                  <label for="ap_m">Apellido Materno:</label>
                  <input type="text" name="ap_m" required value="<?php if(isset($r['apellido_materno']))echo($r['apellido_materno']) ?>"><br>
                  <label for="user">Usuario:</label>
                  <input type="text" name="user" required value="<?php if(isset($r['usuario']))echo($r['usuario']) ?>"><br>
                  <label for="password">Contraseña:</label>
                  <input type="password" name="password" required><br>
                <?php 
                  }else if($t==2){
                ?>
                  <label for="name">Nombre:</label>
                  <input type="text" name="name" required value="<?php if(isset($r['nombre']))echo($r['nombre']);?>" ><br>
                  <label for="price">Precio:</label>
                  <input type="text" name="price" required value="<?php if(isset($r['precio']))echo($r['precio']);?>" ?><br>
                <?php
                  };
                ?>
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
          var r = confirm("¿Confirma los cambios realizados?");
          if (!r) 
              event.preventDefault();
        }
    </script>


    <?php require_once('footer.php'); ?>