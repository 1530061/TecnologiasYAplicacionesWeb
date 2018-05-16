<?php
  session_start();
  require_once("db/database_utilities.php");

  //Se revisa que la sesion est iniciada
  if(!isset($_SESSION['username'])){
      header("location: login.php");
  }

  //Se checa que se tenga el valor de la fecha en post y se hace uso de la funcion getAllInfoFromSales
  if(isset($_POST['date']))
    //En caso de que se tenga una fecha
    $r=getAllInfoFromSales($_POST['date']);
  else
    //En caso de que se quieran revisar todos
    $r=getAllInfoFromSales();
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 07 |  Reporte Ventas</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php require_once('header.php'); ?>

    <div class="row">
      <div class="large-12 columns">
        <h3>Reporte de Ventas</h3>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <h5>Seleccione una fecha para realizar la busqueda</h5>
              <div class="row">
                <form method="POST" action="reporte_ventas.php">
                  <div class="large-8 columns">
                    <label for="date">Fecha: </label>
                    <input type="date" name="date"><br><br>
                  </div>
                  <div class="large-4 columns">
                    <button type="submit" class="success">Buscar</button>
                  </div>
                </form>
              </div>
              <table class="large-12 columns" style="border: none;" >
                <tr>
                  <th> Id </th>
                  <th> Fecha </th>
                  <th> Total </th>
                  <th> Detalles </th>
                </tr>
                <?php for($i=0;$i<count($r);$i++){ ?>
                <tr>
                  <?php for($j=0;$j<3;$j++){?>
                    <td><?php echo($r[$i][$j]);?> </td>
                <?php } ?>
                  <td><a href="./detalles_venta.php?id=<?php echo($r[$i][0]); ?>" class="button radius tiny warning"">Detalles</a></td>
                </tr>
                <?php } ?>
              </table>
              <?php  ?>
          </section>
        </div>
      </div>
    </div>

    <?php require_once('footer.php'); ?>
