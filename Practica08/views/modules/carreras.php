<?php

session_start();

if(!$_SESSION["validar"] || !isset($_COOKIE['nivel']) || $_COOKIE['nivel']!="1"){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<h1>CARRERAS</h1>
<td><a href="index.php?action=registro_carrera"><button class="success">Agregar Nueva Carrera</button></a></td>
	<table id="table" border="0">
		<thead>
			<tr>
				<th>Id</th>
				<th>Nombre</th>
				<th>¿Editar?</th>
				<th>¿Eliminar?</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$vistaAlumno = new MvcController();
			$vistaAlumno -> vistaCarreraController();
			$vistaAlumno -> borrarCarreraController();

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


