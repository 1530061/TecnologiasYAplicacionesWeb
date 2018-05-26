<?php

#EXTENSIÓN DE CLASES: Los objetos pueden ser extendidos, y pueden heredar propiedades y métodos. Para definir una clase como extensión, debo definir una clase padre, y se utiliza dentro de una clase hija.

require_once "conexion.php";

//heredar la clase conexion de conexion.php para poder utilizar "Conexion" del archivo conexion.php.
// Se extiende cuando se requiere manipuar una funcion, en este caso se va a  manipular la función "conectar" del models/conexion.php:
class Datos extends Conexion{

	#INGRESO USUARIO
	#-------------------------------------
	public function ingresoMaestroModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT email, password, num_empleado FROM $tabla WHERE email = :email");	
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();
		$stmt->close();
	}

		#VISTA USUARIOS
	#-------------------------------------

	public function vistaMaestrosModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT m.num_empleado as num_empleado, m.nombre as nombre, m.email as email, c.nombre as nombre_carrera FROM $tabla as m inner join carrera as c on m.id_carrera=c.id");	
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();

	}

	public function editarMaestroModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT num_empleado, nombre, email, password, id_carrera FROM $tabla WHERE num_empleado = :num_empleado");
		$stmt->bindParam(":num_empleado", $datosModel, PDO::PARAM_INT);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	public function obtenerCarrerasModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla");
		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function obtenerTutoresModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT num_empleado, nombre FROM $tabla");
		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function actualizarMaestroModel($datosModel, $tabla){

		var_dump($datosModel);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, password = :password, id_carrera = :id_carrera WHERE num_empleado = :num_empleado");

		$stmt->bindParam(":num_empleado", $datosModel["num_empleado"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt->bindParam(":id_carrera", $datosModel["carrera"], PDO::PARAM_INT);
		$stmt->bindParam(":password", $datosModel["password"], PDO::PARAM_STR);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}

		#BORRAR USUARIO
	#------------------------------------
	public function borrarMaestroModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE num_empleado = :num_empleado");
		$stmt->bindParam(":num_empleado", $datosModel, PDO::PARAM_STR);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}

		#REGISTRO DE ALUMNOS
	#-------------------------------------
	public function registroMaestroModel($datosModel, $tabla){

		$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (num_empleado, nombre, email, password, id_carrera) VALUES (:num_empleado,:nombre,:email,:password,:id_carrera)");	
		
		$stmt1->bindParam(":num_empleado", $datosModel["num_empleado"], PDO::PARAM_STR);
		$stmt1->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt1->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt1->bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
		$stmt1->bindParam(":id_carrera", $datosModel["id_carrera"], PDO::PARAM_INT);
		

		if($stmt1->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt1->close();

	}



	####ALUMNOS


	#REGISTRO DE ALUMNOS
	#-------------------------------------
	public function registroAlumnoModel($datosModel, $tabla){

		$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (matricula, nombre, id_carrera, id_tutor) VALUES (:matricula,:nombre,:id_carrera,:id_tutor)");	
		
		$stmt1->bindParam(":matricula", $datosModel["matricula"], PDO::PARAM_STR);
		$stmt1->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt1->bindParam(":id_carrera", $datosModel["id_carrera"], PDO::PARAM_INT);
		$stmt1->bindParam(":id_tutor", $datosModel["id_tutor"], PDO::PARAM_INT);
		
		if($stmt1->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt1->close();

	}

	#VISTA ALUMNOS
	#-------------------------------------

	public function vistaAlumnoModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT a.matricula as matricula, a.nombre as nombre, c.nombre as carrera, m.nombre as tutor from $tabla as a inner join carrera as c on c.id=a.id_carrera INNER JOIN maestros as m on m.num_empleado=a.id_tutor");	
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();

	}

	public function editarAlumnoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT matricula, nombre, id_carrera, id_tutor FROM $tabla WHERE matricula = :matricula");
		$stmt->bindParam(":matricula", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	public function actualizarAlumnoModel($datosModel, $tabla){
		var_dump($datosModel);
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, id_carrera = :id_carrera, id_tutor = :id_tutor WHERE matricula = :matricula");

		$stmt->bindParam(":matricula", $datosModel["matricula"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":id_carrera", $datosModel["id_carrera"], PDO::PARAM_INT);
		$stmt->bindParam(":id_tutor", $datosModel["id_tutor"], PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}

		#BORRAR USUARIO
	#------------------------------------
	public function borrarAlumnoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE matricula = :matricula");
		$stmt->bindParam(":matricula", $datosModel, PDO::PARAM_STR);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}


	####CARRERAS

	#VISTA CARRERA
	#-------------------------------------

	public function vistaCarreraModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre from $tabla");	
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();

	}

	public function registroCarreraModel($datosModel, $tabla){

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


	public function editarCarreraModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	public function actualizarCarreraModel($datosModel, $tabla){
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

		#BORRAR USUARIO
	#------------------------------------
	public function borrarCarreraModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}



	###tutorias
	public function vistaTutoriasModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");	
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();

	}

			#BORRAR USUARIO
	#------------------------------------
	public function borrarTutoriaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}

			#REGISTRO DE ALUMNOS
	#-------------------------------------
	public function registroTutoriaModel($datosModel, $tabla){

		$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (fecha, hora, tipo, tema, num_maestro) VALUES (:fecha,:hora,:tipo,:tema,:num_maestro)");	
		
		$stmt1->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
		$stmt1->bindParam(":hora", $datosModel["hora"], PDO::PARAM_STR);
		$stmt1->bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);
		$stmt1->bindParam(":tema", $datosModel["tema"], PDO::PARAM_STR);
		$stmt1->bindParam(":num_maestro", $datosModel["num_maestro"], PDO::PARAM_STR);
		
		var_dump($datosModel);

		if($stmt1->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt1->close();

	}


	public function editarTutoriaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, hora, fecha, tipo, tema, num_maestro FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}


}

?>