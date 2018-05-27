<?php

class MvcController{

	#LLAMADA A LA PLANTILLA
	#-------------------------------------
	#Permite la llamada al template de la pagina
	public function pagina(){		
		include "views/template.php";
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

	#NAVEGACION
	#-------------------------------------
	#Imprime el menu de navegacion correspondiente al nivel de privilegios que se tenga actualmente
	#(maestro/superusuario) donde en el caso de superusuario se muestran las opciones completamente.
	public function vistaNavegacionController(){

		if(isset($_COOKIE['nivel'])){
			if($_COOKIE['nivel']=="1")
				echo'
					<li><a href="index.php?action=ingresar">Ingreso</a></li>
					<li><a href="index.php?action=tutorias">Tutorias</a></li>
					<li><a href="index.php?action=maestros">Maestros</a></li>
					<li><a href="index.php?action=alumnos">Alumnos</a></li>
					<li><a href="index.php?action=carreras">Carreras</a></li>
					<li><a href="index.php?action=reportes">Reportes</a></li>
					<li><a href="index.php?action=salir">Salir</a></li>';
			else
				echo'
					<li><a href="index.php?action=ingresar">Ingreso</a></li>
					<li><a href="index.php?action=tutorias">Tutorias</a></li>
					<li><a href="index.php?action=reportes">Reportes</a></li>
					<li><a href="index.php?action=salir">Salir</a></li>';
		}

	}

	############################################################### MAESTROS #########################################################


	#Ingreso de maestros
	#------------------------------------
	#Permite controlar el ingreso al sistema ademas generando la variable cookie que almacena el tipo de usuario que es (maestro/superadmin)
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
				setcookie("nivel",$respuesta["nivel"], time() + (86400 * 30), "/");
				header("location:index.php?action=tutorias");
			}
			else{
				header("location:index.php?action=fallo");
			}
		}
	}

	#Registro de maestros
	#------------------------------------
	#Permite hacer un registro de un maestro a en la bd.
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

	#Vista de maestros
	#------------------------------------
	#Interfaz de los maestros, imprime los componentes de la misma
	public function vistaMaestrosController(){

		$respuesta = Datos::vistaMaestrosModel("maestros");

		foreach($respuesta as $row => $item){
			$item["nivel"]=$item["nivel"]==1?"SuperAdmin":"Maestro";
		echo'<tr>
				<td>'.$item["num_empleado"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["email"].'</td>
				<td>'.$item["nombre_carrera"].'</td>
				<td>'.$item["nivel"].'</td>
				<td><a href="index.php?action=editar_maestro&num_empleado='.$item["num_empleado"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=maestros&idBorrar='.$item["num_empleado"].'"><button onclick="wait();" class="small alert">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        function wait(){
		          var r = confirm("¿Desea eliminar el usuario?");
		          if (!r) 
		              event.preventDefault();
		        }
		    </script>';
		}

	}

	#Editar Maestro
	#------------------------------------
	#permite controlar la edicion de un maestro imprimiendo la interfaz con los valores de la bd del registro seleccionado.
	public function editarMaestroController(){

		$datosController = $_GET["num_empleado"];
		$respuesta = Datos::editarMaestroModel($datosController, "maestros");
		$respuesta_select = Datos::obtenerCarrerasModel("carrera");

		$st_carreras="";
		for($i=0;$i<sizeof($respuesta_select);$i++)
			$st_carreras=$st_carreras."<option value='".$respuesta_select[$i]['id']."'>".$respuesta_select[$i]['nombre']."</option>";
		
		echo'<input type="hidden" value="'.$respuesta["num_empleado"].'" name="num_empleado">
			 <label for="nombre">Nombre:</label>
			 <input type="text" value="'.$respuesta["nombre"].'" name="nombre" required>
			 <label for="email">Email:</label>
			 <input type="text" value="'.$respuesta["email"].'" name="email" required>
			 <label for="password">Password:</label>
			 <input type="password" value="'.$respuesta["password"].'" name="password" required>
			 <label for="carrera">Carrera:</label>
			 <select id="carreras" class="js-example-basic-multiple" name="carrera">
				  '.$st_carreras.'
			 </select>
			 <br><br>
			 <label for="nivel">Nivel:</label>
 			 <select name="nivel" id="nivel">
			 	<option value="0">Maestro</option>
			 	<option value="1">SuperAdmin</option>
			 </select> 
			 <input type="submit" value="Actualizar">';
		echo"
		<script>
			$(document).ready(function() {
			    $('.js-example-basic-multiple').select2();
			});
			$('#carreras').val(".$respuesta['id_carrera'].");
			$('#nivel').val(".$respuesta['nivel'].");
		</script>";

	}

	#Actualizar Maestro
	#------------------------------------
	#Permite la actualizacion de un maestro en la base de datos.
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
	#Controla el borrado de un maestro y ademas muestra un mensaje de error en caso de que este no se cumpla.
	public function borrarMaestroController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarMaestroModel($datosController, "maestros");
			
			if($respuesta == "success"){
				header("location:index.php?action=maestros");
			}else{
				echo('<script> alert("El maestro no pudo ser eliminado, debido a que existen elementos dependientes a el (tutorias, alumnos), elimine primero esos elementos."); </script>');
			}
		}
	}

	#REGISTRO DE MAESTROS
	#------------------------------------
	#Se encarga de controlar un registro o agregado de un maestro, recibiendo todos los valores del mismo y
	#almacenandolos en la bd
	public function registroMaestroController(){

		if(isset($_POST["num_empleado"])){
			$datosController = array( "num_empleado"=>$_POST["num_empleado"], 
								      "nombre"=>$_POST["nombre"],
								      "email"=>$_POST["email"],
								      "password"=>$_POST["password"],
								  	  "id_carrera"=>$_POST["id_carrera"],
								  	  "nivel"=>$_POST["nivel"]);

			$respuesta = Datos::registroMaestroModel($datosController, "maestros");

			if($respuesta == "success"){
				header("location:index.php?action=ok_maestro");
			}
			else{
				header("location:index.php");
			}
		}
	}

	#REGISTRO DE BASE DE MAESTROS
	#------------------------------------
	#Genera la interfazbase para realizar un registro de un maestro
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
			 <br><br>
			 <label for="password">Password:</label>
			 <input type="password" name="password" required>
			 <label for="nivel">Nivel:</label>
			 <select name="nivel">
			 	<option value="0">Maestro</option>
			 	<option value="1">SuperAdmin</option>
			 </select> 
			
			 <input type="submit" value="Registrar">';
		echo"
		<script>
			$(document).ready(function() {
			    $('.js-example-basic-multiple').select2();
			});
		</script>";

	}



	############################################################### ALUMNOS #########################################################

	#VISTA DE ALUMNOS
	#------------------------------------
	#Se encarga de controlar la vista de la interfaz de alumnos
	public function vistaAlumnosController(){

		$respuesta = Datos::vistaAlumnoModel("alumnos");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["matricula"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["carrera"].'</td>
				<td>'.$item["tutor"].'</td>
				<td><a href="index.php?action=editar_alumnos&matricula='.$item["matricula"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=alumnos&idBorrar='.$item["matricula"].'"><button class="small alert">Borrar</button></a></td>
			</tr>';
		}
	}

	#BORRAR ALUMNO
	#------------------------------------
	#Permite el borrado de un alumno de la base de datos.
	public function borrarAlumnoController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarAlumnoModel($datosController, "alumnos");

			if($respuesta == "success"){
				header("location:index.php?action=alumnos");
			}else{
				echo('<script> alert("El alumno no pudo ser eliminado, debido a que existen elementos dependientes a el, elimine primero esos elementos."); </script>');
			}
		}
	}


	#REGISTRO DE ALUMNOS
	#------------------------------------
	#Permite realizar el registro de algun alumno en la base de datos.
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

	#REGISTRO DE BASE DE ALUMNOS
	#------------------------------------
	#Genera una interfaz base donde para la modificacion de un alumno.
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
	#Controla la edicion de un alumno permitiendo su actualizacion en la base de datos mostrando la interfaz
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
	#Permite realizar el update en la base de datos de un alumno
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

	############################################################### CARRERAS #########################################################

	#VISTA DE CARRERAS
	#------------------------------------
	#Genera la interfaz de las carreras mostrando una tabla para su edicion o eliminacion
	public function vistaCarreraController(){

		$respuesta = Datos::vistaCarreraModel("carrera");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["nombre"].'</td>
				<td><a href="index.php?action=editar_carreras&id='.$item["id"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=carreras&idBorrar='.$item["id"].'"><button class="small alert">Borrar</button></a></td>
			</tr>';
		}
	}

	#BORRAR CARRERAS
	#------------------------------------
	#Permite borrar alguna carrera seleccionada dependiendo de el id ingresado por el metodo get
	public function borrarCarreraController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarCarreraModel($datosController, "carrera");
			
			if($respuesta == "success"){
				header("location:index.php?action=carreras");
			}else{
				echo('<script> alert("La carrera no pudo ser eliminado, debido a que existen elementos dependientes a el (alumnos, maestros, tutorias), elimine primero esos elementos."); </script>');
			}
		}
	}

	#EDITAR CARRERAS
	#------------------------------------
	#GEnera la interfaz llena de la edicion de carreras
	public function editarCarreraController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarCarreraModel($datosController, "carrera");

		echo'<input type="hidden" value="'.$respuesta["id"].'" name="id">
			 <label for="nombre">Nombre:</label>
			 <input type="text" value="'.$respuesta["nombre"].'" name="nombre" required>
			 <input type="submit" value="Actualizar">';
	}

	#ACTUALIZAR CARRERAS
	#------------------------------------
	#Permite la actualizacion de la carrera al realizar la actualizacion en la base de datos.
	public function actualizarCarreraController(){
		if(isset($_POST["id"])){
			$datosController = array( "id"=>$_POST["id"],
							          "nombre"=>$_POST["nombre"]
										);
			$respuesta = Datos::actualizarCarreraModel($datosController, "carrera");
			

			if($respuesta == "success"){
				header("location:index.php?action=cambio_carrera");
			}
			else{
				echo "error";
			}
		}
	}

	#REGISTRO CARRERAS
	#------------------------------------
	#Permite el registro de la carrera en la base de datos
	public function registroCarreraController(){

		if(isset($_POST["nombre"])){
			$datosController = array(
								      "nombre"=>$_POST["nombre"]
								  );

			$respuesta = Datos::registroCarreraModel($datosController, "carrera");
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_carrera");
			}
			else{
				header("location:index.php");
			}
			
		}

	}


	#REGISTRO CARRERAS
	#------------------------------------
	#Permite generar la interfaz base para la edicion de una carrera
	public function registroBaseCarreraController(){
		echo'<label for="nombre">Nombre:</label>
			 <input type="text" name="nombre" required>
			 <input type="submit" value="Registrar">';
	}


	############################################################### TUTORIAS #########################################################

	#REGISTRO TUTORIAS
	#------------------------------------
	#Genera la interfaz que muestra en una tabla todos los registros almacenados
	public function vistaTutoriasController(){
		if($_COOKIE['nivel']==1)
			$respuesta = Datos::vistaTutoriasModel("sesion_tutoria");
		else
			$respuesta = Datos::vistaTutoriasNivelModel("sesion_tutoria",$_SESSION["num_empleado"]);		
		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["fecha"].'</td>
				<td>'.$item["hora"].'</td>
				<td>'.$item["tema"].'</td>
				<td>'.$item["tipo"].'</td>
				<td><a href="index.php?action=editar_tutoria&id='.$item["id"].'"><button class="small warning">Editar</button></a></td>
				<td><a href="index.php?action=tutorias&idBorrar='.$item["id"].'"><button class="small alert">Borrar</button></a></td>
			</tr>';
		}
	}

	#BORRAR TUTORIAS
	#------------------------------------
	#Permite el eliminado de las tutorais llamando el modelo
	public function borrarTutoriaController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];
			$respuesta = Datos::borrarAlumnosTutoriaModel($datosController, "sesion_alumnos");
			$respuesta = Datos::borrarTutoriaModel($datosController, "sesion_tutoria");
			
			if($respuesta == "success"){
				header("location:index.php?action=tutorias");
			}
		}
	}

	#REGISTRAR TUTORIAS
	#------------------------------------
	#Permite el registro de una tutoria en la base de datos
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
			
			if(isset($_POST['hid'])){
				$data = $_POST['hid'];

				$id_sesion = Datos::ObtenerLastTutoria("sesion_tutoria");

				$respuesta = Datos::registroAlumnosTutoriaModel($data, $id_sesion[0], "sesion_alumnos");
		  	}
		  	
			if($respuesta == "success"){
				header("location:index.php?action=ok_tutoria");
			}
			else{
				header("location:index.php");
			}
		
		}
		
	}

	#REGISTRO BASE DE TUTORIAS
	#------------------------------------
	#Genera la interfaz base para el registro de las tutorias
	public function registroBaseTutoriaController(){
		if($_COOKIE['nivel']==1)
			$respuesta_alumnos = Datos::obtenerAlumnosModel("alumnos");
		else
			$respuesta_alumnos = Datos::obtenerAlumnosNivelModel("alumnos",$_SESSION['num_empleado']);

		$st_alumnos="";
		for($i=0;$i<sizeof($respuesta_alumnos);$i++)
			$st_alumnos=$st_alumnos."<option value='".$respuesta_alumnos[$i]['matricula']."'>".$respuesta_alumnos[$i]['nombre']."</option>";


		echo'
			<input type="hidden" id="hid" name="hid"></input>
			<table>
				<tr>
					<td>
						<h4>Detalles en la tutoria</h4>
						<input type="hidden" name="num_maestro" value="'.$_SESSION['num_empleado'].'" required>
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
						<button class="small success" onclick="sendData();" type="submit">Registrar</button>
						
					</td>
					<td>
						<h4>Alumnos en la tutoria</h4>
						<table>
							<tr>
								<td>
								 <label for="alumno">Nombre del Alumno:</label>
								 <select name="alumno" class="js-example-basic-multiple" id="alumno">
								 	'.$st_alumnos.'
								 </select>
								 <br><br>
							</td>
							 <td>
							 	<button type="button" class="small success" onclick="addAlumno()">Agregar Alumno</button>
							 </td>
						</tr>
						<table>
						<table id="alumnos"></table>
					</td>
				</tr>
			</table>';

		echo'<script>
				$(document).ready(function() {
					$(".js-example-basic-multiple").select2();
				});

				var alumnos=[];
				var send_alumnos=[];
				var tab = document.getElementById("alumnos");

				function updateTable(){
					tab.innerHTML="<tr><th>Matricula</th><th>Nombre</th><th>¿Eliminar?</th><tr>";
					for(var i=0;i<alumnos.length;i++){
						tab.innerHTML=tab.innerHTML+"<tr><td>"+alumnos[i][0]+"</td><td>"+alumnos[i][1]+"</td><td><button class=\'alert\' type=\'button\' onclick=\'deleteAlumno("+i+");\'>Eliminar</button></td><tr>";
					}
				}

				function addAlumno(){
					
					var select = document.getElementById("alumno");
					var flag=false;
					for(var i=0;i<alumnos.length;i++){
						if(alumnos[i][0]==select.options[select.selectedIndex].value && alumnos[i][1]==select.options[select.selectedIndex].text){
							flag=true;
							break;
						}
					}

					if(!flag){
						alumnos.push([select.options[select.selectedIndex].value,select.options[select.selectedIndex].text]);
						send_alumnos.push([select.options[select.selectedIndex].value]);
						updateTable();						
					}else{
						alert("Alumno ya Agregado");
					}
				}

				function deleteAlumno(index){
					alumnos.splice(index, 1);
					send_alumnos.splice(index, 1);
					updateTable();
				}

				function sendData(){
					var hid = document.getElementById("hid");
					hid.value=send_alumnos;
				}

			</script>';
	}

	#EDICION DE TUTORIAS
	#------------------------------------
	#Se encarga de controlar la edicion de una tutoria
	public function editarTutoriaController(){

		$datosController = $_GET["id"];
		$respuesta = Datos::editarTutoriaModel($datosController, "sesion_tutoria");
		
		$respuesta_alumnos = Datos::obtenerAlumnosModel("alumnos");
		$respuesta_alumnosTutoria = Datos::obtenerAlumnosTutoriaModel($datosController,"sesion_alumnos");

		$st_alumnos="";
		for($i=0;$i<sizeof($respuesta_alumnos);$i++)
			$st_alumnos=$st_alumnos."<option value='".$respuesta_alumnos[$i]['matricula']."'>".$respuesta_alumnos[$i]['nombre']."</option>";

		echo'
			<input type="hidden" id="hid" name="hid"></input>
			<table>
				<tr>
					<td>
						<h4>Detalles en la tutoria</h4>
						<input type="hidden" value="'.$respuesta["num_maestro"].'" name="num_maestro">
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
						 <button class="small success" onclick="sendData();" type="submit">Actualizar</button>
					<td>
						<h4>Alumnos en la tutoria</h4>
						<table>
							<tr>
								<td>
								 <label for="alumno">Nombre del Alumno:</label>
								 <select name="alumno" class="js-example-basic-multiple" id="alumno">
								 	'.$st_alumnos.'
								 </select>
								 <br><br>
							</td>
							 <td>
							 	<button type="button" class="small success" onclick="addAlumno()">Agregar Alumno</button>
							 </td>
						</tr>
						<table>
						<table id="alumnos"></table>
					</td>
				</tr>
			</table>';

		echo'
		<script>
			$("#tipos").val("'.$respuesta["tipo"].'");
			$(document).ready(function() {
				$(".js-example-basic-multiple").select2();
				fillTable();
			});

			var alumnos=[];
			var send_alumnos=[];
			var tab = document.getElementById("alumnos");


			function fillTable(){
				var resp_at = '.json_encode($respuesta_alumnosTutoria).';
				alumnos=resp_at;
				for(var i=0;i<alumnos.length;i++){
					send_alumnos[i]=alumnos[i][0];
				}
				updateTable();
			}

			function updateTable(){
				tab.innerHTML="<tr><th>Matricula</th><th>Nombre</th><th>¿Eliminar?</th><tr>";
				for(var i=0;i<alumnos.length;i++){
					tab.innerHTML=tab.innerHTML+"<tr><td>"+alumnos[i][0]+"</td><td>"+alumnos[i][1]+"</td><td><button class=\'alert\' type=\'button\' onclick=\'deleteAlumno("+i+");\'>Eliminar</button></td><tr>";
				}
			}

			function addAlumno(){
				
				var select = document.getElementById("alumno");
				var flag=false;
				for(var i=0;i<alumnos.length;i++){
					if(alumnos[i][0]==select.options[select.selectedIndex].value && alumnos[i][1]==select.options[select.selectedIndex].text){
						flag=true;
						break;
					}
				}

				if(!flag){
					alumnos.push([select.options[select.selectedIndex].value,select.options[select.selectedIndex].text]);
					send_alumnos.push([select.options[select.selectedIndex].value]);
					updateTable();						
				}else{
					alert("Alumno ya Agregado");
				}
			}

			function deleteAlumno(index){
				alumnos.splice(index, 1);
				send_alumnos.splice(index, 1);
				updateTable();
			}

			function sendData(){
				var hid = document.getElementById("hid");
				hid.value=send_alumnos;
			}
		</script>';


	}

	#ACTUALIZAR TUTORIAS
	#------------------------------------
	#Permite la actualizacion de la tutoria, al registrarlo en lab base de datos, realiza una eliminacion
	#completa de los alumnos para volver a realizar su insercion
	public function actualizarTutoriaController(){
		if(isset($_POST["hora"])){
			$datosController = array( "id"=>$_GET["id"],
							          "fecha"=>$_POST["fecha"],
				                      "hora"=>$_POST["hora"],
				                      "tipo"=>$_POST["tipo"],
				                      "tema"=>$_POST["tema"]);

			$respuesta = Datos::actualizarTutoriaModel($datosController, "sesion_tutoria");

			$respuesta = Datos::borrarAlumnosTutoriaModel($_GET["id"], "sesion_alumnos");
			
			$data = $_POST['hid'];

			$respuesta = Datos::registroAlumnosTutoriaModel($data, $_GET["id"], "sesion_alumnos");
		  	
			

			if($respuesta == "success"){
				header("location:index.php?action=cambio_tutoria");
			}
			else{
				echo "error";
			}
		}
	}


	#VISTA MAESTROS REPORTES
	#------------------------------------
	#Genera la tabla de los reportes de maestros
	public function vistaReporteMaestrosController(){

		$respuesta = Datos::vistaMaestrosModel("maestros");

		foreach($respuesta as $row => $item){
			$item["nivel"]=$item["nivel"]==1?"SuperAdmin":"Maestro";
		echo'<tr>
				<td>'.$item["num_empleado"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["email"].'</td>
				<td>'.$item["nombre_carrera"].'</td>
				<td>'.$item["nivel"].'</td>
			</tr>';
		}

		echo'<script>
				$(document).ready( function () {
				    $("#table_maestros").DataTable();
				} );		
			</script>';

	}


	#VISTA ALUMNOS REPORTES
	#------------------------------------
	#Genera la tabla de los reportes de alumnos
	public function vistaReporteAlumnosController(){

		$respuesta = Datos::vistaAlumnoModel("alumnos");

		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["matricula"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["carrera"].'</td>
				<td>'.$item["tutor"].'</td>
			</tr>';
		}


		echo'<script>
				$(document).ready( function () {
				    $("#table_alumnos").DataTable();
				} );		
			</script>';
	}

	#VISTA TUTORIAS REPORTES
	#------------------------------------
	#Genera la tabla de los reportes de tutorias
	public function vistaReporteTutoriasController(){
		if($_COOKIE['nivel']==1)
			$respuesta = Datos::vistaTutoriasModel("sesion_tutoria");
		else
			$respuesta = Datos::vistaTutoriasNivelModel("sesion_tutoria",$_SESSION["num_empleado"]);		
		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["fecha"].'</td>
				<td>'.$item["hora"].'</td>
				<td>'.$item["tema"].'</td>
				<td>'.$item["tipo"].'</td>
			</tr>';
		}


		echo'<script>
				$(document).ready( function () {
				    $("#table_tutorias").DataTable();
				} );		
			</script>';
	}
}






////
?>