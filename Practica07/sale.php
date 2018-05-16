<?php
  session_start();
  require_once("db/database_utilities.php");

  //Se revisa que la sesion este inciada
  if(!isset($_SESSION['username'])){
      header("location: login.php");
  }

  //Se checa si existe 'data' en post que corresponde a un array que se obtiene con todos los registros
  //de la venta posteriormente se realiza el guardado de la misma
  if(isset($_POST)){
      if(isset($_POST['data'])){
      $data = $_POST['data'];
      saveSale($data);
      exit();
     
    }
  }

  //Se obtiene el nombre de los productos para llenar el select de la interfaz
  $products = get_productNames();   

  //Se llena el select que muestra los nombres y el id de los productos registrados en el sistema.
  $select="<select id='sel_prod'>";
  for($i=0;$i<count($products);$i++){
     $select=$select.'<option value="'.$products[$i]['precio'].'">'.$products[$i]['id'].'-'.$products[$i]['nombre'].'</option>';
  }
  $select=$select.'</select>';

  $count=0;

?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Practica 07 |  Ventas</title>
    <link rel="stylesheet" href="./css/foundation.css" />
    <script src="./js/vendor/modernizr.js"></script>
  </head>
  <body>
    <?php require_once('header.php'); ?>

    <div class="row">
      <div class="large-12 columns">
        <h3>Venta</h3>
        <div class="section-container tabs" data-section>
          <section class="section">
            <div class="content" data-slug="panel1">
              <div class="row">
                <table class="large-12 columns" style="border: none; ">
                  <thead>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th></th>
                  </thead>
                  <tbody id="tab">
                    <tr>
                      <td>
                        <?php echo($select)?>
                      </td>
                      <td>
                        <input type="number" name="txt_cant" min="1" value="1" id="txt_cant">
                      </td>
                      <td style="width:50px;">
                         <button id="btn_nu" value="Click" onclick="add_row()">Agregar</button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <h3>Informacion de la venta:</h3>
                <table class="large-12 columns" style="border: none; ">
                  <thead>
                    <tr>
                      <th id="txt_fecha">

                        Fecha: 
                        <?php 
                          $mydate=getdate(date("U"));
                          echo "$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]"
                        ?>
                      </th>
                      <th id="txt_total">Total: 0</th>
                      <th style="width:50px;">
                         <button id="btn_terminar" style="height:60px" onclick="sendData();">Terminar Venta</button>
                      </th>
                    </tr>
                  </thead>
                </table>
               
                <table class="large-12 columns" style="border: none;">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombre</th>
                      <th>Cantidad</th>
                      <th>Promedio por Unidad</th>
                      <th>Importe</th>
                    </tr>
                  </thead>
                  <tbody id="tab_details">
                  
                  
                    
                  </tbody>
                </table>
              </div>
          </section>
        </div>
      </div>
    </div>

    <script>
      var count=0;
      var details=[];

      //Funcion que permite añadir una nueva fila a la tabla del fondo, permitiendo tambien
      //agregar cantidades a los productos que ya se encuentran actualmente en la tabla.
      function add_row(){
        //Llamado de componentes
        var e = document.getElementById("sel_prod");
        var c = document.getElementById("txt_cant");
        var table = document.getElementById("tab_details");
        var txt_total = document.getElementById("txt_total");

        //Obteniendo todos los valores
        var split = e.options[e.selectedIndex].text.split("-");
        var id=split[0];
        var nombre=split[1];
        var cantidad = Number(c.value);
        var importe = e.options[e.selectedIndex].value*cantidad;
        var prom_unidad = importe/cantidad;

        var total=0;
        var found=false;
        //En caso de que ya exista, el registro existente se modifica y se agregan las cantidades
        for(var i=0;i<details.length;i++){
          if(details[i][0]==id){
            details[i][2]=details[i][2]+cantidad;
            details[i][4]=details[i][4]+importe;
            details[i][3]=details[i][4]/details[i][2];
            found=true;
          }
          total+=details[i][4];
        }
        if(!found)
          details.push([id,nombre,cantidad,prom_unidad, importe]);

        var new_row="";
        
        for(var i=0;i<details.length;i++){
          new_row=new_row+"<tr><td>"+details[i][0]+"</td><td>"+details[i][1]+"</td><td>"+details[i][2]+"</td><td>"+details[i][3]+"</td><td>"+details[i][4]+"</td></tr>";
        }
        
        table.innerHTML="";
        table.innerHTML=new_row;
        txt_total.innerHTML = "Total: "+total;
      }

      //Se envia la matriz que contiene la tabla por post a sale.php donde se continua con su guardado mediante PHP.
      var sendData = function() {
        if(details.length==0){
          alert("Por favor, ingrese algun producto en la venta primero");
        }else{
          var r = confirm("¿Cerrar esta venta?");
          if (!r) 
              event.preventDefault();
          else{
            $.post('sale.php', {
              data: details
            }, function(response) {
            });
            alert("Venta realizada exitosamente");
            window.location.href = 'sale.php';
          }
        }
      }

      $(document).foundation();

      var doc = document.documentElement;
      doc.setAttribute('data-useragent', navigator.userAgent);
    </script>
   

    <?php require_once('footer.php'); ?>
