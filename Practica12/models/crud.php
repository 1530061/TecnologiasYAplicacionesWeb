<?php

#EXTENSIÓN DE CLASES: Los objetos pueden ser extendidos, y pueden heredar propiedades y métodos. Para definir una clase como extensión, debo definir una clase padre, y se utiliza dentro de una clase hija.

require_once "conexion.php";

//heredar la clase conexion de conexion.php para poder utilizar "Conexion" del archivo conexion.php.
// Se extiende cuando se requiere manipuar una funcion, en este caso se va a  manipular la función "conectar" del models/conexion.php:
class Datos extends Conexion{

	#INGRESO USUARIO
	#-------------------------------------
	#Obtiene el usuario, contrasena del usuario.
	public function ingresoUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT user_name, user_password_hash FROM $tabla WHERE user_name = :user_name");	
		$stmt->bindParam(":user_name", $datosModel["user_name"], PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();
		$stmt->close();
	}


		#VISTA CARRERA
	#-------------------------------------
	public function vistaProductoModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre, descripcion from $tabla");	
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();

	}
	

	#BORRAR PRODUCTO
	#------------------------------------
	public function borrarProductoInventarioModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_producto = :id_producto AND id_inventario =:id_inventario");
		$stmt->bindParam(":id_producto", $datosModel['idBorrar'], PDO::PARAM_INT);
		$stmt->bindParam(":id_inventario", $datosModel['id'], PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}



	#REGISTRO DE INVENTARIOS
	#-------------------------------------
	public function registroInventarioModel($datosModel, $tabla){

		$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre) VALUES (:nombre)");	

		$stmt1->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);

		if($stmt1->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt1->close();

	}

	#EDICION DE LA INVENTARIO  
	#-------------------------------------
	public function editarInventarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZACION DEL INVENTARIO
	#-------------------------------------
	public function actualizarInventarioModel($datosModel, $tabla){
		var_dump($datosModel);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre WHERE id = :id");

		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);

		var_dump($datosModel);
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}

	#BORRAR TODO SOBRE LA CARRERA
	#------------------------------------
	public function borrarProductoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}





	#REGISTRO DE CARRERAS 
	#-------------------------------------
	public function registroProductoModel($datosModel, $tabla){

		$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre,descripcion) VALUES (:nombre,:descripcion)");	
		
		$stmt1->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt1->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);
		
		if($stmt1->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt1->close();

	}


	#EDICION DEL PRODUCTO  
	#-------------------------------------
	public function editarProductoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre, descripcion FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}


	#ACTUALIZACION DEL PRODUCTO
	#-------------------------------------
	public function actualizarProductoModel($datosModel, $tabla){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, descripcion = :descripcion WHERE id = :id");

		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datosModel["descripcion"], PDO::PARAM_STR);

		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}



}

?>