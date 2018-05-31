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
			
			if($respuesta["user_name"] == $_POST["user"] && $respuesta["user_password_hash"] == $_POST["pass"]){
				session_start();
				$_SESSION["validar"] = true;

				header("location:index.php?action=productos");
			}
			else{
				header("location:index.php?action=fallo");
			}
		}
	}




	#Vista de inventario
	#------------------------------------
	public function vistaInventarioController(){

		$respuesta = Datos::vistaProductoModel("products");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["codigo_producto"].'</td>
				<td>'.$item["nombre_producto"].'</td>
				<td>'.$item["date_added"].'</td>
				<td>'.$item["precio_producto"].'</td>
				<td>'.$item["stock"].'</td>
				<td><a href="index.php?action=editar_producto&id='.$item["id"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=productos&idBorrar='.$item["id"].'"><button onclick="wait();" class="small alert">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        function wait(){
		          var r = confirm("¿Desea eliminar el producto?");
		          if (!r) 
		              event.preventDefault();
		        }
		    </script>';
		}
	}

	#Vista de inventario
	#------------------------------------
	public function vistaProductoController(){

		$respuesta = Datos::vistaProductoModel("categorias");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["codigo_producto"].'</td>
				<td>'.$item["nombre_producto"].'</td>
				<td>'.$item["date_added"].'</td>
				<td>'.$item["categoria"].'</td>
				<td>'.$item["precio_producto"].'</td>
				<td>'.$item["stock"].'</td>
				<td><a href="index.php?action=editar_categoria&id='.$item["id"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=categoria&idBorrar='.$item["id"].'"><button onclick="wait();" class="small alert">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        function wait(){
		          var r = confirm("¿Desea eliminar el producto?");
		          if (!r) 
		              event.preventDefault();
		        }
		    </script>';
		}
	}

	#Vista de inventario
	#------------------------------------
	public function vistaCategoriaController(){

		$respuesta = Datos::vistaProductoModel("categorias");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["nombre_categoria"].'</td>
				<td>'.$item["descripcion_categoria"].'</td>
				<td>'.$item["date_added"].'</td>
				<td><a href="index.php?action=editar_categoria&id='.$item["id"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=categoria&idBorrar='.$item["id"].'"><button onclick="wait();" class="small alert">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        function wait(){
		          var r = confirm("¿Desea eliminar el producto?");
		          if (!r) 
		              event.preventDefault();
		        }
		    </script>';
		}
	}
	



	#BORRAR PRODUCTO
	#------------------------------------
	public function borrarProductoController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarProductoModel($datosController, "producto");
			
			if($respuesta == "success"){
				header("location:index.php?action=productos");
			}else{
				echo('<script> alert("El producto no pudo ser eliminado</script>');
			}
		}
	}


	#BORRAR PRODUCTO
	#------------------------------------
	public function borrarCategoriaController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarProductoModel($datosController, "producto");
			
			if($respuesta == "success"){
				header("location:index.php?action=productos");
			}else{
				echo('<script> alert("El producto no pudo ser eliminado</script>');
			}
		}
	}



	#REGISTRO PRODUCTO
	#------------------------------------
	public function registroUsuarioController(){

		if(isset($_POST["nombre"])){
			$datosController = array(
								      "nombre"=>$_POST["nombre"],
								      "descripcion"=>$_POST["descripcion"]
								  );

			$respuesta = Datos::registroProductoModel($datosController, "producto");
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_producto");
			}
			else{
				header("location:index.php");
			}
			
		}

	}

	#REGISTRO PRODUCTO
	#------------------------------------
	public function registroProductoController(){

		if(isset($_POST["nombre"])){
			$datosController = array(
								      "nombre"=>$_POST["nombre"],
								      "descripcion"=>$_POST["descripcion"]
								  );

			$respuesta = Datos::registroProductoModel($datosController, "producto");
			
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

		if(isset($_POST["nombre"])){
			$datosController = array(
								      "nombre"=>$_POST["nombre"],
								      "descripcion"=>$_POST["descripcion"]
								  );

			$respuesta = Datos::registroProductoModel($datosController, "producto");
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_producto");
			}
			else{
				header("location:index.php");
			}
			
		}

	}


                    
	#REGISTRO BASE PRODUCTO
	#------------------------------------
	public function registroBaseProductoController(){
		echo'<label for="nombre">Codigo Producto:</label>
			 <input class="form-control" type="text" name="codigo_producto" required>
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" required>
			 <label for="nombre">Categoria:</label>
			 <input class="form-control" type="text" name="categoria" required>
			 <label for="nombre">Precio:</label>
			 <input class="form-control" type="text" name="precio" required>
			 <label for="nombre">Stock:</label>
			 <input class="form-control" type="number" name="stock" required>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Registrar">
			 </div>';

	}

		#REGISTRO BASE CATEGORIA
	#------------------------------------
	public function registroBaseCategoriaController(){
		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" required>
			 <label for="nombre">Descripcion:</label>
			 <input class="form-control" type="text" name="descripcion" required>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Registrar">
			 </div>';

	}

		#------------------------------------
	public function registroBaseUsuarioController(){
		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" required>
			 <label for="apellido">Apellido:</label>
			 <input class="form-control" type="text" name="apellido" required>
			 <label for="user_name">Usuario:</label>
			 <input class="form-control" type="text" name="user_name" required>
			 <label for="email">Email:</label>
			 <input class="form-control" type="email" name="email" required>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary" value="Registrar">
			 </div>';

	}


		#REGISTRO BASE PRODUCTO
	#------------------------------------
	public function registroUsuarioProductoController(){
		echo'<label for="nombre">Nombreo:</label>
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



	#EDITAR PRODUCTO
	#------------------------------------
	public function editarProductoController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarProductoModel($datosController, "producto");

		echo'<input type="hidden" value="'.$respuesta["id"].'" name="id">
			 <label for="nombre">Nombre:</label>
			 <input type="text" value="'.$respuesta["nombre"].'" name="nombre" required>
			 <label for="descripcion">Descripcion:</label>
			 <input type="text" value="'.$respuesta["descripcion"].'" name="descripcion" required>
			 <input type="submit" value="Actualizar">';
	}


	#ACTUALIZAR PRODUCTO
	#------------------------------------
	public function actualizarProductoController(){
		if(isset($_POST["id"])){
			$datosController = array( "id"=>$_POST["id"],
							          "nombre"=>$_POST["nombre"],
							          "descripcion"=>$_POST["descripcion"]
										);
			$respuesta = Datos::actualizarProductoModel($datosController, "producto");
			

			if($respuesta == "success"){
				header("location:index.php?action=cambio_producto");
			}
			else{
				echo "error";
			}
		}
	}






}






////
?>