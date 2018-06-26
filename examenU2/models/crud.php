<?php

#EXTENSIÓN DE CLASES: Los objetos pueden ser extendidos, y pueden heredar propiedades y métodos. Para definir una clase como extensión, debo definir una clase padre, y se utiliza dentro de una clase hija.

require_once "conexion.php";

//Heredar la clase conexion de conexion.php para poder utilizar "Conexion" del archivo conexion.php.
//Se extiende cuando se requiere manipuar una funcion, en este caso se va a  manipular la función "conectar" del models/conexion.php:
class Datos extends Conexion{

	#Ingreso usuario
	#-------------------------------------
	#Obtiene el usuario, contrasena del usuario 
	public function ingresoUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT user, pass FROM $tabla WHERE user = :user");	
		$stmt->bindParam(":user", $datosModel["user"], PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();
		$stmt->close();
	}

	#Obtener categorias
	#-------------------------------------
	#Obtiene todas las categorias registradas en la base de datos
	public function obtenerGruposModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla");
		$stmt->execute();

		return $stmt->fetchAll();
	}


	#Obtener alumnas de grupo
	#-------------------------------------
	#Obtiene todas las categorias registradas en la base de datos
	public function obtenerAlumnasFromGroupModel($id,$tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id, concat(nombre, ' ',apellido_paterno) as nombre FROM $tabla WHERE id_grupo=:id_grupo");
		$stmt->bindParam(":id_grupo", $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}



	###################################### ALUMNA ############################################ 
	#Borrar alumna
	#-------------------------------------
	#Permite el borrado de una alumna dependiendo del id mandado como parametro
	public function borrarAlumnaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");	
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}

	#Registro de alumna
	#-------------------------------------
	#Permite el registro de una alumna en el sistema
	public function registroAlumnaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, apellido_paterno, id_grupo) VALUES (:nombre, :apellido_paterno, :id_grupo)");	

		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido_paterno", $datosModel["apellido_paterno"], PDO::PARAM_STR);
		$stmt->bindParam(":id_grupo", $datosModel["id_grupo"], PDO::PARAM_INT);
		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt->close();
	}

	#Vista alumna
	#-------------------------------------
	#Permite el llenado de la tabla del crud de categoria obteniendo todos los registros de las tablas alumnos y grupos para obtener el nombre del grupo en
	#el registro del alumno
	public function vistaAlumnasModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT a.id as id, a.nombre as nombre, a.apellido_paterno as apellido_paterno, g.nombre as grupo from $tabla AS a INNER JOIN grupos AS g on g.id=a.id_grupo");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}

	#Edicion de alumna
	#-------------------------------------
	#Permite la modificacion al obtener los valores de la alumna actualmente que posteriormente seran usados en la interfaz
	public function editarAlumnaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre, apellido_paterno, id_grupo FROM $tabla WHERE id = :id");	
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#Actualizacion de alumna
	#-------------------------------------
	#Actualiza los valores de las columnas de la alumna
	public function actualizarAlumnaModel($datosModel, $tabla){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido_paterno = :apellido_paterno WHERE id_grupo = :id_grupo");	

		$stmt->bindParam(":nombre", $datosModel['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":apellido_paterno", $datosModel["apellido_paterno"], PDO::PARAM_INT);
		$stmt->bindParam(":id_grupo", $datosModel["id_grupo"], PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}
	###################################### TERMINA ALUMNA ############################################ 




	########################################### GRUPOS ############################################### 
	#Borrar alumna
	#-------------------------------------
	#Permite el borrado de una alumna dependiendo del id mandado como parametro
	public function borrarGrupoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");	
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}

	#Registro de grupo
	#-------------------------------------
	#Permite el registro de un nuevo grupo al sistema
	public function registroGrupoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre) VALUES (:nombre)");	

		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}

	#Vista grupo
	#-------------------------------------
	#Permite el llenado de la tabla del crud de grupos obteniendo todos los registros de las tablas grupos y grupos para obtener el nombre del grupo en
	#el registro del alumno
	public function vistaGrupoModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}

	#Edicion de grupo
	#-------------------------------------
	#Permite la modificacion al obtener los valores de un grupo actualmente que posteriormente seran usados en la interfaz
	public function editarGrupoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla WHERE id = :id");	
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#Actualizacion de alumna
	#-------------------------------------
	#Actualiza los valores de las columnas de la alumna
	public function actualizarGrupoModel($datosModel, $tabla){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre WHERE id = :id");	
		$stmt->bindParam(":id", $datosModel['id'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datosModel['nombre'], PDO::PARAM_STR);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}
	###################################### TERMINA GRUPOS ############################################ 


	
	########################################### PAGOS ############################################### 
	#Borrar pago
	#-------------------------------------
	#Permite el borrado de unn pago dependiendo del id mandado como parametro
	public function borrarPagoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_pago = :id_pago");	
		$stmt->bindParam(":id_pago", $datosModel, PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}


	#Edicion de pago
	#-------------------------------------
	#Permite la modificacion al obtener los valores de un pago actualmente que posteriormente seran usados en la interfaz
	public function editarPagosModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT a.id_grupo as id_grupo, p.id_pago as id_pago, p.id_alumna as id_alumna, p.nombre_mama as nombre_mama, p.fecha_pago as fecha_pago, p.fecha_envio as fecha_envio, p.url_imagen as url_imagen, p.folio as folio FROM $tabla as p INNER JOIN alumnas as a on a.id=p.id_alumna WHERE p.id_pago = :id_pago");	
		$stmt->bindParam(":id_pago", $datosModel, PDO::PARAM_INT);	

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#Actualizacion de alumna
	#-------------------------------------
	#Actualiza los valores de las columnas de la alumna
	public function actualizarPagoModel($datosModel, $tabla){
		var_dump($datosModel);

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET id_alumna = :id_alumna, nombre_mama = :nombre_mama, fecha_pago =:fecha_pago, fecha_envio =:fecha_envio, folio=:folio WHERE id_pago = :id_pago");	
		+
		$stmt->bindParam(":id_pago", $datosModel['id_pago'], PDO::PARAM_INT);
		$stmt->bindParam(":id_alumna", $datosModel['id_alumna'], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_mama", $datosModel['nombre_mama'], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_pago", $datosModel['fecha_pago'], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_envio", $datosModel['fecha_envio'], PDO::PARAM_STR);
		$stmt->bindParam(":folio", $datosModel['folio'], PDO::PARAM_STR);

		$stmt->errorInfo();
		if($stmt->execute())
			return "success";
		else{
			return "error";
		}

		$stmt->close();
	}
	###################################### TERMINA GRUPOS ############################################ 


	############################################### PAGOS ############################################ 

	#Registro de grupo
	#-------------------------------------
	#Permite el registro de un nuevo grupo al sistema
	public function registroPagoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_alumna, nombre_mama, fecha_pago, fecha_envio, url_imagen, folio) VALUES (:id_alumna, :nombre_mama, :fecha_pago, :fecha_envio, :url_imagen, :folio)");	

		$stmt->bindParam(":id_alumna", $datosModel["id_alumna"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_mama", $datosModel["nombre_mama"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_pago", $datosModel["fecha_pago"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_envio", $datosModel["fecha_envio"], PDO::PARAM_STR);
		$stmt->bindParam(":url_imagen", $datosModel["url_imagen"], PDO::PARAM_STR);
		$stmt->bindParam(":folio", $datosModel["folio"], PDO::PARAM_STR);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}

	#Vista pago
	#-------------------------------------
	#Permite el llenado de la tabla del crud de grupos obteniendo todos los registros de las tablas grupos y grupos para obtener el nombre del grupo en
	#el registro del alumno
	public function vistaPublicPagoModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT p.id_pago as id, CONCAT(a.nombre,' ',a.apellido_paterno) as nombre, p.nombre_mama AS nombre_mama, p.fecha_envio as fecha_envio, p.folio AS folio FROM $tabla AS p INNER JOIN alumnas AS a ON a.id=p.id_alumna");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}

	#Vista pago
	#-------------------------------------
	#Permite el llenado de la tabla del crud de grupos obteniendo todos los registros de las tablas grupos y grupos para obtener el nombre del grupo en
	#el registro del alumno
	public function vistaPagoModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT p.id_pago as id, CONCAT(a.nombre,' ',a.apellido_paterno) as nombre, p.nombre_mama AS nombre_mama, p.fecha_envio as fecha_envio, p.fecha_pago as fecha_pago, p.url_imagen as url_imagen, p.folio AS folio FROM $tabla AS p INNER JOIN alumnas AS a ON a.id=p.id_alumna");	

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();
	}
	
	
	###################################### TERMINA PAGOS ############################################# 

}

?>