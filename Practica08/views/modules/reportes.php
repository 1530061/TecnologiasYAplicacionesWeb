<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>
<h1>ALUMNOS</h1>
<table id="table_alumnos" border="0">
	<thead>
		<tr>
			<th>Matricula</th>
			<th>Nombre</th>
			<th>Carrera</th>
			<th>Tutor</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$vistaAlumno = new MvcController();
		$vistaAlumno -> vistaReporteAlumnosController();

		?>

	</tbody>
</table>
<hr>
<h1>MAESTROS</h1>
<table id="table_maestros" border="0">
	<thead>
		<tr>
			<th>Num. Empleado</th>
			<th>Nombre</th>
			<th>Email</th>
			<th>Carrera</th>
			<th>Nivel</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$vistaMaestro = new MvcController();
		$vistaMaestro -> vistaReporteMaestrosController();

		?>

	</tbody>
</table>
<h1>TUTORIAS</h1>
<table id="table_tutorias" border="0">
	<thead>
		<tr>
			<th>Id</th>
			<th>Hora</th>
			<th>Fecha</th>
			<th>Tema</th>
			<th>Tipo</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$vistaTutorias = new MvcController();
		$vistaTutorias -> vistaReporteTutoriasController();

		?>

	</tbody>
</table>

<?php

?>


