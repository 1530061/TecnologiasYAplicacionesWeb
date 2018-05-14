<?php

include_once('db/database_utilities.php');

$t = $_GET["t"];

$user_access = getAll($t);           //Se obtienen todos los registros y se llena el array mediante los usuarios encontrados en la base de datos.
$total_users = count($user_access); //Se hace un conteo de cuantos registros se tinen en el sistema.
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
        <h3>Listado de jugadores<h3>
          <p></p>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
              </div>
              <td><a href="./add.php?t=<?php echo($t) ?>" class="button radius tiny success">Agregar nuevo registro</a></td>
              <?php if($total_users){ ?>
              <table>
                <thead>
                  <tr>
                    <th width="200">Id</th>
                    <th width="250">Nombre</th>
                    <th width="250">Posicion</th>
                    <th width="250">Carrera</th>
                    <th width="250">Email</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach( $user_access as $id => $user ){ ?>
                  <tr>
                    <td><?php echo $user['id'] ?></td>
                    <td><?php echo $user['nombre'] ?></td>
                    <td><?php echo $user['posicion'] ?></td>
                    <td><?php echo $user['carrera'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <?//Se generan dos botones, que redireccionan a acutalizaar y eliminar respectivamente."?>
                    <td><a href="./update.php?id=<?php echo($user['id']); ?>&t=<?php echo($t) ?>" class="button radius tiny warning"">Modificar</a></td>
                    <td><a href="./delete.php?id=<?php echo($user['id']); ?>" class="button radius tiny alert" onClick="wait();">Eliminar</a></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="4"><b>Total de registros: </b> <?php echo $total_users; ?></td>
                  </tr>
                </tbody>
              </table>
              <?php }else{ ?>
              No hay registros
              <?php } ?>
            </div>
          </section>
        </div>
      </div>

    </div>


    <script type="text/javascript">
        //Funcion que permite cancelar el evento en caso de querer borrar un archivo.
        function wait(){
          var r = confirm("¿Desea eliminar el usuario?");
          if (!r) 
              event.preventDefault();
        }
    </script>

    <?php require_once('footer.php'); ?>
