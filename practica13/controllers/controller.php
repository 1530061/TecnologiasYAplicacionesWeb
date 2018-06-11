<?php

class MvcController{

	#LLAMADA A LA PLANTILLA
	#-------------------------------------
	#Permite la llamada al template de la pagina
	public function pagina(){
		
		include "views/template.php";
	
	}

	#ENLACES
	#-------------------------------------
	#Permite controlar los enlaces que existen entre las vistas de la pagina, haciendo uso del modelo
	public function enlacesPaginasController(){
		if(isset( $_GET['action']))		
			$enlaces = $_GET['action'];
		else
			$enlaces = "index";
		$respuesta = Paginas::enlacesPaginasModel($enlaces);
		include $respuesta;
	}

	#ACTUALIZAR NOMBRE
	#-------------------------------------
	#Actualiza el nombre de la tienda de la variable sesion
	public function updateTiendaName($id_tienda){
		$r_tienda = Datos::getDetailsFromTienda($id_tienda, "tienda");
		$_SESSION['nombre_tienda']=$r_tienda['nombre'];
	}

	#Ingreso de USUARIOS
	#------------------------------------
	#Se encarga de revisar la cuenta ingresada y conceder los permisos debidos
	public function ingresoUsuarioController(){

		if(isset($_POST["user"])){
			$datosController = array( "user_name"=>$_POST["user"], 
								      "pass"=>$_POST["pass"]);
			$respuesta = Datos::ingresoUsuarioModel($datosController, "users");
			
			var_dump(md5($_POST["pass"]));
			if($respuesta["user_name"] == $_POST["user"] && $respuesta["user_password_hash"] == md5($_POST["pass"])){
				
				$r_tienda = Datos::getDetailsFromTienda($respuesta['id_tienda'], "tienda");

				
				if(sizeof($r_tienda)>0 && $r_tienda['activa']==1){
					session_start();
					$_SESSION["validar"] = true;
					$_SESSION["user_p"] = $_POST["pass"];
					$_SESSION["user_id"] = $respuesta["user_id"];
					$_SESSION["name"] = $respuesta["firstname"]." ".$respuesta["lastname"];
					$_SESSION["id_tienda"] = $respuesta["id_tienda"];
					$_SESSION["nombre_tienda"] = $r_tienda['nombre'];
					if($respuesta["id_tienda"]=="1")
						$_SESSION['sa']="1";
					else
						$_SESSION['sa']="0";
					
					header("location:index.php?action=dashboard");
				}else{
					header("location:index.php?action=fallo");
				}
			}
			else{
				header("location:index.php?action=fallo");
			}
		}
	}

	#Obtiene los valores de determinado campo para el dashboard
	#------------------------------------
	#Retorna un valor del modelo
	public function dashboardDetailsControllers(){
		$r1 = Datos::getTotalOfModel("products");
		$r2 = Datos::getTotalOfModel("users");
		$r3 = Datos::getTotalOfModel("categorias");
		$r4  =Datos::getTotalOfModel("historial");

		$array = array(	  "r1"=>$r1, 
						  "r2"=>$r2,
						  "r3"=>$r3, 
						  "r4"=>$r4);
		return $array;
	}


	#Vista de productos
	#------------------------------------
	#CRUD de los productos
	public function productoDetallesController(){
		if(isset($_POST['t'])){
			$accion = $_POST['t']=="in"?"agrego":"retiro";
			$datosController = array( 	
									"id_producto"=>$_POST["id_producto"], 
									"user_id"=>$_SESSION["user_id"], 
									"fecha"=>date("Y-m-d H:i:s"), 
									"nota"=>"El usuario ".$_SESSION["name"]." ".$accion." ".$_POST['unidades']." producto(s) al inventario.",
									"referencia"=>$_POST["referencia"], 
									"cantidad"=>$_POST["unidades"]
									);
			$flag=false;
			$r_num=0;
			$cant_num = intval($datosController['cantidad']);
			$r = Datos::getAvailabilityProductModel($_POST["id_producto"],"products");
			$r_num = intval($r);
			if($_POST['t']=='out'){			
				if(($r_num-$cant_num)<0){
					$flag=true;
				}else{
					$cant_num=$cant_num*-1;
				}
			}else{
				$flag=false;
			}
			if(!$flag){
				$respuesta = Datos::detallesMovimientoProductoModel($datosController, "historial");
				$total = $cant_num+$r_num;
				
				Datos::updateProductUnitsModel($_POST["id_producto"],$total, "products");
			}else{
				echo"<script>swal('Error', 'No se pudo realizar la operacion debido a que no hay suficientes productos en el inventario', 'success');</script>";
			}
		}
	}

	#Vista de Producto
	#------------------------------------
	#Movimientos para el historial de productos
	public function vistaProductoDetallesController(){
		$id=$_GET['id'];

		$respuesta = Datos::vistaProductoDetallesModel($id,"products");
		echo'
		<div class="container">
		  <div class="row">
		    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		    	<br>
		    	<img src="views/dist/img/stock.png" height="200" width="250">
		    </div>
		    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		    	<div class="card-body">
		    		<div class="d-inline-block">
			    		<p style=" font-size: 25px;"><strong><i class="fa fa-pencil mr-1"></i>Nombre:  </strong>'.$respuesta['nombre_producto'].'</p>
			    		<hr>
	                	<p><strong><i class="fa fa-map-marker mr-1"></i>Codigo:  </strong>'.$respuesta["codigo_producto"].'</p>
		                <hr>
		                <p> <strong><i class="fa fa-book mr-1"></i> Id:  </strong>'.$respuesta["id_producto"].'</p>
	                	<hr>
		                <p><strong><i class="fa fa-file-text-o mr-1"></i> Precio:  </strong>'.$respuesta['precio_producto'].'</p>
	 					<hr>
		                <p style="font-size: 20px; color: green;"><strong><i class="fa fa-file-text-o mr-1"></i> Stock Disponible:  </strong>'.$respuesta['stock'].'</p>
		            </div>
	            </div>
		    </div>
		    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		   	 	<form method="post" id="form_id">
			    	<div class="card-body">
			    		<input type="hidden" value="'.$respuesta["id_producto"].'" name="id_producto">
			    		<input type="hidden" name="t" id="t">
				    	<label for="nombre">Referencia:</label>
					 	<input class="form-control" type="text" name="referencia" id="referencia" required>
					 	<label for="nombre">Unidades:</label>
					 	<input class="form-control" type="number" name="unidades" id="unidades" required>
					</div>
					<div style="padding-left:45px;" class="d-inline-block">
						<input type="image" onClick="tipo(\'in\');" src="views/dist/img/stock-in.png" height="190" width="200"/>
						<input type="image" onClick="tipo(\'out\');" src="views/dist/img/stock-out.png" height="186" width="200"/>
						
					</div>
				</form>
		    </div>
		  </div>
		</div>';

		$respuesta = Datos::vistaHistorialProductModel("historial",$id);

		echo'<div class="card-body">
		
		<table id="table" width="100%" border="0">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Nota</th>
					<th>Referencia</th>
					<th>Cantidad</th>
				</tr>
			</thead>
			<tbody>
		';

		foreach($respuesta as $row => $item){
			echo'
				<tr>
					<td>'.$item["fecha"].'</td>
					<td>'.$item["nota"].'</td>
					<td>'.$item["referencia"].'</td>
					<td>'.$item["cantidad"].'</td>
				</tr>';		
		}
		echo'
			</tbody>
		</table>
		</div>';

		echo'
		<script>
			$(document).ready(function() {
			    $("#table").DataTable( {
			        "order": [[ 0, "desc" ]]
			    } );
			} );
			function checkNSub() {
			    var myForm = document.getElementById("form_id");
			    if(document.getElementById("referencia").value!="" && document.getElementById("unidades").value!=""  )
			   		myForm.submit();
			   	else
			   		swal("Error", "Ingrese todos los campos", "error");
			   		
			}

			function tipo(t) {
			    if (t=="in") {
			        document.getElementById("t").value = "in";
			        checkNSub();
			    } else if(t=="out") {
			        document.getElementById("t").value = "out";
			        checkNSub();
			    }
			    return true;
			}
	    </script>';
	}

	#Vista de productos controlador
	#------------------------------------
	#Controla el procedimiento de los productos
	public function vistaProductoController(){
	
		$respuesta = Datos::vistaProductoModel("products",$_SESSION['id_tienda']);

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["codigo_producto"].'</td>
				<td>'.$item["nombre_producto"].'</td>
				<td>'.$item["date_added"].'</td>
				<td>'.$item["nombre_categoria"].'</td>
				<td>'.$item["precio_producto"].'</td>
				<td>'.$item["stock"].'</td>
				<td><a href="index.php?action=editar_producto&id='.$item["id_producto"].'"><button class="btn btn-block btn-warning">Editar</button></a></td>
				<td><button onclick="wait();" class="btn btn-block btn btn-danger">Borrar</button></a></td>
				<td><a href="index.php?action=producto_detalles&id='.$item["id_producto"].'"><button class="btn btn-block btn btn-primary">Detalles</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        var pass="'.$_SESSION['user_p'].'";
		        function wait(){
		        	swal("Ingrese su contraseña:", {
					  	content: {
						    element: "input",
						    attributes: {
						      placeholder: "Contraseña",
						      type: "password",
						    },
						 },
					})
					.then((value) => {
						if(value==pass){
					  		window.location.href = "./index.php?action=inventario&idBorrar='.$item["id_producto"].'";
					  	}else{
					  		swal("Contraseña Incorrecta Intente de nuevo", {});
					  	}
					});
		        }
		    </script>';
		}
	}

	#Vista de categorias
	#------------------------------------
	#CRUD de las categorias
	public function vistaCategoriaController(){

		$respuesta = Datos::vistaCategoriaModel("categorias");
		
		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["nombre_categoria"].'</td>
				<td>'.$item["descripcion_categoria"].'</td>
				<td>'.$item["date_added"].'</td>
				<td><a href="index.php?action=editar_categoria&id='.$item["id_categoria"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
				<td><button onClick="wait();" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
				var pass="'.$_SESSION['user_p'].'";
		        function wait(){
		        	swal("Ingrese su contraseña:", {
					  content: {
						    element: "input",
						    attributes: {
						      placeholder: "Contraseña",
						      type: "password",
						    },
						 },
					})
					.then((value) => {
						if(value==pass){
							swal({
							  title: "¿Esta seguro que desea eliminar esta categoria?",
							  text: "Al eliminar esta categoria tambien se eliminara todo producto que pertenezca a esta categoria y en el historial sera eliminado todo registro que tenga un producto con esta categoria",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							  if (willDelete) {
							    window.location.href = "./index.php?action=categorias&idBorrar='.$item["id_categoria"].'";
							  }
							});
					  		
					  	}else{
					  		swal("Contraseña Incorrecta Intente de nuevo", {});
					  	}
					});
		        }
		    </script>';
		}
	}
	

	public function vistaVentaController(){
		//Se checa si existe 'data' en post que corresponde a un array que se obtiene con todos los registros
		//de la venta posteriormente se realiza el guardado de la misma

		$respuesta_productos = Datos::obtenerProductosModel("products");


		$st_productos="";
		for($i=0;$i<sizeof($respuesta_productos);$i++)
			$st_productos=$st_productos."<option value='".$respuesta_productos[$i]['precio_producto']."'>".$respuesta_productos[$i]['id_producto']." - ".$respuesta_productos[$i]['nombre_producto']."</option>";

		$mydate=getdate(date("U"));
		echo ("$mydate[weekday], $mydate[month] $mydate[mday], $mydate[year]");
		
		echo('
			<thead>
	            <th>Producto</th>
	            <th>Cantidad</th>
	            <th></th>
	          </thead>
	          <tbody id="tab">
	            <tr>
	              <td>
	                <select id="sel_prod" class="form-control js-example-basic-multiple" name="sel_prod">
						  '.$st_productos.'
					 </select>
	              </td>
	              <td>
	                <input type="number" class="form-control" name="txt_cant" min="1" value="1" id="txt_cant">
	              </td>
	              <td style="width:50px;">
	                 <button class="form-control id="btn_nu" value="Click" onclick="add_row()">Agregar</button>
	              </td>
	            </tr>
	          </tbody>
	        </table>
	        <br><br>
	        <h4 >Informacion de la venta:</h4>
	        <table class="form-control " style="border: none; ">
	          <thead>
		            <tr>
		              <th id="txt_total" >Total: 0</th>
		              <th style="width:250px;">
		                 <button class="form-control id="btn_terminar" style="height:60px" onclick="sendData();">Terminar Venta</button>
		              </th>
		            </tr>
	          </thead>
	        </table>
	       
	        <table id="table" class="form-control " style="border: none; width:100%">
	          <thead>
	            <tr>
	              <th>Id</th>
	              <th>Nombre</th>
	              <th>Cantidad</th>
	              <th>Valor Unitario</th>
	              <th>Importe</th>
	            </tr>
	          </thead>
	          <tbody id="tab_details">
	          
	          
	          </tbody>
	        </table>');

		echo('
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
			            $.post("views/modules/saving.php", {
			              data: details
			            }, function(data,status) {
			            	console.log(data);
			            });
			            alert("Venta realizada exitosamente");
			            //window.location.href = "views/modules/saving.php";
			          }
			        }
			      }

			      var doc = document.documentElement;
			      doc.setAttribute("data-useragent", navigator.userAgent);
    		</script>');
	}


	#Vista de tiendas
	#------------------------------------
	#CRUD de las tiendas, unicamente para superuser
	public function vistaTiendasController(){

		$respuesta = Datos::vistaTiendaModel("tienda");

		
		foreach($respuesta as $row => $item){
			$estado_tienda = $item["activa"]=="0"?"Desactivada":"Activa";
		echo'<tr>
				<td>'.$item["id_tienda"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$estado_tienda.'</td>
				<td><a href="index.php?action=editar_tienda&id='.$item["id_tienda"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
				<td><button onclick="wait('.$item["id_tienda"].');" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
				<td><a href="index.php?action=redirect&id='.$item["id_tienda"].'"><button class="btn btn-block btn-success btn-md">Ingresar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        var pass="'.$_SESSION['user_p'].'";
		         function wait(user_id){
		        	swal("Ingrese su contraseña:", {
					  content: {
						    element: "input",
						    attributes: {
						      placeholder: "Contraseña",
						      type: "password",
						    },
						 },
					})
					.then((value) => {
						if(value==pass){
							swal({
							  title: "¿Esta seguro que desea eliminar esta tienda?",
							  text: "Al eliminar esta tienda se eliminaran todos los registros(usuarios, productos, categorias) de la misma permanentemente.",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							 	if (willDelete) {
					  				window.location.href = "./index.php?action=tiendas&idBorrar="+user_id;
					  			}
					  		});
					  	}else{
					  		swal("Contraseña Incorrecta Intente de nuevo", {});
					  	}
					});
		        }
		    </script>';
		}
	}



	#Vista de usuarios
	#------------------------------------
	#CRUD de usuarios
	public function vistaUsuarioController(){

		$respuesta = Datos::vistaUsuarioModel("users",$_SESSION['id_tienda']);

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["user_id"].'</td>
				<td>'.$item["firstname"].'</td>
				<td>'.$item["lastname"].'</td>
				<td>'.$item["user_name"].'</td>
				<td>'.$item["user_email"].'</td>
				<td>'.$item["date_added"].'</td>
				<td><a href="index.php?action=editar_usuario&id='.$item["user_id"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
				<td><button onclick="wait('.$item["user_id"].');" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        var pass="'.$_SESSION['user_p'].'";
		         function wait(user_id){
		        	swal("Ingrese su contraseña:", {
					  content: {
						    element: "input",
						    attributes: {
						      placeholder: "Contraseña",
						      type: "password",
						    },
						 },
					})
					.then((value) => {
						if(value==pass){
							swal({
							  title: "¿Esta seguro que desea eliminar esta usuario?",
							  text: "Al eliminar esta usuario tambien se eliminara todo registro en el historial relacionado con este usuario",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							 	if (willDelete) {
					  				window.location.href = "./index.php?action=usuarios&idBorrar="+user_id;
					  			}
					  		});
					  	}else{
					  		swal("Contraseña Incorrecta Intente de nuevo", {});
					  	}
					});
		        }
		    </script>';
		}
	}


	#BORRAR USUARIOS
	#------------------------------------
	#Permite el eliminar algun usuario
	public function borrarUsuarioController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			
			if($datosController!=$_SESSION['user_id']){
				//$respuesta = Datos::BorrarColumnIdModel($datosController, "historial","user_id", $_SESSION['id_tienda']);
				$respuesta = Datos::borrarUsuarioModel($datosController, "users");
			
				if($respuesta == "success"){
					header("location:index.php?action=usuarios");
				}else{
					echo('<script> swal("Error", "El usuario no pudo ser eliminado", "error");</script>');
				}
			}else{
				echo('<script> swal("Error", "No puede eliminar el usuario con el que tiene abierta la sesion", "error");</script>');
			}
		}
	}

	#BORRAR TIENDAS
	#------------------------------------
	#Permite el eliminar determinada tienda mediante su id
	public function borrarTiendasController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarTiendaModel($datosController, "tienda");
		
			if($respuesta == "success"){
				header("location:index.php?action=tiendas");
			}else{
				echo('<script> swal("Error", "La tienda no pudo ser eliminada", "error");</script>');
			}
			
		}
	}

	#BORRAR PRODUCTO
	#------------------------------------
	#Permite el borrado de un producto
	public function borrarProductoController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarProductoModel($datosController, "products", $_SESSION['id_tienda']);
			
			if($respuesta == "success"){
				header("location:index.php?action=inventario");
			}else{
				echo('<script> swal("Error", "El producto no pudo ser eliminado", "error");</script>');
			}
		}
	}


	#BORRAR CATEGORIA
	#------------------------------------
	#Permite el borrado de una categoria
	public function borrarCategoriaController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			
			$respuesta = Datos::borrarCategoriaModel($datosController, "categorias");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=categorias");
			}else{
				echo('<script> swal("Error", "La categoria no pudo ser eliminada", "error");</script>');
			}
		}
	}

	#REGISTRO USUARIO
	#------------------------------------
	#Controla el registor de un usuario para hacer su incercion en la base de datos
	public function registroUsuarioController(){

		if(isset($_POST["firstname"])){
			$datosController = array(
								      "firstname"=>$_POST["firstname"],
								      "lastname"=>$_POST["lastname"],
								      "user_name"=>$_POST["user_name"],
								      "user_password_hash"=>md5($_POST["user_pass"]),
								      "user_email"=>$_POST["user_email"],
								      "date_added"=>date("Y-m-d H:i:s")
								  );

			
			$respuesta = Datos::registroUsuarioModel($datosController, "users");
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_usuario");
			}
			else{
				header("location:index.php");
			}
			
		}

	}

	#REGISTRO PRODUCTO
	#------------------------------------
	#Registro de producto en la base de datos
	public function registroProductoController(){

		if(isset($_POST["nombre_producto"])){
			$datosController = array(
								      "codigo_producto"=>$_POST["codigo_producto"],
								      "nombre_producto"=>$_POST["nombre_producto"],
								      "date_added"=>date("Y-m-d H:i:s"),
								      "precio_producto"=>$_POST["precio_producto"],
								      "stock"=>$_POST["stock"],
								      "id_categoria"=>$_POST["id_categoria"]
								  );

			$respuesta = Datos::registroProductoModel($datosController, "products");
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_producto");
			}
			else{
				header("location:index.php");
			}
			
		}

	}

	#REGISTRO CATEOGRIA
	#------------------------------------
	#Registro de categoria en la base de datos
	public function registroCategoriaController(){

		if(isset($_POST["nombre_categoria"])){
			$datosController = array(
								      "nombre_categoria"=>$_POST["nombre_categoria"],
								      "descripcion_categoria"=>$_POST["descripcion_categoria"],
								      "date_added"=>date("Y-m-d H:i:s")
								  );

			$respuesta = Datos::registroCategoriaModel($datosController, "categorias");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_categoria");
			}
			else{
				header("location:index.php");
			}
			
		}

	}
	

	#REGISTRO TIENDA
	#------------------------------------
	#Permite el registro de una tienda solo para superuser
	public function registroTiendaController(){

		if(isset($_POST["nombre"])){
			$datosController = array(
								      "nombre"=>$_POST["nombre"],
								      "activa"=>$_POST["activa"]
								  );

			$respuesta = Datos::registroTiendaModel($datosController, "tienda");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_tienda");
			}
			else{
				header("location:index.php");
			}
			
		}

	}

     
	#REGISTRO BASE PRODUCTO
	#------------------------------------
	#Interfaz base del registro de producto
	public function registroBaseProductoController(){
		$respuesta_categorias = Datos::obtenerCategoriasModel("categorias");

		$st_categorias="";
		for($i=0;$i<sizeof($respuesta_categorias);$i++)
			$st_categorias=$st_categorias."<option value='".$respuesta_categorias[$i]['id_categoria']."'>".$respuesta_categorias[$i]['nombre_categoria']."</option>";

		echo'<label for="nombre">Codigo Producto:</label>
			 <input class="form-control" type="text" id="codigo_producto" name="codigo_producto" required>
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre_producto" required>
			 <label for="nombre">Precio:</label>
			 <input class="form-control" type="text" name="precio_producto" required>
			 <label for="nombre">Stock:</label>
			 <input class="form-control" type="number" name="stock" required>
			 <label for="id_categoria">Categoria:</label>
			 
			 <select id="categorias" class="form-control js-example-basic-multiple" name="id_categoria">
				  '.$st_categorias.'
			 </select>

			 <br><br>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary float-right" onClick="wait()" value="Registrar">
			 </div>';
		echo"
			<script>
				var flag=true;
				$(document).ready(function() {
				    $('.js-example-basic-multiple').select2();
				});
				$('#codigo_producto').focusout(function () {
    				$.post('views/modules/editar_producto.php',
			        {
			          codigo_a_verificar: $('#codigo_producto').val(),
			        },
			        function(data,status){
			        	console.log(data);
			        	if(data==1){
			        		$('#codigo_producto').css('border-color','#ff0300');
			        		flag=false;
			        	}
			        	else{
			        		$('#codigo_producto').css('border-color','#bab8b8');
			        		flag=true;
			        	}
			        });
				});

				function wait(){
		         
		          	if (!flag) {
		          		event.preventDefault();
				        swal({
							title: 'No se ha podido registrar el producto',
							text: 'El codigo de producto ingresado ya esta registrado, por favor utilice otro codigo',
							icon: 'warning',
							buttons: true,
						});
					}
		        }
			</script>";

	}

	#REGISTRO BASE CATEGORIA
	#------------------------------------
	#Interfaz base del registro de categorias
	public function registroBaseCategoriaController(){
		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre_categoria" required>
			 <label for="nombre">Descripcion:</label>
			 <input class="form-control" type="text" name="descripcion_categoria" required>
			 <br>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary float-right" value="Registrar">
			 </div>';

	}


	#REGISTRO BASE TIENDA
	#------------------------------------
	#Interfaz base del registro de una tienda
	public function registroBaseTiendaController(){
		echo'<input type="hidden" value="" name="id_tienda">
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" value="" name="nombre" required>

			 <label for="descripcion">Activa:</label>
			 <div class="row-fluid">
			 	<label class="radio-inline">
			  		<input class="d-inline form-control" type="radio" name="activa" value="1" checked> <span>Activada</span>
			  	</label>
			  	<label class="radio-inline">
  			 		<input class="d-inline form-control" type="radio" name="activa" value="0" > Desactivado<br>
  			 	</label>
			</div>
			 
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary float-right" value="Registrar">
			 </div>';

	}


	#REGISTRO BASE USUARIO
	#------------------------------------
	#Interfaz base del registro de un usuario
	public function registroBaseUsuarioController(){
		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="firstname" required>
			 <label for="apellido">Apellido:</label>
			 <input class="form-control" type="text" name="lastname" required>
			 <label for="user_name">Usuario:</label>
			 <input class="form-control" type="text" name="user_name" required>
			 <label for="email">Email:</label>
			 <input class="form-control" type="email" name="user_email" required>
			 <label for="email">Password:</label>
			 <input class="form-control" type="password" name="user_pass" required>
			 <br>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary float-right" value="Registrar">
			 </div>';

	}


	#EDITAR CATEGORIAS
	#------------------------------------
	#Permite la edicion de categorias
	public function editarCategoriaController(){
		$datosController = $_GET["id"];
		$respuesta = Datos::editarCategoriaModel($datosController, "categorias");

		echo'<input type="hidden" value="'.$respuesta["id_categoria"].'" name="id_categoria">
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" value="'.$respuesta["nombre_categoria"].'" name="nombre_categoria" required>
			 <label for="descripcion">Descripcion:</label>
			 <input class="form-control" type="text" value="'.$respuesta["descripcion_categoria"].'" name="descripcion_categoria" required>
			 <br>
			 <div class="card-footer">
			 	<input type="submit" onclick="wait();" class="btn btn-primary float-right" value="Actualizar">
			 </div>';

		echo'
		<script>
			var pass="'.$_SESSION['user_p'].'";
			function wait(){
				event.preventDefault();
				swal("Ingrese su contraseña:", {
					  content: {
						    element: "input",
						    attributes: {
						      placeholder: "Contraseña",
						      type: "password",
						    },
						 },
					})
					.then((value) => {
						if(value==pass){
							swal({
							  title: "¿Esta seguro que desea modificar esta categoria?",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							  if (willDelete) {
							  	document.getElementById("cat").submit();
							    
							  }
							});
					  	}else{
					  		swal("Contraseña Incorrecta Intente de nuevo", {});
					  	}
					});
			}
		</script>';
	}


	#EDITAR TIENDAS
	#------------------------------------
	#Permite la edicion de tiendas
	public function editarTiendaController(){
		$datosController = $_GET["id"];
		$respuesta = Datos::editarTiendaModel($datosController, "tienda");
		$checked_activado="";
		$checked_desactivado="";

		if($respuesta["activa"]=="1")
			$checked_activado="checked";
		else if($respuesta["activa"]=="0")
			$checked_desactivado="checked";

		echo'<input type="hidden" value="'.$respuesta["id_tienda"].'" name="id_tienda">
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" value="'.$respuesta["nombre"].'" name="nombre" required>

			 <label for="descripcion">Activa:</label>
			 <div class="row-fluid">
			 	<label class="radio-inline">
			  		<input class="d-inline form-control" type="radio" name="activa" value="1" '.$checked_activado.'> <span>Activada</span>
			  	</label>
			  	<label class="radio-inline">
  			 		<input class="d-inline form-control" type="radio" name="activa" value="0" '.$checked_desactivado.'> Desactivado<br>
  			 	</label>
			</div>
			 
			 <br>
			 <div class="card-footer">
			 	<input type="submit" onClick="wait();" class="btn btn-primary float-right" value="Actualizar">
			 </div>';
	echo'
		<script>
			var pass="'.$_SESSION['user_p'].'";
			function wait(){
				event.preventDefault();
				swal("Ingrese su contraseña:", {
					  content: {
						    element: "input",
						    attributes: {
						      placeholder: "Contraseña",
						      type: "password",
						    },
						 },
					})
					.then((value) => {
						if(value==pass){
							swal({
							  title: "¿Esta seguro que desea modificar esta tienda?",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							  if (willDelete) {
							  	document.getElementById("cat").submit();
							  }
							});
					  	}else{
					  		swal("Contraseña Incorrecta Intente de nuevo", {});
					  	}
					});
			}
		</script>';
	}

	#ACTUALIZAR TIENDA
	#------------------------------------
	#Modificacion de tienda
	public function actualizarTiendaController(){
		
		if(isset($_POST["id_tienda"])){
			$datosController = array( "id_tienda"=>$_POST["id_tienda"],
							          "nombre"=>$_POST["nombre"],
							          "activa"=>$_POST["activa"]
									);
			var_dump($datosController);
			$respuesta = Datos::actualizarTiendaModel($datosController, "tienda");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_tienda");
			}
			else{
				echo "error";
			}
		}
	}



	#ACTUALIZAR TIENDA
	#------------------------------------
	#Modificacion de tienda
	public function insertSale($d){
		
		$fecha=date("Y-m-d H:i:s");

		$total=0;
		for($i=0;$i<count($d);$i++){
			$total=$total+$d[$i][4];
		}

		$datosController = array( "fecha"=>$fecha,
						          "total"=>$total
									);
		
		$respuesta = Datos::insertarVenta($datosController, "venta");

		$respuesta_id = Datos::getLastId("venta");

		$id=$respuesta_id['id'];;

		for($i=0;$i<count($d);$i++){
			$datosController = array( "id_producto"=>$d[$i][0],
						          	  "id_venta"=>$id,
						          	  "cantidad"=>$d[$i][2],
						          	  "importe"=>$d[$i][4]
									);

			$respuesta = Datos::insertarProductosDeVenta($datosController, "venta_producto");
		}

		if(isset($_POST["id_tienda"])){
			$datosController = array( "id_tienda"=>$_POST["id_tienda"],
							          "nombre"=>$_POST["nombre"],
							          "activa"=>$_POST["activa"]
									);
			var_dump($datosController);
			$respuesta = Datos::actualizarTiendaModel($datosController, "tienda");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_tienda");
			}
			else{
				echo "error";
			}
		}
	}

	#ACTUALIZAR CATEGORIA
	#------------------------------------
	#Actualizacion de categorias
	public function actualizarCategoriaController(){
		if(isset($_POST["id_categoria"])){
			$datosController = array( "id_categoria"=>$_POST["id_categoria"],
							          "nombre_categoria"=>$_POST["nombre_categoria"],
							          "descripcion_categoria"=>$_POST["descripcion_categoria"]
									);
			$respuesta = Datos::actualizarCategoriaModel($datosController, "categorias");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_categoria");
			}
			else{
				echo "error";
			}
		}
	}

	#EDITAR PRODUCTO
	#------------------------------------
	#Permite la edicicion de producto
	public function editarProductoController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarProductoModel($datosController, "products", $_SESSION['id_tienda']);

		$respuesta_categorias = Datos::obtenerCategoriasModel("categorias",$_SESSION['id_tienda']);

		$st_categorias="";
		for($i=0;$i<sizeof($respuesta_categorias);$i++)
			$st_categorias=$st_categorias."<option value='".$respuesta_categorias[$i]['id_categoria']."'>".$respuesta_categorias[$i]['nombre_categoria']."</option>";

		echo'
			 <input type="hidden" value="'.$respuesta["id_producto"].'" name="id_producto">
			 <label for="nombre">Codigo Producto:</label>
			 <input class="form-control" type="text" name="codigo_producto" id="codigo_producto" value="'.$respuesta["codigo_producto"].'" required>
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre_producto" value="'.$respuesta["nombre_producto"].'" required>
			 <label for="nombre">Precio:</label>
			 <input class="form-control" type="number" name="precio_producto" value="'.$respuesta["precio_producto"].'" required>
			 <label for="nombre">Stock:</label>
			 <input class="form-control" type="number" name="stock" value="'.$respuesta["stock"].'" required>
			 <label for="id_categoria">Categoria:</label>
			 
			 <select id="categorias" class="form-control js-example-basic-multiple" name="id_categoria">
				  '.$st_categorias.'
			 </select>
			 <br><br>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary float-right" onClick="wait();" value="Actualizar">
			 </div>';
		echo"
			<script>
				var flag=true;
				var cod_actual='".$respuesta["codigo_producto"]."';
				$(document).ready(function() {
				    $('.js-example-basic-multiple').select2();
				});
				$('#categorias').val(".$respuesta['id_categoria'].");

				$('#codigo_producto').focusout(function () {
					if($('#codigo_producto').val()!=cod_actual){
	    				$.post('views/modules/editar_producto.php',
				        {
				          codigo_a_verificar: $('#codigo_producto').val(),
				        },
				        function(data,status){
				        	console.log(data);
				        	if(data==1){
				        		$('#codigo_producto').css('border-color','#ff0300');
				        		flag=false;
				        	}
				        	else{
				        		$('#codigo_producto').css('border-color','#bab8b8');
				        		flag=true;
				        	}
				        });
			        }else{
			        	$('#codigo_producto').css('border-color','#bab8b8');
		        		flag=true;
			        }
				});


				function wait(){	
		          	if (!flag) {
		          		event.preventDefault();
				        swal({
							title: 'No se ha podido actualizar el producto',
							text: 'El codigo de producto ingresado ya esta registrado, por favor utilice otro codigo',
							icon: 'warning',
							buttons: true,
						});
					}
		        }
			</script>";


	}

	#EDITAR USUARIO
	#------------------------------------
	#Permite la edicion de usuarios
	public function editarUsuarioController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarUsuarioModel($datosController, "users");

		echo'<input type="hidden" value="'.$respuesta["user_id"].'" name="user_id">
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="firstname" value="'.$respuesta["firstname"].'" required>
			 <label for="apellido">Apellido:</label>
			 <input class="form-control" type="text" name="lastname" value="'.$respuesta["lastname"].'" required>
			 <label for="user_name">Usuario:</label>
			 <input class="form-control" type="text" name="user_name" value="'.$respuesta["user_name"].'" required>
			 <label for="email">Email:</label>
			 <input class="form-control" type="email" name="user_email" value="'.$respuesta["user_email"].'" required>
			 <label for="email">Password:</label>
			 <input class="form-control" type="password" name="user_pass" required>
			 <br>
			 <div class="card-footer">
			 	<input type="submit" onClick="wait();" class="btn btn-primary float-right" value="Actualizar">
			 </div>';
		echo'
		<script>
			var pass="'.$_SESSION['user_p'].'";
			function wait(){
				event.preventDefault();
				swal("Ingrese su contraseña:", {
					  content: {
						    element: "input",
						    attributes: {
						      placeholder: "Contraseña",
						      type: "password",
						    },
						 },
					})
					.then((value) => {
						if(value==pass){
							swal({
							  title: "¿Esta seguro que desea modificar esta usuario?",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							  if (willDelete) {
							  	document.getElementById("cat").submit();
							  }
							});
					  	}else{
					  		swal("Contraseña Incorrecta Intente de nuevo", {});
					  	}
					});
			}
		</script>';
	}

	#ACTUALIZAR USUARIO
	#------------------------------------
	#Permite actualizar su usuario.
	public function actualizarUsuarioController(){
		if(isset($_POST["user_id"])){
			$datosController = array( "user_id"=>$_POST["user_id"],
							          "firstname"=>$_POST["firstname"],
							          "lastname"=>$_POST["lastname"],
							          "user_name"=>$_POST["user_name"],
							          "user_email"=>$_POST["user_email"],
							          "user_password_hash"=>md5($_POST["user_pass"])
									);
			$respuesta = Datos::actualizarUsuarioModel($datosController, "users");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_usuario");
			}
			else{
				echo "error";
			}
		}
	}

	#REVISAR DISPONIBILIDAD DE DETERMINAOD CODIGO DE PRODUCTOS
	public function checkAvailabilityOfProductCode($code){

		$respuesta = Datos::checkAvailabilityOfProductCodeModel($code);
		
		
		echo($respuesta['a']);
		
	}

	#ACTUALIZAR PRODUCTO
	#------------------------------------
	#Actualizacion de producto
	public function actualizarProductoController(){
		if(isset($_POST["id_producto"])){
			$datosController = array( "id_producto"=>$_POST["id_producto"],
							          "codigo_producto"=>$_POST["codigo_producto"],
							          "precio_producto"=>$_POST["precio_producto"],
							          "nombre_producto"=>$_POST["nombre_producto"],
							          "stock"=>$_POST["stock"],
							          "id_categoria"=>$_POST["id_categoria"]
										);
			$respuesta = Datos::actualizarProductoModel($datosController, "products", $_SESSION['id_tienda']);
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_producto");
			}
			else{
				echo "error";
			}
		}
	}
}

?>