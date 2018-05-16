<?php
  session_start();
  require_once("db/database_utilities.php");

  if(!isset($_SESSION['username'])){
      header("location: login.php");
  }

  if(isset($_GET['id']))
    $r=getInfoFromSale($_GET['id']);
  
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 07 - Detalles Venta</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php require_once('header.php'); ?>

    <div class="row">
      <div class="large-12 columns">
        <h3>Detalle de Venta con el Id <?php echo($_GET['id']) ?></h3>
        <h4>Fecha: <strong><?php echo(getSaleDate($_GET['id']));?></strong></h4>
        <h4>Total: <strong><?php echo(getSaleTotal($_GET['id']));?></strong></h4>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <table class="large-12 columns" style="border: none;" >
                <tr>
                  <th> Id </th>
                  <th> Nombre del producto </th>
                  <th> Cantidad </th>
                  <th> Promedio por unidad </th>
                  <th> Importe </th>

                </tr>
                <?php for($i=0;$i<count($r);$i++){ ?>
                <tr>
                  <?php for($j=0;$j<5;$j++){?>
                    <td><?php echo($r[$i][$j]);?> </td>
                <?php } ?>
                 
                </tr>
                <?php } ?>
              </table>
              <?php  ?>

              
          </section>
        </div>
      </div>
    </div>

    <?php require_once('footer.php'); ?>
