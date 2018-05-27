<?php

#EXTENSIÓN DE CLASES: Los objetos pueden ser extendidos, y pueden heredar propiedades y métodos. Para definir una clase como extensión, debo definir una clase padre, y se utiliza dentro de una clase hija.

require_once "conexion.php";

//heredar la clase conexion de conexion.php para poder utilizar "Conexion" del archivo conexion.php.
// Se extiende cuando se requiere manipuar una funcion, en este caso se va a  manipular la función "conectar" del models/conexion.php:
class Datos extends Conexion{

	#INGRESO MAESTRO
	#-------------------------------------
	#Obtiene el email, contrasena, numero de empleado y nivel de los maestros.
	public function ingresoMaestroModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT email, password, num_empleado, nivel FROM $tabla WHERE email = :email");	
		$stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();
		$stmt->close();
	}

	#VISTA MAESTROS MODEL
	#-------------------------------------
	#Obtiene los datos de todos los maestros
	public function vistaMaestrosModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT m.num_empleado as num_empleado, m.nombre as nombre, m.email as email, c.nombre as nombre_carrera, m.nivel as nivel FROM $tabla as m inner join carrera as c on m.id_carrera=c.id");	
		$stmt->execute();
 
		return $stmt->fetchAll();

		$stmt->close();

	}

	#EDITAR MAESTRO
	#-------------------------------------
	#Se encarga de obtener los valores actuales de cierto empleado
	public function editarMaestroModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT num_empleado, nombre, email, password, id_carrera, nivel FROM $tabla WHERE num_empleado = :num_empleado");
		$stmt->bindParam(":num_empleado", $datosModel, PDO::PARAM_INT);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();
	}

	#OBTENER CARRERAS
	#-------------------------------------
	#Obtiene las carreras de toda la tabla
	public function obtenerCarrerasModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla");
		$stmt->execute();

		return $stmt->fetchAll();
	}

	#OBTENER TUTORES
	#-------------------------------------
	#Obtiene las tutores de toda la tabla
	public function obtenerTutoresModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT num_empleado, nombre FROM $tabla");
		$stmt->execute();

		return $stmt->fetchAll();
	}

	#OBTENER ALUMNOS
	#-------------------------------------
	#Obtiene las alumnos de toda la tabla
	public function obtenerAlumnosModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT matricula, nombre FROM $tabla");
		$stmt->execute();

		return $stmt->fetchAll();
	}

	#OBTENER ALUMNOS NIVEL
	#-------------------------------------
	#Obtiene los alumnos que tienen a cierto tutor
	public function obtenerAlumnosNivelModel($tabla, $id){
		$stmt = Conexion::conectar()->prepare("SELECT matricula, nombre FROM $tabla WHERE id_tutor=:id_tutor");
		$stmt->bindParam(":id_tutor", $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	#ACTUALIZAR MAESTRO
	#-------------------------------------
	#Permite realizar un update a la tabla de maestros
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

	#BORRAR MAESTRO
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

	#REGISTRO DE MAESTROS
	#-------------------------------------
	public function registroMaestroModel($datosModel, $tabla){

		$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (num_empleado, nombre, email, password, id_carrera, nivel) VALUES (:num_empleado,:nombre,:email,:password,:id_carrera,:nivel)");	
		
		$stmt1->bindParam(":num_empleado", $datosModel["num_empleado"], PDO::PARAM_STR);
		$stmt1->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt1->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);
		$stmt1->bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
		$stmt1->bindParam(":id_carrera", $datosModel["id_carrera"], PDO::PARAM_INT);
		$stmt1->bindParam(":nivel", $datosModel["nivel"], PDO::PARAM_INT);

		if($stmt1->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt1->close();

	}

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

	#EDICION DE ALUMNOS 
	#-------------------------------------
	public function editarAlumnoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT matricula, nombre, id_carrera, id_tutor FROM $tabla WHERE matricula = :matricula");
		$stmt->bindParam(":matricula", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZACION DE ALUMNOS 
	#-------------------------------------
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


	#VISTA CARRERA
	#-------------------------------------
	public function vistaCarreraModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre from $tabla");	
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();

	}

	#REGISTRO DE CARRERAS 
	#-------------------------------------
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

	#EDICION DE LA CARRERA  
	#-------------------------------------
	public function editarCarreraModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZACION DE LA CARRERA
	#-------------------------------------
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

	#BORRAR TODO SOBRE LA CARRERA
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

	#PERMITE REALIZAR UNA VISTA PARA TUTORIAS
	#-------------------------------------
	public function vistaTutoriasModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}
	
	#VISTA DE LAS TUTORIAS POR NIVEL 
	#-------------------------------------
	#Muestra solo las tutorias que ha hecho el empleado, con el numero de maestro ingresado
	public function vistaTutoriasNivelModel($tabla, $id){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla where num_maestro=:num_maestro");	
		$stmt->bindParam(":num_maestro", $id, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	#BORRAR DE LAS TUTORIAS 
	#-------------------------------------
	public function borrarTutoriaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}

	#BORRAR ALUMNOS TUTORIAS 
	#-------------------------------------
	public function borrarAlumnosTutoriaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_sesion = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}


	#REGISTRO DE TUTORIAS
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

	#OBTENER ULTIMA TUTORIA
	#-------------------------------------
	public function ObtenerLastTutoria($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT max(id) FROM $tabla");
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();
	}

	#REGISTRO DE LOS ALUMNOS
	#-------------------------------------
	public function registroAlumnosTutoriaModel($datosModel, $id_sesion, $tabla){
		$datosModel_array =  explode(",",$datosModel);
		
		for($i=0;$i<sizeof($datosModel_array);$i++){
			$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (matricula_alumno, id_sesion) VALUES (:matricula_alumno,:id_sesion)");	
			$stmt1->bindParam(":matricula_alumno", $datosModel_array[$i], PDO::PARAM_STR);
			$stmt1->bindParam(":id_sesion", $id_sesion, PDO::PARAM_INT);

			if(!$stmt1->execute())
				return "error";

		}
		
		return "success";		

		$stmt1->close();

	}

	#EDICION DE LA INTERFAZ
	#-------------------------------------
	public function editarTutoriaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, hora, fecha, tipo, tema, num_maestro FROM $tabla WHERE id = :id");
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#OBTENER LOS ALUMNOS DE LA TUTORIA
	#-------------------------------------
	public function obtenerAlumnosTutoriaModel($datosModel,$tabla){

		$stmt = Conexion::conectar()->prepare("SELECT st.matricula_alumno, a.nombre FROM $tabla as st INNER JOIN alumnos AS a ON a.matricula=st.matricula_alumno WHERE st.id_sesion=:id_sesion");
		$stmt->bindParam(":id_sesion", $datosModel, PDO::PARAM_INT);	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}

	#ACTUALIZA EL TUTOR MUCHO MAS.
	#-------------------------------------
	public function actualizarTutoriaModel($datosModel, $tabla){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha = :fecha, hora = :hora, tipo = :tipo, tema = :tema WHERE id = :id");

		$stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":hora", $datosModel["hora"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":tema", $datosModel["tema"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}


}

?>