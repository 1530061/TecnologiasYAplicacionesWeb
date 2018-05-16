<?php
  session_start();
  require_once("db/database_utilities.php");

  if(!isset($_SESSION['username'])){
      header("location: login.php");
  }
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 07 | Inicio</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php require_once('header.php'); ?>

    <div class="row">
      <div class="large-9 columns">
        <h3>Practica 07</h3>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
              </div>
              <h3> Bienvenido <?php echo($_SESSION['username']); ?> </h3>
              <h5> Sistema para la gestion de ventas y el control de usuarios y productos para un establecimiento</h5>
          </section>
        </div>
      </div>
    </div>

    <?php require_once('footer.php'); ?>
