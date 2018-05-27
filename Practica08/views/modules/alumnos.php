<?php


session_start();

if(!$_SESSION["validar"] || !isset($_COOKIE['nivel']) || $_COOKIE['nivel']!="1"){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<h1>ALUMNOS</h1>
<td><a href="index.php?action=registro_alumno"><button class="success">Agregar Nuevo Alumno</button></a></td>
	<table id="table" border="0">
		<thead>
			<tr>
				<th>Matricula</th>
				<th>Nombre</th>
				<th>Carrera</th>
				<th>Tutor</th>
				<th>¿Editar?</th>
				<th>¿Eliminar?</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$vistaAlumno = new MvcController();
			$vistaAlumno -> vistaAlumnosController();
			$vistaAlumno -> borrarAlumnoController();

			?>

		</tbody>
	</table>
<?php

if(isset($_GET["action"])){
	if($_GET["action"] == "cambio"){
		echo "Cambio Exitoso";
	}
}

?>


