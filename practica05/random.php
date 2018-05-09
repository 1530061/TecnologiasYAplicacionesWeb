<?php
include_once('utilities.php');
$type[] = ' ';
$type[] = 'success';
$type[] = 'secondary';
$type[] = 'alert';
$type[] = 'info';
$type[] = 'disabled';
$random_type = array_rand($type);
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
        <h3>Array random</h3>
          <p>Color al azar</p>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
              </div>
              <a href="#" class="button <?php echo $type[$random_type]; ?>">Acción</a>
            </div>
          </section>
        </div>
      </div>
    

    <?php require_once('footer.php'); ?>