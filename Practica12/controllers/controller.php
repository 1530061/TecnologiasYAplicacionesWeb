<?php

class MvcController{

	#LLAMADA A LA PLANTILLA
	#-------------------------------------
	#Permite la llamada al template de la pagina
	public function pagina($t=0){
		
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

	############################################################### USUARIOS #########################################################


	#Ingreso de USUARIOS
	#------------------------------------
	public function ingresoUsuarioController(){

		if(isset($_POST["user"])){
			$datosController = array( "user_name"=>$_POST["user"], 
								      "pass"=>$_POST["pass"]);
			$respuesta = Datos::ingresoUsuarioModel($datosController, "users");
			
			if($respuesta["user_name"] == $_POST["user"] && $respuesta["user_password_hash"] == md5($_POST["pass"])){
				session_start();
				$_SESSION["validar"] = true;
				$_SESSION["user_p"] = $_POST["pass"];
				$_SESSION["user_id"] = $respuesta["user_id"];
				$_SESSION["firstname"] = $respuesta["firstname"];
				header("location:index.php?action=productos");
			}
			else{
				header("location:index.php?action=fallo");
			}
		}
	}

	#Obtiene los valores de determinado campo para el dashboard
	#------------------------------------
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


	#Vista de inventario
	#------------------------------------
	public function vistaInventarioController(){

		$respuesta = Datos::vistaInventarioModel("products");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["codigo_producto"].'</td>
				<td>'.$item["nombre_producto"].'</td>
				<td>'.$item["date_added"].'</td>
				<td>'.$item["precio_producto"].'</td>
				<td>'.$item["stock"].'</td>
				<td><a href="index.php?action=editar_producto&id='.$item["id"].'"><button class="btn btn-block btn-warning">Editar</button></a></td>
				<td><a href="index.php?action=productos&idBorrar='.$item["id"].'"><button onclick="wait();" class="btn btn-block btn-danger">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        var pass="'.$_SESSION['user_p'].'";
		        function wait(){
		        	var c = prompt("Por favor ingrese su contraseña");
		        	if(c==pass){
			          	var r = confirm("¿Desea eliminar el producto?");
			          	if (!r) 
			              	event.preventDefault();
		            }else{
		            	event.preventDefault();
		            }
		        }
		    </script>';
		}
	}

	#Vista de productos
	#------------------------------------
	public function productoDetallesController(){
		if(isset($_POST['t'])){
			$datosController = array( 	
									"id_producto"=>$_POST["id_producto"], 
									"user_id"=>$_SESSION["user_id"], 
									"fecha"=>date("Y-m-d H:i:s"), 
									"nota"=>"El usuario ".$_SESSION["firstname"]." agrego ".$_POST['unidades']." producto(s) al inventario.",
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
				//var_dump($total);
				Datos::updateProductUnitsModel($_POST["id_producto"],$total, "products");
			}else{
				echo"<script>alert('No se pudo realizar la operacion debido a que no hay suficientes productos en el inventario');</script>";
			}
		}
	}

	#Vista de Producto
	#------------------------------------
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
			   		alert("ingrese todos los campos");
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

	#Vista de productos
	#------------------------------------
	public function vistaProductoController(){

		$respuesta = Datos::vistaProductoModel("products");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["codigo_producto"].'</td>
				<td>'.$item["nombre_producto"].'</td>
				<td>'.$item["date_added"].'</td>
				<td>'.$item["nombre_categoria"].'</td>
				<td>'.$item["precio_producto"].'</td>
				<td>'.$item["stock"].'</td>
				<td><a href="index.php?action=editar_producto&id='.$item["id_producto"].'"><button class="btn btn-block btn-warning">Editar</button></a></td>
				<td><a href="index.php?action=inventario&idBorrar='.$item["id_producto"].'"><button onclick="wait();" class="btn btn-block btn btn-danger">Borrar</button></a></td>
				<td><a href="index.php?action=producto_detalles&id='.$item["id_producto"].'"><button class="btn btn-block btn btn-primary">Detalles</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        var pass="'.$_SESSION['user_p'].'";
		        function wait(){
		        	var c = prompt("Por favor ingrese su contraseña");
		        	if(c==pass){
			          	var r = confirm("¿Desea eliminar el producto?");
			          	if (!r) 
			              	event.preventDefault();
		            }else{
		            	event.preventDefault();
		            }
		        }
		    </script>';
		}
	}

	#Vista de categorias
	#------------------------------------
	public function vistaCategoriaController(){

		$respuesta = Datos::vistaCategoriaModel("categorias");
		
		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["nombre_categoria"].'</td>
				<td>'.$item["descripcion_categoria"].'</td>
				<td>'.$item["date_added"].'</td>
				<td><a href="index.php?action=editar_categoria&id='.$item["id_categoria"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
				<td><a href="index.php?action=categorias&idBorrar='.$item["id_categoria"].'"><button onClick="wait();" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
				var pass="'.$_SESSION['user_p'].'";
		        function wait(){
		        	var c = prompt("Por favor ingrese su contraseña");
		        	if(c==pass){
			          	var r = confirm("¿Desea eliminar el producto?");
			          	if (!r) 
			              	event.preventDefault();
		            }else{
		            	event.preventDefault();
		            }
		        }
		    </script>';
		}
	}
	
	#Vista de usuarios
	#------------------------------------
	public function vistaUsuarioController(){

		$respuesta = Datos::vistaUsuarioModel("users");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["user_id"].'</td>
				<td>'.$item["firstname"].'</td>
				<td>'.$item["lastname"].'</td>
				<td>'.$item["user_name"].'</td>
				<td>'.$item["user_email"].'</td>
				<td>'.$item["date_added"].'</td>
				<td><a href="index.php?action=editar_usuario&id='.$item["user_id"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
				<td><a href="index.php?action=usuarios&idBorrar='.$item["user_id"].'"><button onclick="wait();" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        var pass="'.$_SESSION['user_p'].'";
		        function wait(){
		        	var c = prompt("Por favor ingrese su contraseña");
		        	if(c==pass){
			          	var r = confirm("¿Desea eliminar el producto?");
			          	if (!r) 
			              	event.preventDefault();
		            }else{
		            	event.preventDefault();
		            }
		        }
		    </script>';
		}
	}


	#BORRAR USUARIOS
	#------------------------------------
	public function borrarUsuarioController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];


			$respuesta = Datos::borrarUsuarioModel($datosController, "users");
			
			if($respuesta == "success"){
				header("location:index.php?action=usuarios");
			}else{
				echo('<script> alert("El usuario no pudo ser eliminado</script>');
			}
		}
	}

	#BORRAR PRODUCTO
	#------------------------------------
	public function borrarProductoController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarProductoModel($datosController, "products");
			
			if($respuesta == "success"){
				header("location:index.php?action=inventario");
			}else{
				echo('<script> alert("El producto no pudo ser eliminado</script>');
			}
		}
	}


	#BORRAR CATEGOIRIA
	#------------------------------------
	public function borrarCategoriaController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarProductsIdModel($datosController, "products");
			$respuesta = Datos::borrarCategoriaModel($datosController, "categorias");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=categorias");
			}else{
				echo('<script> alert("El producto no pudo ser eliminado</script>');
			}
		}
	}

	#REGISTRO USUARIO
	#------------------------------------
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
			var_dump($respuesta);
			
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
	public function registroCategoriaController(){

		if(isset($_POST["nombre_categoria"])){
			$datosController = array(
								      "nombre_categoria"=>$_POST["nombre_categoria"],
								      "descripcion_categoria"=>$_POST["descripcion_categoria"],
								      "date_added"=>date("Y-m-d H:i:s")
								  );

			$respuesta = Datos::registroCategoriaModel($datosController, "categorias");
			
			var_dump($respuesta);
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_categoria");
			}
			else{
				header("location:index.php");
			}
			
		}

	}

                    
	#REGISTRO BASE PRODUCTO
	#------------------------------------
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

			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" onClick="wait()" value="Registrar">
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
		          	alert('El codigo de producto que ingreso ya esta registrado para otro producto, por favor utilice otro');
		            event.preventDefault();
		          }
		        }
			</script>";

	}

	#REGISTRO BASE CATEGORIA
	#------------------------------------
	public function registroBaseCategoriaController(){
		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre_categoria" required>
			 <label for="nombre">Descripcion:</label>
			 <input class="form-control" type="text" name="descripcion_categoria" required>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Registrar">
			 </div>';

	}

	#REGISTRO BASE USUARIO
	#------------------------------------
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
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Registrar">
			 </div>';

	}


	#REGISTRO BASE DE USUARIO
	#------------------------------------
	public function registroUsuarioProductoController(){
		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" required>
			 <label for="nombre">Apellido:</label>
			 <input class="form-control" type="text" name="apellido" required>
			 <label for="nombre">Email:</label>
			 <input class="form-control" type="email" name="email" required>
			 <label for="nombre">Agregado:</label>
			 <input class="form-control" type="text" name="agregado" required>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Registrar">
			 </div>';

	}

	#EDITAR CATEGORIAS
	#------------------------------------
	public function editarCategoriaController(){
		$datosController = $_GET["id"];
		$respuesta = Datos::editarCategoriaModel($datosController, "categorias");

		echo'<input type="hidden" value="'.$respuesta["id_categoria"].'" name="id_categoria">
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" value="'.$respuesta["nombre_categoria"].'" name="nombre_categoria" required>
			 <label for="descripcion">Descripcion:</label>
			 <input class="form-control" type="text" value="'.$respuesta["descripcion_categoria"].'" name="descripcion_categoria" required>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Actualizar">
			 </div>';
	}

	#ACTUALIZAR CATEGORIA
	#------------------------------------
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
	public function editarProductoController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarProductoModel($datosController, "products");

		$respuesta_categorias = Datos::obtenerCategoriasModel("categorias");

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

			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" onClick="wait();" value="Registrar">
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
		          	alert('El codigo de producto que ingreso ya esta registrado para otro producto, por favor utilice otro');
		            event.preventDefault();
		          }
		        }
			</script>";


	}

	#EDITAR USUARIO
	#------------------------------------
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
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Registrar">
			 </div>';
	}

	#ACTUALIZAR USUARIO
	#------------------------------------
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
	public function actualizarProductoController(){
		if(isset($_POST["id_producto"])){
			$datosController = array( "id_producto"=>$_POST["id_producto"],
							          "codigo_producto"=>$_POST["codigo_producto"],
							          "precio_producto"=>$_POST["precio_producto"],
							          "nombre_producto"=>$_POST["nombre_producto"],
							          "stock"=>$_POST["stock"],
							          "id_categoria"=>$_POST["id_categoria"]
										);
			$respuesta = Datos::actualizarProductoModel($datosController, "products");
			
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