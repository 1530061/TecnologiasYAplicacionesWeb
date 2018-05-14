<?php
  require_once("db/database_utilities.php");
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 06 </title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php require_once('header.php'); ?>

    <div class="row">
      <div>
        <h3>Ejercicio 1</h3>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
              </div>
              <center>
                <td><a href="./listado.php?t=1" class="button radius success">Sistema para Futbolistas</a></td>
                <td><a href="./listado.php?t=2" class="button radius success">Sistema para Basquetbolistas</a></td>
              </center>
          </section>
        </div>
      </div>
    </div>

    <?php require_once('footer.php'); ?>
