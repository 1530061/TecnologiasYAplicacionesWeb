<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<h1>TUTORIAS</h1>
<td><a href="index.php?action=registro_tutoria"><button class="success">Agregar Nueva Tutoria</button></a></td>
	<table id="table" border="0">
		<thead>
			<tr>
				<th>Id</th>
				<th>Hora</th>
				<th>Fecha</th>
				<th>Tema</th>
				<th>Tipo</th>
				<th>¿Detalles?</th>
				<th>¿Eliminar?</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$vistaAlumno = new MvcController();
			$vistaAlumno -> vistaTutoriasController();
			$vistaAlumno -> borrarTutoriaController();

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


