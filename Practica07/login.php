<?php
  require_once("db/database_utilities.php");

  if(isset($_COOKIE) &&is_array($_COOKIE) && count($_COOKIE)>0 && isset($_COOKIE['username']) && $_COOKIE['username']!=null){
      session_start();
  }

  if(isset($_GET['action']) && $_GET['action']=='logout'){
      unset($_SESSION['username']);
  }

  if (isset($_POST['formu'])){
    //Imprime el array con los datos de acceso, una vez logueado
    if(isset($_POST['formu']['user']) && isset($_POST['formu']['pass']) && checkUserAndPass($_POST['formu']['pass'],$_POST['formu']['user'])){
        session_start();
        $_SESSION['username']=$_POST['formu']['user'];
        //setcookie("username", $_POST['formu']['user']);
    }
  }

  if(isset($_SESSION['username'])){
    header("location: index.php");
  }else{
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 07 | Login</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php require_once('header.php'); ?>

    <div class="row">

      <div class="large-6 columns">
        <h3>Iniciar Sesion</h3>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
              </div>
              <form method="POST" action="login.php" name="formu">
                <label for="user">Usuario:</label>
                <input type="text" name="formu[user]" value="<?php
                   if(isset($_POST['formu']['nombre'])&&$_POST['formu']['nombre']!=null){
                       echo $_POST['formu']['nombre'];
                   }?>">
                <br>
                <label for="pass">Contraseña:</label>
                <input type="password" name="formu[pass]" value="<?php
                   if(isset($_POST['formu']['pass'])
                       &&$_POST['formu']['pass']!=null){
                       echo $_POST['formu']['pass'];
                   }?>">
                <br>
                <button type="submit" name="formu[enviar]" class="success">Ingresar</button>
              </form>
              <?php } ?>
            </div>
          </section>
        </div>
      </div>
    </div>

    <?php require_once('footer.php'); ?>
