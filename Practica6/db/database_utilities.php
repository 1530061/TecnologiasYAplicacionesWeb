<?php
	include('connection.php');

	//Funcion que cuenta los estados que se encuentran registrados en la base de datos
	function count_status(){
		global $pdo;

		$sql = "SELECT COUNT(*) as total_status FROM status";

		$statement = $pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['total_status'];
	}

	//Funcion que cuenta los usuarios que se encuentra registrados
	function count_users(){
		global $pdo;

		$sql = "SELECT COUNT(*) as total_users FROM user";

		$statement = $pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['total_users'];
	}

	//Funcion que permite contar los tipos de usuarios que existen
	function count_types(){
		global $pdo;

		$sql = "SELECT COUNT(*) as total_types FROM user_type";

		$statement = $pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['total_types'];
	}

	//Funcion que permite ver los usuarios que se encuentran activos
	function count_active(){
		global $pdo;

		$sql = "SELECT COUNT(*) as active_users FROM user WHERE status_id=1";

		$statement = $pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['active_users'];
	}

	//Funcion que permite ver los usuarios que se encuentran inactivos
	function count_inactive(){
		global $pdo;

		$sql = "SELECT COUNT(*) as inactive_users FROM user WHERE status_id=2";

		$statement = $pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['inactive_users'];
	}

	function count_access(){
		global $pdo;

		$sql = "SELECT COUNT(*) as total_access FROM user_log";

		$statement = $pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['total_access'];
	}

	//Funcion que permite obtener todos los registros en otra tabla.
	function selectAllFromTable($table){
		global $pdo;

		$sql = "SELECT * FROM $table";
		
		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results;
	}


	//Funcion que permite obtener todos los uaurios de la tabla sporteam
	function getAll($type){
		global $pdo;

		
		$sql = "SELECT * from sport_team WHERE id_type=$type";

		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results;
	}


	//Funcion que permite agregar, un registro o modificarlo
	function add($id,$nombre,$posicion, $carrera, $email,$type){
		global $pdo;

		$sql = "INSERT INTO sport_team (id,nombre,posicion,carrera,email,id_type) VALUES('$id','$nombre','$posicion','$carrera','$email','$type')";
		$statement = $pdo->prepare($sql);

		$statement->execute();
	}

	//Funcion que permite realizar una bosuqeda de los datos de uno de sus usuarios
	function search($id){
		global $pdo;

		$sql = "SELECT * FROM sport_team where id='$id'";
		$statement = $pdo->prepare($sql);

		$statement->execute();

		$results=$statement->fetchAll();

		return $results[0];
	}

	//Funcion que permite actualizar algun registro existente dependiendo de su  id
	function update($id,$nombre,$posicion, $carrera, $email){
		global $pdo;

		$sql = "UPDATE sport_team SET nombre='$nombre', posicion='$posicion', carrera='$carrera', email='$email' WHERE id='$id'";
		$statement = $pdo->prepare($sql);

		$statement->execute();

		$results=$statement->fetchAll();

		return $results[0];
	}

	//Funcion que permite eliminar la informacion de un registro
	function delete($id){
		global $pdo;

		$sql = "DELETE FROM sport_team where id='$id'";
		$statement = $pdo->prepare($sql);
		$statement->execute();

	}
?>

