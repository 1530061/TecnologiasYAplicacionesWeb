<?php

class MvcController{

	#LLAMADA A LA PLANTILLA
	#-------------------------------------

	public function pagina(){	
		
		include "views/template.php";
	
	}

	#ENLACES
	#-------------------------------------

	public function enlacesPaginasController(){

		if(isset( $_GET['action'])){
			
			$enlaces = $_GET['action'];
		
		}

		else{

			$enlaces = "index";
		}

		$respuesta = Paginas::enlacesPaginasModel($enlaces);

		include $respuesta;

	}






	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroUsuarioController(){

		if(isset($_POST["usuarioRegistro"])){
			//Recibe a traves del método POST el name (html) de usuario, password y email, se almacenan los datos en una variable de tipo array con sus respectivas propiedades (usuario, password y email):
			$datosController = array( "usuario"=>$_POST["usuarioRegistro"], 
								      "password"=>$_POST["passwordRegistro"],
								      "email"=>$_POST["emailRegistro"]);

			//Se le dice al modelo models/crud.php (Datos::registroUsuarioModel),que en la clase "Datos", la funcion "registroUsuarioModel" reciba en sus 2 parametros los valores "$datosController" y el nombre de la tabla a conectarnos la cual es "usuarios":
			$respuesta = Datos::registroUsuarioModel($datosController, "usuarios");

			//se imprime la respuesta en la vista 
			if($respuesta == "success"){

				header("location:index.php?action=ok");

			}

			else{

				header("location:index.php");
			}

		}

	}










	#INGRESO DE USUARIOS
	#------------------------------------
	public function ingresoUsuarioController(){

		if(isset($_POST["usuarioIngreso"])){

			$datosController = array( "usuario"=>$_POST["usuarioIngreso"], 
								      "password"=>$_POST["passwordIngreso"]);

			$respuesta = Datos::ingresoUsuarioModel($datosController, "usuarios");

			//Valiación de la respuesta del modelo para ver si es un usuario correcto.
			if($respuesta["usuario"] == $_POST["usuarioIngreso"] && $respuesta["password"] == $_POST["passwordIngreso"]){

				session_start();

				$_SESSION["validar"] = true;

				header("location:index.php?action=usuarios");

			}

			else{

				header("location:index.php?action=fallo");

			}

		}	

	}

	#VISTA DE USUARIOS
	#------------------------------------

	public function vistaUsuariosController(){

		$respuesta = Datos::vistaUsuariosModel("usuarios");

		#El constructor foreach proporciona un modo sencillo de iterar sobre arrays. foreach funciona sólo sobre arrays y objetos, y emitirá un error al intentar usarlo con una variable de un tipo diferente de datos o una variable no inicializada.

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["usuario"].'</td>
				<td>'.$item["password"].'</td>
				<td>'.$item["email"].'</td>
				<td><a href="index.php?action=editar&id='.$item["id"].'"><button>Editar</button></a></td>
				<td><a href="index.php?action=usuarios&idBorrar='.$item["id"].'"><button>Borrar</button></a></td>
			</tr>';

		}

	}

		#VISTA DE USUARIOS
	#------------------------------------

	public function vistaProductoController(){

		$respuesta = Datos::vistaProductoModel("products");

		#El constructor foreach proporciona un modo sencillo de iterar sobre arrays. foreach funciona sólo sobre arrays y objetos, y emitirá un error al intentar usarlo con una variable de un tipo diferente de datos o una variable no inicializada.

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["nombreProd"].'</td>
				<td>'.$item["descProduc"].'</td>
				<td>'.$item["BuyPrice"].'</td>
				<td>'.$item["SalePrice"].'</td>
				<td>'.$item["Proce"].'</td>
				<td><a href="index.php?action=editar_productos&id='.$item["id"].'"><button>Editar</button></a></td>
				<td><a href="index.php?action=productos&idBorrar='.$item["id"].'"><button>Borrar</button></a></td>
			</tr>';

		}

	}

	#EDITAR USUARIO
	#------------------------------------

	public function editarUsuarioController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarUsuarioModel($datosController, "usuarios");

		echo'<input type="hidden" value="'.$respuesta["id"].'" name="idEditar">

			 <input type="text" value="'.$respuesta["usuario"].'" name="usuarioEditar" required>

			 <input type="text" value="'.$respuesta["password"].'" name="passwordEditar" required>

			 <input type="email" value="'.$respuesta["email"].'" name="emailEditar" required>

			 <input type="submit" value="Actualizar">';

	}


	#ACTUALIZAR USUARIO
	#------------------------------------
	public function actualizarUsuarioController(){

		if(isset($_POST["usuarioEditar"])){

			$datosController = array( "id"=>$_POST["idEditar"],
							          "usuario"=>$_POST["usuarioEditar"],
				                      "password"=>$_POST["passwordEditar"],
				                      "email"=>$_POST["emailEditar"]);
			
			$respuesta = Datos::actualizarUsuarioModel($datosController, "usuarios");

			if($respuesta == "success"){

				header("location:index.php?action=cambio");

			}

			else{

				echo "error";

			}

		}
	
	}



	#BORRAR USUARIO
	#------------------------------------
	public function borrarUsuarioController(){

		if(isset($_GET["idBorrar"])){

			$datosController = $_GET["idBorrar"];
			
			$respuesta = Datos::borrarProductoModel($datosController, "products");

			if($respuesta == "success"){

				header("location:index.php?action=usuarios");
			
			}

		}

	}

	public function editarProductoController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarProductoModel($datosController, "products");

		echo'<input type="hidden" value="'.$respuesta["id"].'" name="idEditar">

			<input type="text" value="'.$respuesta["nombreProd"].'" name="nombreEditar">

			<input type="text" value="'.$respuesta["descProduc"].'" name="descEditar" required>

			<input type="number" value="'.$respuesta["BuyPrice"].'" name="buyPriceEditar" required>

			<input type="number" value="'.$respuesta["SalePrice"].'" name="salePriceEditar" required>

			<input type="number" value="'.$respuesta["Proce"].'" name="proceEditar" required>

			<input type="submit" value="Actualizar">';

	}

	#ACTUALIZAR PRODUCTO
	#------------------------------------
	public function actualizarProductoController(){


		if(isset($_POST["nombreEditar"])){

			$datosController = array( "id"=>$_POST["idEditar"],
									  "nombreProd"=>$_POST["nombreEditar"], 
								      "descProduc"=>$_POST["descEditar"],
								      "BuyPrice"=>$_POST["buyPriceEditar"],
								      "SalePrice"=>$_POST["salePriceEditar"],
								      "Proce"=>$_POST["proceEditar"]);
			var_dump($datosController);
			
			$respuesta = Datos::actualizarProductoModel($datosController, "products");

			if($respuesta == "success"){

				header("location:index.php?action=cambio_p");
			}

			else{

				echo "error";

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

				header("location:index.php?action=productos");
			
			}

		}

	}


		#REGISTRO DE PRODUCTOS
	#------------------------------------
	public function registroProductosController(){

		if(isset($_POST["nombreProd"])){
			//Recibe a traves del método POST el name (html) de producto, descripcion del producto, precio de compra, precio de venta y el precio, se almacenan los datos en una variable de tipo array con sus respectivas propiedades (usuario, password y email):
			$datosController = array( "nombreProd"=>$_POST["nombreProd"], 
								      "descProduc"=>$_POST["descProduc"],
								      "BuyPrice"=>$_POST["BuyPrice"],
								      "SalePrice"=>$_POST["SalePrice"],
								      "Proce"=>$_POST["Proce"]);

			//Se le dice al modelo models/crud.php (Datos::registroProductosModel),que en la clase "Datos", la funcion "registroProductosModel" reciba en sus 2 parametros los valores "$datosController" y el nombre de la tabla a conectarnos la cual es "products":
			$respuesta = Datos::registroProductosModel($datosController, "products");

			//se imprime la respuesta en la vista 
			if($respuesta == "success"){
				header("location:index.php?action=done");
			}
			else{
				header("location:index.php");
			}

		}

	}

}






////
?>