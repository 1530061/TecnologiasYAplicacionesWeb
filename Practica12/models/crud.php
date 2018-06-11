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

		$stmt = Conexion::conectar()->prepare("SELECT user_id, firstname, lastname, user_name, user_password_hash, id_tienda FROM $tabla WHERE user_name = :user_name");	
		$stmt->bindParam(":user_name", $datosModel["user_name"], PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();
		$stmt->close();
	}

	#DETALLES DE TIENDA
	#-------------------------------------
	#Se obtienen los atributos de una tienda.
	public function getDetailsFromTienda($datosModel,$tabla){
		$stmt = Conexion::conectar()->prepare("SELECT nombre, activa FROM $tabla WHERE id_tienda=:id_tienda");
		$stmt->bindParam(":id_tienda", $datosModel, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();
	}

	#VISTA HISTORIAL
	#-------------------------------------
	#Muestra una tabla con el historial.
	public function vistaHistorialProductModel($tabla,$id){
		$stmt = Conexion::conectar()->prepare("SELECT fecha, nota, referencia, cantidad FROM $tabla WHERE id_producto=:id_producto AND id_tienda=:id_tienda");	

		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $id, PDO::PARAM_INT);	
		$stmt->execute();
 
		return $stmt->fetchAll();

		$stmt->close();
	}

	#VISTA PRODUCTO DETALLES
	#-------------------------------------
	#Muestra una vista con los detalles del producto
	public function vistaProductoDetallesModel($id, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_producto, codigo_producto, nombre_producto, precio_producto, stock FROM $tabla WHERE id_producto=:id_producto AND id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}
	
	#VISTA PRODUCTO
	#-------------------------------------
	#Muestra una tabla con los productos
	public function vistaProductoModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT p.id_producto AS id_producto, p.codigo_producto AS codigo_producto, p.nombre_producto AS nombre_producto, p.date_added as date_added, p.precio_producto as precio_producto, p.stock AS stock, c.nombre_categoria AS nombre_categoria from $tabla AS p INNER JOIN categorias AS c ON c.id_categoria=p.id_categoria WHERE p.id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	#VISTA PRODUCTO
	#-------------------------------------
	#Muestra una tabla con los productos
	public function vistaTiendaModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id_tienda, nombre, activa FROM $tabla WHERE id_tienda!=1");	
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

	}

	#TOTAL OF
	#-------------------------------------
	#Obtiene el conteo de una tabla
	public function getTotalOfModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT count(*) FROM $tabla WHERE id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();
	}

	#BORRAR PRODUCTOS
	#-------------------------------------
	#Permite eliminar los productos de una categoria
	public function borrarProductsIdModel($datosModel,$tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_categoria = :id_categoria AND id_tienda=:id_tienda");

		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->bindParam(":id_categoria", $datosModel, PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else{
			print_r($stmt->errorInfo());
			return "error";
		}

		$stmt->close();

	}

	public function obtenerProductosModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id_producto, nombre_producto, precio_producto, stock FROM $tabla WHERE id_tienda=:id_tienda");
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->execute();

		return $stmt->fetchAll();
	}
	

	public function insertarProductosDeVenta($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_venta, id_producto, cantidad, importe) VALUES (:id_venta, :id_producto, :cantidad, :importe)");	

		$stmt->bindParam(":id_venta", $datosModel["id_venta"], PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $datosModel["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":cantidad", $datosModel["cantidad"], PDO::PARAM_INT);
		$stmt->bindParam(":importe", $datosModel["importe"], PDO::PARAM_STR);
		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt->close();
	}
	#REGISTRO DE CATEGORIAS
	#-------------------------------------
	public function insertarVenta($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (fecha, total) VALUES (:fecha, :total)");	

		$stmt->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":total", $datosModel["total"], PDO::PARAM_STR);
		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt->close();
	}

	public function getLastId($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT max(id) as id FROM venta");
		$stmt->execute();

		return $stmt->fetch();
	}

	#BORRAR HISTORIAL
	#-------------------------------------
	#Permite eliminar los productos de una categoria
	public function BorrarColumnIdModel($id_columna,$tabla,$columna){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE '$columna' = :id_columna AND id_tienda=:id_tienda");	
		$stmt->bindParam(":id_columna", $id_columna, PDO::PARAM_INT);
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else{
			print_r($stmt->errorInfo());
			return "error";
		}

		$stmt->close();

	}

	#VISTA USUARIO
	#-------------------------------------
	#Permite el llenado de la tabla del crud
	public function vistaUsuarioModel($tabla, $id_tienda){

		$stmt = Conexion::conectar()->prepare("SELECT user_id, firstname, lastname, user_name, user_email, date_added from $tabla WHERE id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);		
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();
	}

	#VISTA CATEGORIA
	#-------------------------------------
	#Permite el llenado de la tabla del crud de categoria
	public function vistaCategoriaModel($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_categoria, nombre_categoria, descripcion_categoria, date_added from $tabla WHERE id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->execute();

		#fetchAll(): Obtiene todas las filas de un conjunto de resultados asociado al objeto PDOStatement. 
		return $stmt->fetchAll();

		$stmt->close();
	}
	

	#BORRAR PRODUCTO
	#------------------------------------
	public function borrarProductoInventarioModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_producto = :id_producto AND id_inventario =:id_inventarioWHERE id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":id_producto", $datosModel['idBorrar'], PDO::PARAM_INT);
		$stmt->bindParam(":id_inventario", $datosModel['id'], PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();

	}

	#BORRAR CATEGORIA
	#-------------------------------------
	public function borrarCategoriaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_categoria = :id_categoria AND id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":id_categoria", $datosModel, PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else{
			print_r($stmt->errorInfo());
			return "error";
		}

		$stmt->close();

	}

	#PERMITE INSERTAR UN REGISTRO AL INVENTARIO
	#-------------------------------------
	public function detallesMovimientoProductoModel($datosModel, $tabla){
		$stmt1 = Conexion::conectar()->prepare("INSERT INTO $tabla (id_producto, user_id, fecha, nota, referencia, cantidad, id_tienda) VALUES (:id_producto, :user_id, :fecha, :nota, :referencia, :cantidad, :id_tienda)");	

		$stmt1->bindParam(":id_producto", $datosModel["id_producto"], PDO::PARAM_INT);
		$stmt1->bindParam(":user_id", $datosModel["user_id"], PDO::PARAM_INT);
		$stmt1->bindParam(":fecha", $datosModel["fecha"], PDO::PARAM_STR);
		$stmt1->bindParam(":nota", $datosModel["nota"], PDO::PARAM_STR);
		$stmt1->bindParam(":referencia", $datosModel["referencia"], PDO::PARAM_STR);
		$stmt1->bindParam(":cantidad", $datosModel["cantidad"], PDO::PARAM_INT);
		$stmt1->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		
		if($stmt1->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt1->close();
	}

	#ACTUALIZAR LAS UNIDADES DE MODELO
	#-------------------------------------
	public function updateProductUnitsModel($id, $cant, $table){
		$stmt = Conexion::conectar()->prepare("UPDATE $table SET stock = :stock WHERE id_producto = :id_producto AND id_tienda=:id_tienda");

		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":stock", $cant, PDO::PARAM_INT);
		$stmt->bindParam(":id_producto", $id, PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}
	public function getAvailabilityProductModel($id,$table){

		$stmt = Conexion::conectar()->prepare("SELECT stock FROM $table WHERE id_producto=:id_producto AND id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":id_producto", $id, PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetch()['stock'];

		$stmt->close();
	}

	#OBTENER CATEGORIAS
	#-------------------------------------
	#Obtiene las categorias
	public function obtenerCategoriasModel($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id_categoria, nombre_categoria FROM $tabla WHERE id_tienda=:id_tienda");
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->execute();

		return $stmt->fetchAll();
	}


	#OBTENER EL STOCK 
	#-------------------------------------
	public function obtenerStockProductModel($id,$tabla){
		$stmt = Conexion::conectar()->prepare("SELECT id_categoria, nombre_categoria FROM $tabla WHERE id_tienda=:id_tienda");	

		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	#REGISTRO DE CATEGORIAS
	#-------------------------------------
	public function registroCategoriaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_categoria, descripcion_categoria, date_added, id_tienda) VALUES (:nombre_categoria, :descripcion_categoria, :date_added, :id_tienda)");	

		$stmt->bindParam(":nombre_categoria", $datosModel["nombre_categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion_categoria", $datosModel["descripcion_categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":date_added", $datosModel["date_added"], PDO::PARAM_STR);
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt->close();
	}

	


	#REGISTRO DE CATEGORIAS
	#-------------------------------------
	public function registroTiendaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre, activa) VALUES (:nombre, :activa)");	

		$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":activa", $datosModel["activa"], PDO::PARAM_INT);
		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt->close();
	}
	#REGISTRO DE USUARIOS
	#-------------------------------------
	public function registroUsuarioModel($datosModel, $tabla){

		var_dump($datosModel);
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (firstname, lastname, user_name, user_password_hash, user_email, date_added, id_tienda) VALUES (:firstname, :lastname, :user_name, :user_password_hash, :user_email, :date_added, :id_tienda)");	

		$stmt->bindParam(":firstname", $datosModel["firstname"], PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $datosModel["lastname"], PDO::PARAM_STR);
		$stmt->bindParam(":user_name", $datosModel["user_name"], PDO::PARAM_STR);
		$stmt->bindParam(":user_password_hash", $datosModel["user_password_hash"], PDO::PARAM_STR);
		$stmt->bindParam(":user_email", $datosModel["user_email"], PDO::PARAM_STR);
		$stmt->bindParam(":date_added", $datosModel["date_added"], PDO::PARAM_STR);
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);

		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt->close();
		

	}


	#EDITAR EL INVENTARIO
	#-------------------------------------
	public function editarInventarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre FROM $tabla WHERE id = :id AND id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}


	#EDICION DEL USUARIO
	#-------------------------------------
	public function editarUsuarioModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT user_id, firstname, lastname, user_name, user_password_hash, user_email FROM $tabla WHERE user_id = :user_id AND id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":user_id", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZAR EL USUARIO
	#-------------------------------------
	public function actualizarUsuarioModel($datosModel, $tabla){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET firstname = :firstname, lastname = :lastname, user_name=:user_name, user_password_hash=:user_password_hash, user_email=:user_email WHERE user_id = :user_id AND id_tienda=:id_tienda");	
		
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":user_id", $datosModel["user_id"], PDO::PARAM_INT);
		$stmt->bindParam(":firstname", $datosModel["firstname"], PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $datosModel["lastname"], PDO::PARAM_STR);
		$stmt->bindParam(":user_name", $datosModel["user_name"], PDO::PARAM_STR);
		$stmt->bindParam(":user_password_hash", $datosModel["user_password_hash"], PDO::PARAM_STR);
		$stmt->bindParam(":user_email", $datosModel["user_email"], PDO::PARAM_STR);

		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}


	#BORRAR USUARIO
	#------------------------------------
	public function borrarUsuarioModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE user_id = :id AND id_tienda=:id_tienda");

		
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);

		
		if($stmt->execute()){

			return "success";
		}
		else{
			print_r($stmt->errorInfo());
			return "error";
		}


		$stmt->close();

	}


	#BORRAR USUARIO
	#------------------------------------
	public function borrarTiendaModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_tienda = :id_tienda ");

		
		$stmt->bindParam(":id_tienda", $datosModel, PDO::PARAM_INT);	
		
		if($stmt->execute()){
			return "success";
		}
		else{
			print_r($stmt->errorInfo());
			return "error";
		}


		$stmt->close();

	}

	#BORRAR PRODUCTO
	#------------------------------------
	public function borrarProductoModel($datosModel, $tabla){
		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_producto = :id_producto AND id_tienda=:id_tienda");

		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":id_producto", $datosModel, PDO::PARAM_INT);

		if($stmt->execute())
			return "success";
		else{
			print_r($stmt->errorInfo());
			return "error";
		}

		$stmt->close();

	}


	#REGISTRO DE PRODUCTOS
	#-------------------------------------
	public function registroProductoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (codigo_producto, nombre_producto, date_added, precio_producto, stock, id_categoria, id_tienda) VALUES (:codigo_producto, :nombre_producto, :date_added, :precio_producto, :stock, :id_categoria, :id_tienda)");	
		
		$stmt->bindParam(":codigo_producto", $datosModel["codigo_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_producto", $datosModel["nombre_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":date_added", $datosModel["date_added"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_producto", $datosModel["precio_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_INT);
		$stmt->bindParam(":id_categoria", $datosModel["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		
		if($stmt->execute()){
			return "success";
		}
		else{
			return "error";
		}

		$stmt->close();

	}


	#EDICION DEL PRODUCTO  
	#-------------------------------------
	public function editarProductoModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_producto, codigo_producto, nombre_producto, date_added, precio_producto, stock, id_categoria FROM $tabla WHERE id_producto = :id_producto AND id_tienda=:id_tienda");	

		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);	
		$stmt->bindParam(":id_producto", $datosModel, PDO::PARAM_STR);	
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}


	#EDICION DEL PRODUCTO  
	#-------------------------------------
	public function editarTiendaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_tienda, nombre, activa FROM $tabla WHERE id_tienda = :id_tienda");	

		$stmt->bindParam(":id_tienda", $datosModel, PDO::PARAM_INT);		
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#EDICION DE CATEGORIA
	#-------------------------------------
	public function editarCategoriaModel($datosModel, $tabla){

		$stmt = Conexion::conectar()->prepare("SELECT id_categoria, nombre_categoria, descripcion_categoria, date_added FROM $tabla WHERE id_categoria = :id_categoria AND id_tienda=:id_tienda");	
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->bindParam(":id_categoria", $datosModel, PDO::PARAM_INT);	

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

	}

	#ACTUALIZACION DE CATEGORIA
	#-------------------------------------
	public function actualizarCategoriaModel($datosModel, $tabla){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_categoria = :nombre_categoria, descripcion_categoria = :descripcion_categoria WHERE id_categoria = :id_categoria AND id_tienda=:id_tienda");	

		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		$stmt->bindParam(":id_categoria", $datosModel["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre_categoria", $datosModel["nombre_categoria"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion_categoria", $datosModel["descripcion_categoria"], PDO::PARAM_STR);

		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}

	

	#ACTUALIZACION DE CATEGORIA
	#-------------------------------------
	public function actualizarTiendaModel($datosModel, $tabla){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, activa = :activa WHERE id_tienda = :id_tienda");	

		$stmt->bindParam(":nombre", $datosModel['nombre'], PDO::PARAM_STR);
		$stmt->bindParam(":activa", $datosModel["activa"], PDO::PARAM_INT);
		$stmt->bindParam(":id_tienda", $datosModel["id_tienda"], PDO::PARAM_INT);
		
		
		if($stmt->execute())
			return "success";
		else{
			print_r($tmt->getError());
			return "error";
		}

		$stmt->close();
	}

	#ACTUALIZACION DEL PRODUCTO
	#-------------------------------------
	public function actualizarProductoModel($datosModel, $tabla){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo_producto = :codigo_producto, nombre_producto = :nombre_producto, precio_producto=:precio_producto, id_categoria=:id_categoria, stock=:stock WHERE id_producto = :id_producto AND id_tienda=:id_tienda");	
	
		$stmt->bindParam(":id_producto", $datosModel["id_producto"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_producto", $datosModel["codigo_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre_producto", $datosModel["nombre_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":precio_producto", $datosModel["precio_producto"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_STR);
		$stmt->bindParam(":id_categoria", $datosModel["id_categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":id_tienda", $_SESSION['id_tienda'], PDO::PARAM_INT);
		
		if($stmt->execute())
			return "success";
		else
			return "error";

		$stmt->close();
	}


	#OBTIENE SI HAY DISPONIBILIDAD DEL PRODUCTO
	#-------------------------------------
	public function checkAvailabilityOfProductCodeModel($code){
		$stmt = Conexion::conectar()->prepare("SELECT EXISTS(SELECT * FROM products WHERE codigo_producto=:codigo_producto) as a");

		$stmt->bindParam(":codigo_producto", $code, PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();
	}
}

?>