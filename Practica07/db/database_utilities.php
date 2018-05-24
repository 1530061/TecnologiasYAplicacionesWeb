<?php
	include('connection.php');

	//Se revisa si el usuario y la contrasena existen en la base de datos retornando true/false
	function checkUserAndPass($user,$pass){
		global $pdo;

		$pass=md5($pass);

		$sql = "SELECT usuario FROM usuario WHERE usuario='$user' && password='$pass'";
		
		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		if(empty($results[0]['usuario'])){
			return false;
		}else{
			return true;
		}
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

	//Permite obtener el ultimo id de las ventas
	function getLastIdSale(){
		global $pdo;

		$sql="SELECT max(id) as id FROM venta";
		$statement = $pdo->prepare($sql);
		$statement->execute();

		$results=$statement->fetchAll();

		return $results[0]['id'];
	}

	//Guarda una venta en el sistema dependiendo de una matriz de detalles que se ingrese
	function saveSale($d){
		global $pdo;

		$fecha=date("Y-m-d H:i:s");

		$total=0;
		for($i=0;$i<count($d);$i++){
			$total=$total+$d[$i][4];
		}

		$sql="INSERT into venta (fecha,total) VALUES('$fecha',$total)";
		$statement = $pdo->prepare($sql);
		$statement->execute();

		$id=getLastIdSale();

		for($i=0;$i<count($d);$i++){
			$sql="INSERT into detalle_de_venta (id_venta, id_producto, cantidad, promedio_por_unidad, importe) VALUES($id,".$d[$i][0].",".$d[$i][2].",".$d[$i][3].",".$d[$i][4].")";
			$statement = $pdo->prepare($sql);
			$statement->execute();
		}
		
	}

	//Se obtiene toda la informacion de las ventas
	function getAllInfoFromSales($date=""){
		global $pdo;

		if($date==""){
			$sql = "SELECT * FROM venta";
		}else{
			$sql = "SELECT * FROM venta WHERE fecha='$date'";
		}
		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results;
	}

	//Se obtiene la fecha de una venta correspondiente a su id
	function getSaleDate($id){
		global $pdo;

		$sql = "SELECT fecha FROM venta WHERE id=$id";

		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['fecha'];
	}

	//Se obtiene el total de la venta correspodiente a el id ingresado
	function getSaleTotal($id){
		global $pdo;

		$sql = "SELECT total FROM venta WHERE id=$id";

		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results[0]['total'];
	}


	function getInfoFromSale($id){
		global $pdo;

		$sql = "SELECT d.id_producto, p.nombre, d.cantidad, d.promedio_por_unidad, d.importe FROM detalle_de_venta AS d INNER JOIN producto AS p on p.id=d.id_producto WHERE d.id_venta=$id";

		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results;
	}

	//Funcion que permite obtener todos los uaurios de la tabla sporteam
	function getAll($type){
		global $pdo;


		$type=$type-1;
		$tables=["usuario","producto"];

		$sql = "SELECT * from $tables[$type]";

		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results;
	}

	//Permite obtener el nombre de los productos
	function get_productNames(){
		global $pdo;

		$sql = "SELECT id, nombre, precio from producto";

		$statement = $pdo->prepare($sql);

		$statement->execute();
		$results=$statement->fetchAll();

		return $results;
	}

	//Se revisa si el usuario ya existe
	function checkIfUserAlreadyExists($user){
		global $pdo;

		$sql = "SELECT usuario FROM usuario WHERE usuario='$user'";

		$statement = $pdo->prepare($sql);
		$statement->execute();
		$results=$statement->fetchAll();

		if(!empty($results[0]['usuario']))
			return true;
		else
			return false;
	}

	//Funcion que permite agregar, un registro o modificarlo
	function add_user($name,$last_name,$ap_m, $user, $password){
		global $pdo;
		$password=md5($password);

		if(!checkIfUserAlreadyExists($user)){
			$sql = "INSERT INTO usuario (nombre,apellido_paterno,apellido_materno, usuario,password) VALUES('$name','$last_name','$ap_m','$user','$password')";
			$statement = $pdo->prepare($sql);

			$statement->execute();
			return true;
		}else{
			return false;
		}

	}

	//Permite agregar un nuevo producto
	function add_product($name,$price){
		global $pdo;

		$sql = "INSERT INTO producto (nombre,precio) VALUES('$name','$price')";
		$statement = $pdo->prepare($sql);

		$statement->execute();
	}

	//Permite actualizar a un usuario
	function update_user($id,$nombre,$apellido_paterno, $apellido_materno, $usuario, $password){
		global $pdo;

		$sql = "UPDATE usuario SET nombre='$nombre', apellido_paterno='$apellido_paterno', apellido_materno='$apellido_materno', usuario='$usuario', password='$password' WHERE id='$id'";
		$statement = $pdo->prepare($sql);

		$statement->execute();

		$results=$statement->fetchAll();

		return $results[0];
	}

	//Permite actualizar un producto
	function update_product($id,$nombre,$precio){
		global $pdo;

		$sql = "UPDATE producto SET nombre='$nombre', precio='$precio' WHERE id='$id'";
		$statement = $pdo->prepare($sql);

		$statement->execute();

		$results=$statement->fetchAll();

		return $results[0];
	}

	//Funcion que permite realizar una bosuqeda de los datos de uno de sus usuarios
	function search($id,$t){
		$t=$t-1;
		global $pdo;

		$tables=["usuario","producto"];

		$sql = "SELECT * FROM $tables[$t] where id='$id'";
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
	function delete($id,$type){
		global $pdo;
		
		$type=$type-1;

		$tables=["usuario","producto"];

		$sql = "DELETE FROM $tables[$type] where id=$id";
		$statement = $pdo->prepare($sql);
		$statement->execute();
	}
?>

