<?php

class MvcController{

	#Llamada a la plantilla
	#-------------------------------------
	#Permite la llamada al template de la pagina
	public function pagina(){
		include "views/template.php";
	}

	#Enlaces
	#-------------------------------------
	#Permite controlar los enlaces que existen entre las vistas de la pagina, haciendo uso del modelo
	public function enlacesPaginasController(){
		if(isset( $_GET['action']))		
			$enlaces = $_GET['action'];
		else
			$enlaces = "index";
		$respuesta = Paginas::enlacesPaginasModel($enlaces);
		include $respuesta;
		return $respuesta;
	}

	#Ingreso de usuarios
	#------------------------------------
	#Se encarga de revisar la cuenta ingresada y conceder los permisos debidos para el acceso a la
	#interfaz admin del sistema, ademas, redireccionando en caso de que este no sea exitoso
	public function ingresoUsuarioController(){

		if(isset($_POST["user"])){
			$datosController = array( "user"=>$_POST["user"], 
								      "pass"=>$_POST["pass"]);
			$respuesta = Datos::ingresoUsuarioModel($datosController, "users");
			
			if($respuesta["user"] == $_POST["user"] && $respuesta["pass"] == md5($_POST["pass"])){
				if(!isset($_SESSION)) 
					session_start();
				$_SESSION["validar"] = true;
				header("location:index.php?action=dashboard");
			}
			else{
				header("location:index.php?action=fallo");
			}
		}
	}

	#Permite subir una imagen al servidor
	#------------------------------------
	#Ingresa la imagen en el servidor
	public function upload(){
		$target_dir = dirname($_SERVER["SCRIPT_FILENAME"])."/views/images/";
		$new_name= date("Y-m-d-H-i-s") . basename($_FILES["fileToUpload"]["name"]);
		$target_file = $target_dir . $new_name;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$error="";

	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) 
	        $uploadOk = 1;
	    else {
	        $error = "El archivo no es una imagen.";
	        $uploadOk = 0;
	    }
	    if (file_exists($target_file)) {
		    $error = "El archivo ya existe.";
		    $uploadOk = 0;
		}
		if ($_FILES["fileToUpload"]["size"] > 5000000) {
		    $error = "El archivo es muy grande.";
		    $uploadOk = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "JPG" && $imageFileType != "jpeg") {
		    $error = "Solo puede subir archivos jpg y png";
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
		    $error = "El archivo no pudo ser subido.";
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    } else {
		        $error = "No se pudo subir el archivo";
		        echo('<script> swal("Error", "'.$error.'", "error");</script>');
		    }
		}
		return $new_name;
	}
	


	#BOtener los valores del select de los grupos
	#------------------------------------
	#Genera el codigo el codigo de select 
	public function getSelect(){
		$respuesta_grupos = Datos::obtenerGruposModel("grupos");

		$st_grupo="";
		for($i=0;$i<sizeof($respuesta_grupos);$i++)
			$st_grupo=$st_grupo."<option value='".$respuesta_grupos[$i]['id']."'>".$respuesta_grupos[$i]['nombre']."</option>";

		return $st_grupo;
	}

	#Obtiene los valores del select de las alumnas 
	#------------------------------------
	#Obtiene el codigo para el select de los alumnos dependiendo de un id
	public function getAlumnasFromId($id){
		$respuesta_grupos = Datos::obtenerAlumnasFromGroupModel($id,"alumnas");

		$st_grupo="";
		for($i=0;$i<sizeof($respuesta_grupos);$i++)
			$st_grupo=$st_grupo."<option value='".$respuesta_grupos[$i]['id']."'>".$respuesta_grupos[$i]['nombre']."</option>";

		return $st_grupo;
	}


	############################################ ALUMNAS ############################################ 
	#Vista de categorias
	#------------------------------------
	#CRUD de las alumnas, llenando la tabla con todos los registros
	public function vistaAlumnaController(){

		$respuesta = Datos::vistaAlumnasModel("alumnas");
		
		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["apellido_paterno"].'</td>
				<td>'.$item["grupo"].'</td>
				<td><a href="index.php?action=editar_alumna&id='.$item["id"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
				<td><button onClick="wait();" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        function wait(){
					swal({
					  title: "¿Esta seguro que desea eliminar esta alumna?",
					  text: "Al eliminar esta alumna tambien se eliminara toda la informacion relacionada a la misma",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then((willDelete) => {
					  if (willDelete) {
					    window.location.href = "./index.php?action=alumnas&idBorrar='.$item["id"].'";
					  }
					});	  		
		        }
		    </script>';
		}
	}


	#Registro base de alumnos
	#------------------------------------
	#Interfaz base del registro de alumnos, imprime los componentes para la vista de registro 
	public function registroBaseAlumnaController(){
		$respuesta_grupos = Datos::obtenerGruposModel("grupos");

		$st_grupo="";
		for($i=0;$i<sizeof($respuesta_grupos);$i++)
			$st_grupo=$st_grupo."<option value='".$respuesta_grupos[$i]['id']."'>".$respuesta_grupos[$i]['nombre']."</option>";

		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" required>
			 <label for="apellido_paterno">Apellido Paterno:</label>
			 <input class="form-control" type="text" name="apellido_paterno" required>
			 <label for="id_grupo">Grupo:</label>
			 <select id="categorias" class="form-control js-example-basic-multiple" name="id_grupo">
				  '.$st_grupo.'
			 </select>
			 <br>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary float-right" value="Registrar">
			 </div>';
	}


	#Registro alumna
	#------------------------------------
	#Registro de alumna en la base de datos, ingresando su nombre, apellido_paterno y el id del grupo correspondiente
	public function registroAlumnaController(){

		if(isset($_POST["nombre"])){
			$datosController = array(
								      "nombre"=>$_POST["nombre"],
								      "apellido_paterno"=>$_POST["apellido_paterno"],
								      "id_grupo"=>$_POST["id_grupo"]
								  );

			$respuesta = Datos::registroAlumnaModel($datosController, "alumnas");
			
			
			if($respuesta == "success"){
				header("location:index.php?action=ok_alumna");
			}
			else{
				header("location:index.php");
			}
			
		}

	}


	#Borrar alumna
	#------------------------------------
	#Permite el borrado de una alumna de la base de datos
	public function borrarAlumnaController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarAlumnaModel($datosController, "alumnas");			
			
			if($respuesta == "success"){
				header("location:index.php?action=alumnas");
			}else{
				echo('<script> swal("Error", "La alumna no pudo ser eliminada", "error");</script>');
			}
		}
	}

	#Editar alumnas
	#------------------------------------
	#Permite la edicion de las alumnas impriendo la interfaz conl os valroes registrados de determinado registro 
	public function editarAlumnaController(){
		$datosController = $_GET["id"];
		$respuesta = Datos::editarAlumnaModel($datosController, "alumnas");

		$respuesta_grupos = Datos::obtenerGruposModel("grupos");

		$st_grupo="";
		for($i=0;$i<sizeof($respuesta_grupos);$i++)
			$st_grupo=$st_grupo."<option value='".$respuesta_grupos[$i]['id']."'>".$respuesta_grupos[$i]['nombre']."</option>";

		echo'<input type="hidden" value="'.$respuesta['id'].'" name="id">
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" value="'.$respuesta["nombre"].'" required>
			 <label for="apellido_paterno">Apellido Paterno:</label>
			 <input class="form-control" type="text" name="apellido_paterno" value="'.$respuesta["apellido_paterno"].'" required>
			 <label for="id_grupo">Grupo:</label>
			 <select id="categorias" class="form-control js-example-basic-multiple" name="id_grupo">
				  '.$st_grupo.'
			 </select>
			 <br>
			 <div class="card-footer">
			 	<input type="button" onclick="wait();" class="btn btn-primary float-right" value="Actualizar">
			 </div>';

		echo'
		<script>

			function wait(){		
				swal({
				  title: "¿Esta seguro que desea modificar esta alumna?",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
				  	document.getElementById("cat").submit();
				  }
				});		
			}
		</script>';
	}


	#Actualizar alumna
	#------------------------------------
	#Permite la actualizacion de una alumna
	public function actualizarAlumnaController(){
		if(isset($_POST["id"])){
			$datosController = array( "id"=>$_POST["id"],
							          "nombre"=>$_POST["nombre"],
							          "apellido_paterno"=>$_POST["apellido_paterno"],
							          "id_grupo"=>$_POST["id_grupo"],
									);
			$respuesta = Datos::actualizarAlumnaModel($datosController, "alumnas");
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_alumna");
			}
			else{
				echo "error";
			}
		}
	}

	######################################TERMINA ALUMNOS########################################### 



	############################################ GRUPOS ############################################ 
	#Vista de los grupos
	#------------------------------------
	#Muestra la interfaz de todos los grupos que se encuentran registrados en el sistema.
	public function vistaGrupoController(){

		$respuesta = Datos::vistaGrupoModel("grupos");	#Cargando todos los grupos
		
		#Llenando la tabla
		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["nombre"].'</td>
				<td><a href="index.php?action=editar_grupo&id='.$item["id"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
				<td><button onClick="wait();" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
			</tr>';
		echo ' 
			<script type="text/javascript">
		        function wait(){
					swal({
					  title: "¿Esta seguro que desea eliminar este grupo?",
					  text: "Al eliminar este grupo tambien se eliminara toda la informacion relacionada a la misma",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then((willDelete) => {
					  if (willDelete) {
					    window.location.href = "./index.php?action=grupos&idBorrar='.$item["id"].'";
					  }
					});	  		
		        }
		    </script>';
		}
	}


	#Registro base de Grupo
	#------------------------------------
	#Interfaz base para el registro de grupos, imprimiendo los componentes que se usaran para registrar un grupo.
	public function registroBaseGrupoController(){
		$respuesta_grupos = Datos::obtenerGruposModel("grupos");

		echo'<label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" required>
			 <br>
			 <div class="card-footer">
			 	<input type="submit" class="btn btn-primary float-right" value="Registrar">
			 </div>';
	}


	#Proceso para registro de un grupo
	#------------------------------------
	#Se hace el registro de un grupo en la base de datos y ademas redirige a la vista de todos los grupos en caso exitoso
	#y regresa al index en caso fallido.
	public function registroGrupoController(){

		if(isset($_POST["nombre"])){
			$datosController = array("nombre"=>$_POST["nombre"]);

			$respuesta = Datos::registroGrupoModel($datosController, "grupos");
			
			if($respuesta == "success")
				header("location:index.php?action=ok_grupo");
			else
				header("location:index.php");
		}

	}


	#Borrado de grupo
	#------------------------------------
	#Permite el borrado de un grupo del sistema, ademas mostrando un mensaje de alerta en caso de que
	#este proceso sea fallido.
	public function borrarGrupoController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarAlumnaModel($datosController, "grupos");			
			
			if($respuesta == "success")
				header("location:index.php?action=grupos");
			else
				echo('<script> swal("Error", "El grupo no pudo ser eliminada", "error");</script>');
		}
	}

	#Editar Grupo
	#------------------------------------
	#Permite la edicion de grupos imprimiendo la interfaz base con los valores registrados en la base de datos
	#y ademas agregando un SweetAlert para confirmacion de edicion.
	public function editarGrupoController(){
		$datosController = $_GET["id"];
		$respuesta = Datos::editarGrupoModel($datosController, "grupos");

		echo'<input type="hidden" value="'.$respuesta['id'].'" name="id">
			 <label for="nombre">Nombre:</label>
			 <input class="form-control" type="text" name="nombre" value="'.$respuesta["nombre"].'" required>
			 <br>
			 <div class="card-footer">
			 	<input type="button" onclick="wait();" class="btn btn-primary float-right" value="Actualizar">
			 </div>';

		echo'
		<script>

			function wait(){		
				swal({
				  title: "¿Esta seguro que desea modificar este grupo?",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
				  	document.getElementById("cat").submit();
				  }
				});		
			}
		</script>';
	}


	#Actualizar grupo
	#------------------------------------
	#Permite la actalizacion del grupo en la base de datos, recibiendo su id y el nombre del grupo
	#para sobreescribir estos valores.
	public function actualizarGrupoController(){
		if(isset($_POST["id"])){
			$datosController = array( "id"=>$_POST["id"],
							          "nombre"=>$_POST["nombre"]
									);
			$respuesta = Datos::actualizarGrupoModel($datosController, "grupos");
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_grupo");
			}
			else{
				echo "error";
			}
		}
	}
	###################################### TERMINA GRUPOS ############################################ 




	############################################ PAGOS ############################################ 
	#Registro de pagos
	#------------------------------------
	#Registra un pago en lab ase de datos
	public function registroPagoController(){
		if(isset($_POST["id_alumna"])){
			$file="";
			if(isset($_FILES))
				$file=$this->upload($_FILES);
			$datosController = array(
								      "id_alumna"=>$_POST["id_alumna"],
								      "nombre_mama"=>$_POST["nombre_mama"]." ".$_POST["apellido_mama"],
								      "fecha_pago"=>date('Y-m-d H:i:s', strtotime($_POST["fecha_pago"])),
								      "fecha_envio"=>date("Y-m-d H:i:s"),
								      "url_imagen"=>$file,
									  "folio"=>$_POST["folio"]
								  );

			$respuesta = Datos::registroPagoModel($datosController, "pagos");
			
			if($respuesta == "success"){
				header("location:index.php?action=p_lugares");
			}
			else{
				header("location:index.php");
			}
		}

	}
	#Vista de los pagos
	#------------------------------------
	#Muestra la interfaz de todos los pagos que se encuentran registrados en el sistema.
	public function vistaPublicPagoController(){

		$respuesta = Datos::vistaPublicPagoModel("pagos");	#Cargando todos los grupos
		
		#Llenando la tabla
		foreach($respuesta as $row => $item){
		echo'<tr>
				<td>'.$item["id"].'</td>
				<td>'.$item["nombre"].'</td>
				<td>'.$item["nombre_mama"].'</td>
				<td>'.$item["fecha_envio"].'</td>
				<td>'.$item["folio"].'</td>
			</tr>';
		}
	}

	#Vista de los pagos
	#------------------------------------
	#Muestra la interfaz de todos los pagos que se encuentran registrados en el sistema.
	public function vistaPagoController(){

		$respuesta = Datos::vistaPagoModel("pagos");	#Cargando todos los grupos
		
		#Llenando la tabla
		foreach($respuesta as $row => $item){
			echo'<tr>
					<td>'.$item["id"].'</td>
					<td>'.$item["nombre"].'</td>
					<td>'.$item["nombre_mama"].'</td>
					<td>'.$item["fecha_envio"].'</td>
					<td>'.$item["fecha_pago"].'</td>
					<td>'.$item["folio"].'</td>
					<td><a href="./views/images/'.$item["url_imagen"].'"><button class="btn btn-block btn-info btn-md">Ver Imagen</button></a></td>
					<td><a href="index.php?action=editar_pago&id='.$item["id"].'"><button class="btn btn-block btn-warning btn-md">Editar</button></a></td>
					<td><button onClick="wait('.$item['id'].');" class="btn btn-block btn btn-danger btn-md">Borrar</button></a></td>
				</tr>';
		
		echo ' 
			<script type="text/javascript">
		        function wait(id){
					swal({
					  title: "¿Esta seguro que desea eliminar este pago?",
					  text: "Al eliminar esta pago tambien se eliminara toda la informacion relacionada a la misma",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then((willDelete) => {
					  if (willDelete) {
					    window.location.href = "./index.php?action=pagos&idBorrar="+id;
					  }
					});	  		
		        }
		    </script>';
		}
	}


	#Borrado de grupo
	#------------------------------------
	#Permite el borrado de un grupo del sistema, ademas mostrando un mensaje de alerta en caso de que
	#este proceso sea fallido.
	public function borrarPagoController(){

		if(isset($_GET["idBorrar"])){
			$datosController = $_GET["idBorrar"];

			$respuesta = Datos::borrarPagoModel($datosController, "pagos");			
			
			if($respuesta == "success")
				header("location:index.php?action=pagos");
			else
				echo('<script> swal("Error", "El grupo no pudo ser eliminada", "error");</script>');
		}
	}

	#Editar Grupo
	#------------------------------------
	#Permite la edicion de grupos imprimiendo la interfaz base con los valores registrados en la base de datos
	#y ademas agregando un SweetAlert para confirmacion de edicion.
	public function editarPagoController(){
		$datosController = $_GET["id"];
		$respuesta = Datos::editarPagosModel($datosController, "pagos");

		$st_grupo = $this->getSelect();
		

		echo'<label for="id_grupo">Seleccione grupo</label>
			<input type="hidden" name="id_pago" value="'.$respuesta['id_pago'].'"></input>
            <select id="grupos" class="form-control js-example-basic-multiple" name="id_grupo" required>
			  '.$st_grupo.'?>
			</select>
			<br>
			<label for="id_grupo">Seleccione alumna</label>
			<select id="alumnas" class="form-control js-example-basic-multiple" name="id_alumna" required>
			</select>
			<br>
			<div class="row">
				<div class="col-md-6">
					<label for="nombre_mama">Nombre de la mama</label>
					<input class = "form-control" type="text" name="nombre_mama" value="'.$respuesta['nombre_mama'].'" required>
				</div>
			</div>
			
			<div class="form-group"> 
				<label for="fecha_pago">Fecha de pago:</label>
				<div class="input-group">
					<div class="input-group-prepend">
					  <span class="input-group-text">
					    <i class="fa fa-calendar"></i>
					  </span>
					</div>
				<input type="datetime" name="fecha_pago" class="form-control pull-right" id="dtp" value="'.$respuesta['fecha_pago'].'" required>
				</div>
            </div>

            <div class="form-group"> 
				<label for="fecha_pago">Fecha de envio:</label>
				<div class="input-group">
					<div class="input-group-prepend">
					  <span class="input-group-text">
					    <i class="fa fa-calendar"></i>
					  </span>
					</div>
				<input type="datetime" name="fecha_envio" class="form-control pull-right" id="dtp2" value="'.$respuesta['fecha_envio'].'" required>
				</div>
            </div>

            <label>Imagen actual de comprobante de folio:</label>
            <img src="./views/images/'.$respuesta['url_imagen'].'" alt="Danzlife" height="250" width="250">
            <br>
            <br><br>
            <label for="folio">Folio de autorizacion:</label>
			<input class = "form-control"  type="text" name="folio" value="'.$respuesta['folio'].'" required>
			<br>
             <input type="submit" class="btn btn-primary" value="Aceptar">';

		echo'
		<script>
			var selects = document.getElementById("grupos");

			$(document).on("change","#grupos",function(){
				
	  		
				$.ajax({
					async: false,
					cache: false,
					type: "POST",
					url: "./views/modules/getAlumnas.php",
					data: { "call":selects.options[selects.selectedIndex].value},
					success: function (data, response) {
						console.log(data);
						$("#alumnas").html(data);
					},error: function(){
						$("#alumnas").html("");
					}
				});
			});

			$( document ).ready(function() {
			    
				$("#grupos").val("'.$respuesta['id_grupo'].'"); 
				$.ajax({
						async: false,
						cache: false,
						type: "POST",
						url: "./views/modules/getAlumnas.php",
						data: { "call":selects.options[selects.selectedIndex].value},
						success: function (data, response) {
							console.log(data);
							$("#alumnas").html(data);
						},error: function(){
							$("#alumnas").html("");
						}
					});

				$("#alumnas").val("'.$respuesta['id_alumna'].'"); 
			});

		</script>';
	}


	#Actualizar grupo
	#------------------------------------
	#Permite la actalizacion del grupo en la base de datos, recibiendo su id y el nombre del grupo
	#para sobreescribir estos valores.
	public function actualizarPagoController(){
		if(isset($_POST["id_pago"])){
			$datosController = array(
									  "id_pago"=>$_POST["id_pago"],
							          "id_alumna"=>$_POST["id_alumna"],
							          "nombre_mama"=>$_POST["nombre_mama"],
							          "fecha_pago"=>$_POST["fecha_pago"],
							          "fecha_envio"=>$_POST["fecha_envio"],
							          "folio"=>$_POST["folio"]
									);
			$respuesta = Datos::actualizarPagoModel($datosController, "pagos");
			
			if($respuesta == "success"){
				header("location:index.php?action=cambio_pago");
			}
			else{
				echo "error";
			}
		}
	}
	###################################### TERMINA PAGOS ############################################ 
}



?>