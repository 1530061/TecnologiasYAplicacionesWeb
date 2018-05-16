<?php
  session_start();
  require_once("db/database_utilities.php");

  $t=$_GET['t'];

  if(!isset($_SESSION['username'])){
      header("location: login.php");
  }

  if($t==1){
    if(isset($_POST['name']) && isset($_POST['last_name']) && isset($_POST['ap_m']) && isset($_POST['user']) && isset($_POST['password'])){
      if(add_user($_POST['name'],$_POST['last_name'],$_POST['ap_m'],$_POST['user'],$_POST['password'])){
        header("location: listado.php?t=1");
      }else{
        echo("<script> alert('Usuario ya existe'); </script>");
      }
    } 
  }else if($t==2){
    if(isset($_POST['name']) && isset($_POST['price'])){
      add_product($_POST['name'],$_POST['price']);
      header("location: listado.php?t=2");
    } 
  }
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 07 |  Agregar</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php require_once('header.php'); ?>

    <div class="row">
      <div class="large-9 columns">
        <h3><?php
                if($t==1)
                  echo("Agregar Nuevo Usuario");
                else
                  echo("Agregar Nuevo Producto");
              ?>
            
        </h3>
        <div class="section-container tabs" data-section>
          <section class="section">
            <form method="POST" action="add.php?t=<?php echo($t);?>">
              <?php
                if($t==1){
              ?>
                <label for="name">Nombre:</label>
                <input type="text" name="name" required value="<?php if(isset($_POST['name']))echo($_POST['name']) ?>"><br>
                <label for="last_name">Apellido Paterno:</label>
                <input type="text" name="last_name" required value="<?php if(isset($_POST['last_name']))echo($_POST['last_name']) ?>"><br>
                <label for="ap_m">Apellido Materno:</label>
                <input type="text" name="ap_m" required value="<?php if(isset($_POST['ap_m']))echo($_POST['ap_m']) ?>"><br>
                <label for="user">Usuario:</label>
                <input type="text" name="user" required><br>
                <label for="password">Contraseña:</label>
                <input type="password" name="password" required><br>
              <?php 
                }else if($t==2){
              ?>
                <label for="name">Nombre:</label>
                <input type="text" name="name" required><br>
                <label for="price">Precio:</label>
                <input type="number" name="price" min="0" required><br>
              <?php
                };
              ?>
              <button type="submit" class="success">Agregar</button>
            </form>
          </section>
      </div>
    </div>

    <?php require_once('footer.php'); ?>
