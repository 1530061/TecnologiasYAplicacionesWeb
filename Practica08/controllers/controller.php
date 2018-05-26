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
		if(isset( $_GET['action']))		
			$enlaces = $_GET['action'];
		else
			$enlaces = "index";
		$respuesta = Paginas::enlacesPaginasModel($enlaces);
		include $respuesta;
	}


	################ MAESTROS


	#INGRESO DE USUARIOS
	#------------------------------------
	public function ingresoMaestroController(){

		if(isset($_POST["emailIngreso"])){
			$datosController = array( "email"=>$_POST["emailIngreso"], 
								      "password"=>$_POST["passwordIngreso"]);

			$respuesta = Datos::ingresoMaestroModel($datosController, "maestros");
			
			//Valiación de la respuesta del modelo para ver si es un usuario correcto.
			if($respuesta["email"] == $_POST["emailIngreso"] && $respuesta["password"] == $_POST["passwordIngreso"]){
				session_start();
				$_SESSION["validar"] = true;
				$_SESSION["num_empleado"] = $respuesta["num_empleado"];
				header("location:index.php?action=maestros");
			}
			else{
				header("location:index.php?action=fallo");
			}
		}
	}

	#Registro de maestros
	#------------------------------------
	public function registroMaestrosController(){
		if(isset($_POST["usuarioRegistro"])){
			$datosController = array( "num_empleado"=>$_POST["num_empleado"], 
								      "nombre"=>$_POST["nombre"],
								      "email"=>$_POST["email"],
								  	  "carrera"=>$_POST["carrera"]);
			$respuesta = Datos::registroMaestrosModel($datosController, "maestros");

			if($respuesta == "success"){
				header("location:index.php?action=ok");
			}
			else{
				header("location:index.php");
			}
		}
	}

	#VISTA DE MAESTROS
	#------------------------------------

	public function vistaMaestrosController(){

		$respuesta = Datos::vistaMaestrosModel("maestros");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["num_empleado"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["email"].'</td>
				<td>'.$item["nombre_carrera"].'</td>
				<td><a href="index.php?action=editar_maestro&num_empleado='.$item["num_empleado"].'"><button>Editar</button></a></td>
				<td><a href="index.php?action=maestros&idBorrar='.$item["num_empleado"].'"><button>Borrar</button></a></td>
			</tr>';
		}
	}

	#EDITAR MAESTRO
	#------------------------------------

	public function editarMaestroController(){

		$datosController = $_GET["num_empleado"];
		$respuesta = Datos::editarMaestroModel($datosController, "maestros");
		$respuesta_select = Datos::obtenerCarrerasModel("carrera");

		$st_carreras="";
		for($i=0;$i<sizeof($respuesta_select);$i++)
			$st_carreras=$st_carreras."<option value='".$respuesta_select[$i]['id']."'>".$respuesta_select[$i]['nombre']."</option>";
		
		echo'<input type="hidden" value="'.$respuesta["num_empleado"].'" name="num_empleado">
			 <input type="text" value="'.$respuesta["nombre"].'" name="nombre" required>
			 <input type="text" value="'.$respuesta["email"].'" name="email" required>
			 <input type="password" value="'.$respuesta["password"].'" name="password" required>
			 <select id="carreras" class="js-example-basic-multiple" name="carrera">
				  '.$st_carreras.'
			 </select>
			 <input type="submit" value="Actualizar">';
		echo"
		<script>
			$(document).ready(function() {
			    $('.js-example-basic-multiple').select2();
			});
			$('#carreras').val(".$respuesta['id_carrera'].");
		</script>";

	}

	#ACTUALIZAR MAESTRO
	#------------------------------------
	public function actualizarMaestroController(){
		if(isset($_POST["num_empleado"])){
			$datosController = array( "num_empleado"=>$_POST["num_empleado"],
							          "nombre"=>$_POST["nombre"],
				                      "email"=>$_POST["email"],
				                      "password"=>$_POST["password"],
				                      "carrera"=>$_POST["carrera"]);

			$respuesta = Datos::actualizarMaestroModel($datosController, "maestros");

			if($respuesta == "success"){
				header("location:index.php?action=cambio");
			}
			else{
				echo "error";
			}
		}
	}

	#BORRAR MAESTRO
	#------------------------------------
	public function borrarMaestroController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarMaestroModel($datosController, "maestros");
			if($respuesta == "success"){
				header("location:index.php?action=usuarios");
			}
		}
	}

	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroMaestroController(){

		if(isset($_POST["num_empleado"])){
			$datosController = array( "num_empleado"=>$_POST["num_empleado"], 
								      "nombre"=>$_POST["nombre"],
								      "email"=>$_POST["email"],
								      "password"=>$_POST["password"],
								  	  "id_carrera"=>$_POST["id_carrera"]);

			$respuesta = Datos::registroMaestroModel($datosController, "maestros");
			var_dump($respuesta);
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_maestro");
			}
			else{
				header("location:index.php");
			}
		}
	}

	public function registroBaseMaestroController(){

		$respuesta_carreras = Datos::obtenerCarrerasModel("carrera");

		$st_carreras="";
		for($i=0;$i<sizeof($respuesta_carreras);$i++)
			$st_carreras=$st_carreras."<option value='".$respuesta_carreras[$i]['id']."'>".$respuesta_carreras[$i]['nombre']."</option>";

		echo'<label for="num_empleado">Numero Empleado:</label>
			 <input type="text" name="num_empleado">
			 <label for="nombre">Nombre:</label>
			 <input type="text" name="nombre" required>
			 <label for="email">Email:</label>
			 <input type="email" name="email" required>
			 <label for="id_carrera">Carrera:</label>
			 <select id="carreras" class="js-example-basic-multiple" name="id_carrera">
				  '.$st_carreras.'
			 </select>
			 <label for="password">Password:</label>
			 <input type="password" name="password" required>
			 
			
			 <input type="submit" value="Registrar">';
		echo"
		<script>
			$(document).ready(function() {
			    $('.js-example-basic-multiple').select2();
			});
		</script>";

	}


	##########################

	####### ALUMNOS ####

	#VISTA DE ALUMNOS
	#------------------------------------

	public function vistaAlumnosController(){

		$respuesta = Datos::vistaAlumnoModel("alumnos");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["matricula"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["carrera"].'</td>
				<td>'.$item["tutor"].'</td>
				<td><a href="index.php?action=editar_alumnos&matricula='.$item["matricula"].'"><button>Editar</button></a></td>
				<td><a href="index.php?action=alumnos&idBorrar='.$item["matricula"].'"><button>Borrar</button></a></td>
			</tr>';
		}
	}

	#BORRAR ALUMNO
	#------------------------------------
	public function borrarAlumnoController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarAlumnoModel($datosController, "alumnos");

			if($respuesta == "success"){
				header("location:index.php?action=alumnos");
			}
		}
	}



	#REGISTRO DE USUARIOS
	#------------------------------------
	public function registroAlumnoController(){

		if(isset($_POST["matricula"])){
			$datosController = array( "matricula"=>$_POST["matricula"], 
								      "nombre"=>$_POST["nombre"],
								      "id_carrera"=>$_POST["id_carrera"],
								      "id_tutor"=>$_POST["id_tutor"]);

			$respuesta = Datos::registroAlumnoModel($datosController, "alumnos");

			if($respuesta == "success"){
				header("location:index.php?action=ok_alumno");
			}
			else{
				header("location:index.php");
			}

		}

	}

	public function registroBaseAlumnoController(){

		$respuesta_carreras = Datos::obtenerCarrerasModel("carrera");
		$respuesta_tutores = Datos::obtenerTutoresModel("maestros");

		$st_carreras="";
		for($i=0;$i<sizeof($respuesta_carreras);$i++)
			$st_carreras=$st_carreras."<option value='".$respuesta_carreras[$i]['id']."'>".$respuesta_carreras[$i]['nombre']."</option>";

		$st_tutores="";
		for($i=0;$i<sizeof($respuesta_tutores);$i++)
			$st_tutores=$st_tutores."<option value='".$respuesta_tutores[$i]['num_empleado']."'>".$respuesta_tutores[$i]['nombre']."</option>";
		
		echo'<label for="matricula">Matricula:</label>
			 <input type="text" name="matricula">
			 <label for="nombre">Nombre:</label>
			 <input type="text" name="nombre" required>
			 <label for="id_carrera">Carrera:</label>
			 <select id="carreras" class="js-example-basic-multiple" name="id_carrera">
				  '.$st_carreras.'
			 </select>
			 <label for="id_tutor">Tutor:</label>
			 <select id="tutores" class="js-example-basic-multiple" name="id_tutor">
				  '.$st_tutores.'
			 </select>
			 <input type="submit" value="Registrar">';
		echo"
		<script>
			$(document).ready(function() {
			    $('.js-example-basic-multiple').select2();
			});
		</script>";

	}

	#EDITAR ALUMNO
	#------------------------------------

	public function editarAlumnoController(){

		$datosController = $_GET["matricula"];
		$respuesta = Datos::editarAlumnoModel($datosController, "alumnos");
		$respuesta_carreras = Datos::obtenerCarrerasModel("carrera");
		$respuesta_tutores = Datos::obtenerTutoresModel("maestros");

		$st_carreras="";
		for($i=0;$i<sizeof($respuesta_carreras);$i++)
			$st_carreras=$st_carreras."<option value='".$respuesta_carreras[$i]['id']."'>".$respuesta_carreras[$i]['nombre']."</option>";

		$st_tutores="";
		for($i=0;$i<sizeof($respuesta_tutores);$i++)
			$st_tutores=$st_tutores."<option value='".$respuesta_tutores[$i]['num_empleado']."'>".$respuesta_tutores[$i]['nombre']."</option>";
		
		echo'<input type="hidden" value="'.$respuesta["matricula"].'" name="matricula">
			 <label for="nombre">Nombre:</label>
			 <input type="text" value="'.$respuesta["nombre"].'" name="nombre" required>
			 <label for="carrera">Carrera:</label>
			 <select id="carreras" class="js-example-basic-multiple" name="carrera">
				  '.$st_carreras.'
			 </select>
			 <label for="tutor">Tutor:</label>
			 <select id="tutores" class="js-example-basic-multiple" name="tutor">
				  '.$st_tutores.'
			 </select>
			 <input type="submit" value="Actualizar">';
		echo"
		<script>
			$(document).ready(function() {
			    $('.js-example-basic-multiple').select2();
			});
			$('#carreras').val(".$respuesta['id_carrera'].");
			$('#tutores').val(".$respuesta['id_tutor'].");
		</script>";

	}


	#ACTUALIZAR ALUMNO
	#------------------------------------
	public function actualizarAlumnoController(){
		if(isset($_POST["matricula"])){
			$datosController = array( "matricula"=>$_POST["matricula"],
							          "nombre"=>$_POST["nombre"],
				                      "id_carrera"=>$_POST["carrera"],
				                      "id_tutor"=>$_POST["tutor"]
										);
			
			$respuesta = Datos::actualizarAlumnoModel($datosController, "alumnos");

			if($respuesta == "success"){
				header("location:index.php?action=cambio_alumno");
			}
			else{
				echo "error";
			}
		}
	}

	##########################

	####### CARRERAS ####

	#VISTA DE CARRERAS
	#------------------------------------

	public function vistaCarreraController(){

		$respuesta = Datos::vistaCarreraModel("carrera");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["nombre"].'</td>
				<td><a href="index.php?action=editar_carreras&id='.$item["id"].'"><button>Editar</button></a></td>
				<td><a href="index.php?action=carreras&idBorrar='.$item["id"].'"><button>Borrar</button></a></td>
			</tr>';
		}
	}

	#BORRAR CARRERAS
	#------------------------------------
	public function borrarCarreraController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarCarreraModel($datosController, "carrera");
			
			if($respuesta == "success"){
				header("location:index.php?action=carreras");
			}
		}
	}

	#EDITAR CARRERAS
	#------------------------------------

	public function editarCarreraController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarCarreraModel($datosController, "carrera");

		var_dump($respuesta);
		echo'<input type="hidden" value="'.$respuesta["id"].'" name="id">
			 <label for="nombre">Nombre:</label>
			 <input type="text" value="'.$respuesta["nombre"].'" name="nombre" required>
			 <input type="submit" value="Actualizar">';
	}


	#ACTUALIZAR CARRERAS
	#------------------------------------
	public function actualizarCarreraController(){
		if(isset($_POST["id"])){
			$datosController = array( "id"=>$_POST["id"],
							          "nombre"=>$_POST["nombre"]
										);
			var_dump($datosController);
			$respuesta = Datos::actualizarCarreraModel($datosController, "carrera");
			

			if($respuesta == "success"){
				header("location:index.php?action=cambio_carrera");
			}
			else{
				echo "error";
			}
		}
	}

	public function registroCarreraController(){

		if(isset($_POST["nombre"])){
			$datosController = array(
								      "nombre"=>$_POST["nombre"]
								  );

			$respuesta = Datos::registroCarreraModel($datosController, "carrera");
			var_dump($respuesta);
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_carrera");
			}
			else{
				header("location:index.php");
			}
			
		}

	}

	public function registroBaseCarreraController(){
		echo'<label for="nombre">Nombre:</label>
			 <input type="text" name="nombre" required>
			 <input type="submit" value="Registrar">';
	}


	###TUTORIAS

	public function vistaTutoriasController(){

		$respuesta = Datos::vistaTutoriasModel("sesion_tutoria");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["fecha"].'</td>
				<td>'.$item["hora"].'</td>
				<td>'.$item["tema"].'</td>
				<td>'.$item["tipo"].'</td>
				<td><a href="index.php?action=editar_tutoria&id='.$item["id"].'"><button>Editar</button></a></td>
				<td><a href="index.php?action=tutorias&idBorrar='.$item["id"].'"><button>Borrar</button></a></td>
			</tr>';
		}
	}

		#BORRAR CARRERAS
	#------------------------------------
	public function borrarTutoriaController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarTutoriaModel($datosController, "sesion_tutoria");
			
			if($respuesta == "success"){
				header("location:index.php?action=tutorias");
			}
		}
	}

	public function registroTutoriaController(){

		if(isset($_POST["fecha"])){
			$datosController = array(
								      "hora"=>$_POST["hora"],
								      "fecha"=>$_POST["fecha"],
								      "tema"=>$_POST["tema"],
								      "tipo"=>$_POST["tipo"],
								      "num_maestro"=>$_POST["num_maestro"]
								  );

			$respuesta = Datos::registroTutoriaModel($datosController, "sesion_tutoria");
	
			if($respuesta == "success"){
				header("location:index.php?action=ok_tutoria");
			}
			else{
				header("location:index.php");
			}
		
		}

	}

	public function registroBaseTutoriaController(){

		echo'<input type="hidden" name="num_maestro" value="'.$_SESSION['num_empleado'].'" required>
			 <label for="fecha">Fecha:</label>
			 <input type="date" name="fecha" required>
			 <label for="hora">Hora:</label>
			 <input type="time" name="hora" required>
			 <label for="tipo">Tipo:</label>
			 <select name="tipo" required>
  				<option value="Grupal">Grupal</option>
		  		<option value="Individual">Individual</option>
		  	 </select>
		     <label for="Tema">Tema:</label>
			 <input type="text" name="tema" required>
			 <input type="submit" value="Registrar">';
	}

	#EDITAR MAESTRO
	#------------------------------------

	public function editarTutoriaController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarTutoriaModel($datosController, "sesion_tutoria");
		
		echo'<input type="hidden" value="'.$respuesta["num_maestro"].'" name="num_maestro">
			 <label for="fecha">Fecha:</label>
			 <input type="date" value="'.$respuesta["fecha"].'" name="fecha" required>
			 <label for="hora">Hora:</label>
			 <input type="time" value="'.$respuesta["hora"].'" name="hora" required>
			 <label for="tipo">Tipo:</label>
			 <select id="tipos" name="tipo" required>
  				<option value="Grupal">Grupal</option>
		  		<option value="Individual">Individual</option>
		  	 </select>
		  	 <label for="tema">Tema:</label>
		  	 <input type="text" value="'.$respuesta["tema"].'" name="tema" required>
			 <input type="submit" value="Actualizar">';
		echo"
		<script>
			$('#tipos').val(".$respuesta['tipo'].");
		</script>";

	}

	#ACTUALIZAR MAESTRO
	#------------------------------------
	public function actualizarTutoriaController(){
		if(isset($_POST["id"])){
			$datosController = array( "num_empleado"=>$_POST["num_empleado"],
							          "nombre"=>$_POST["nombre"],
				                      "email"=>$_POST["email"],
				                      "password"=>$_POST["password"],
				                      "carrera"=>$_POST["carrera"]);

			$respuesta = Datos::actualizarMaestroModel($datosController, "sesion_tutoria");

			if($respuesta == "success"){
				header("location:index.php?action=cambio");
			}
			else{
				echo "error";
			}
		}
	}

}






////
?>