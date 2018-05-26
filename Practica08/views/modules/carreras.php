<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<h1>CARRERAS</h1>
<td><a href="index.php?action=registro_carrera"><button>Agregar Nueva Carrera</button></a></td>
	<table border="1">
		<thead>
			<tr>
				<th>Id</th>
				<th>Nombre</th>
				<th>Editar?</th>
				<th>Eliminar?</th>
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


