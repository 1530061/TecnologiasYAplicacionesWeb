<?php

class MvcController{

	#LLAMADA A LA PLANTILLA
	#-------------------------------------
	#Permite la llamada al template de la pagina
	public function pagina(){		
		include "views/template.php";
	}

	#NAVEGACION
	#-------------------------------------
	#Imprime el menu de navegacion correspondiente al nivel de privilegios que se tenga actualmente
	#(maestro/superusuario) donde en el caso de superusuario se muestran las opciones completamente.
	public function vistaNavegacionController(){
		echo'
			<li><a href="index.php?action=ingresar">Ingreso</a></li>
			<li><a href="index.php?action=inventarios">Inventarios</a></li>
			<li><a href="index.php?action=productos">Productos</a></li>
			<li><a href="index.php?action=salir">Salir</a></li>';
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
			$datosController = array( "user"=>$_POST["user"], 
								      "pass"=>$_POST["pass"]);

			$respuesta = Datos::ingresoUsuarioModel($datosController, "usuario");
			
			
			//Valiación de la respuesta del modelo para ver si es un usuario correcto.
			if($respuesta["user"] == $_POST["user"] && $respuesta["pass"] == $_POST["pass"]){
				session_start();
				$_SESSION["validar"] = true;

				header("location:index.php?action=inventarios");
			}
			else{
				header("location:index.php?action=fallo");
			}
		}
	}

	#Vista de inventario
	#------------------------------------
	public function vistaInventarioController(){

		$respuesta = Datos::vistaInventariosModel("inventario");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["nombre"].'</td>
				<td><a href="index.php?action=editar_inventario&id='.$item["id"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=productos_inventario&id='.$item["id"].'"><button class="small success">Agregar Productos</button></a></td>
				<td><a href="index.php?action=inventarios&idBorrar='.$item["id"].'"><button onclick="wait();" class="small alert">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        function wait(){
		          var r = confirm("¿Desea eliminar el inventario?");
		          if (!r) 
		              event.preventDefault();
		        }
		    </script>';
		}
	}

	#BORRAR INVENTARIO
	#------------------------------------
	public function borrarInventarioController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarInventarioModel($datosController, "inventario");
			
			if($respuesta == "success"){
				header("location:index.php?action=inventarios");
			}else{
				echo('<script> alert("El inventario no pudo ser eliminado."); </script>');
			}
		}
	}


	#VISTA DE PRODUCTOS EN INVENTARIO
	#------------------------------------
	public function vistaProductoInventarioController(){
		if(isset($_GET["id"])){
			$datosController = array("id"=>$_GET["id"]);

			$respuesta = Datos::vistaProductosInventarioModel($datosController,"inventario_producto");
			
			foreach($respuesta as $row => $item){
			echo'<tr>
					<td>'.$item["id_producto"].'</td>
					<td>'.$item["nombre"].'</td>
					<td>'.$item["cantidad"].'</td>
					<td><a href="index.php?action=editar_producto_inventario&id='.$item["id_producto"].'"><button class="small warning">Editar</button></a></td>
					<td><a href="index.php?action=productos&id='.$_GET["id"].'&idBorrar='.$item["id_producto"].'"><button class="small alert">Borrar</button></a></td>
				</tr>';
			}
		}
	}


	#REGISTRO DE BASE DE INVENTARIO
	#------------------------------------
	public function registroBaseInventarioController(){

		echo'<label for="nombre">Nombre:</label>
			 <input type="text" name="nombre" required>
			 <input type="submit" value="Registrar">';

	}


	#REGISTRO DE INVENTARIO
	#------------------------------------
	public function registroInventarioController(){

		if(isset($_POST["nombre"])){
			$datosController = array( "nombre"=>$_POST["nombre"]);

			$respuesta = Datos::registroInventarioModel($datosController, "inventario");

			if($respuesta == "success"){
				header("location:index.php?action=ok_inventario");
			}
			else{
				header("location:index.php");
			}
		}
	}


	#EDITAR INVENTARIO
	#------------------------------------
	public function editarInventarioController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarInventarioModel($datosController, "inventario");

		echo'<input type="hidden" value="'.$respuesta["id"].'" name="id">
			 <label for="nombre">Nombre:</label>
			 <input type="text" value="'.$respuesta["nombre"].'" name="nombre" required>
			 <input type="submit" value="Actualizar">';
	}


	#ACTUALIZAR INVENTARIO
	#------------------------------------
	public function actualizarInventarioController(){
		if(isset($_POST["id"])){
			$datosController = array( "id"=>$_POST["id"],
							          "nombre"=>$_POST["nombre"]
										);
			$respuesta = Datos::actualizarCarreraModel($datosController, "inventario");
			

			if($respuesta == "success"){
				header("location:index.php?action=cambio_carrera");
			}
			else{
				echo "error";
			}
		}
	}


	#Vista de producto
	#------------------------------------
	public function vistaProductoController(){

		$respuesta = Datos::vistaProductoModel("producto");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["descripcion"].'</td>
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

	#REGISTRO BASE PRODUCTO
	#------------------------------------
	public function registroBaseProductoController(){
		echo'<label for="nombre">Nombre:</label>
			 <input type="text" name="nombre" required>
			 <label for="nombre">Descripcion:</label>
			 <input type="text" name="descripcion" required>
			 <input type="submit" value="Registrar">';
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