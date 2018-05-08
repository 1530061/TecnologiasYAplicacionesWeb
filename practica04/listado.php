<?php
include_once('utilities.php');

$t=$_GET['t'];  //Variable que representa el tipo de formulario(alumno=1/maestro=2)

//Llenado del arreglo user_access mediante la funcion fill_array la cual permite obtener los registros del archivo
//txt correspondiente al tipo que se este usando (alumno/maestro).
$user_access = fill_array($t);
$total_users = count($user_access);
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Listado </title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    
    <?php require_once('header.php'); ?>

    <div class="row">
 
      <div class="large-9 columns">
        <h3>Ejemplos de listado en array</h3>
          <p>Listado</p>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
              </div>
              <?php if($total_users){ ?>
              <table>
                <thead>
                  <tr>
                    <?php if($t==1){ ?>
                    <th width="200">ID</th>
                    <th width="250">Matricula</th>
                    <th width="250">Nombre</th>
                    <th width="250">Carrera</th>
                    <th width="250">Email</th>
                    <th width="250">Telefono</th>
                    <?php }else if($t==2){?>
                    <th width="200">ID</th>
                    <th width="250">Num Empleado</th>
                    <th width="250">Carrera</th>
                    <th width="250">Nombre</th>
                    <th width="250">Telefono</th>
                    <?php }?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach( $user_access as $id => $user ){ ?>
                  <tr>
                    <?php if($t==1){ ?>
                    <td><?php echo $id ?></td>
                    <td><?php echo $user['matricula'] ?></td>
                    <td><?php echo $user['nombre'] ?></td>
                    <td><?php echo $user['carrera'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['telefono'] ?></td>
                    <?php }else if($t==2){?>
                    <td><?php echo $id ?></td>
                    <td><?php echo $user['num_empleado'] ?></td>
                    <td><?php echo $user['carrera'] ?></td>
                    <td><?php echo $user['nombre'] ?></td>
                    <td><?php echo $user['telefono'] ?></td>
                    <?php }?>
                    <td><a href="./key.php?t=<?php echo $t; ?>&id=<?php echo $id; ?>" class="button radius tiny secondary">Ver detalles</a></td>
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
    

    <?php require_once('footer.php'); ?>