<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<h1>ALUMNOS</h1>
<td><a href="index.php?action=registro_alumno"><button>Agregar Nuevo Alumno</button></a></td>
	<table border="1">
		<thead>
			<tr>
				<th>Matricula</th>
				<th>Nombre</th>
				<th>Carrera</th>
				<th>Tutor</th>
				<th>Editar?</th>
				<th>Eliminar?</th>
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


