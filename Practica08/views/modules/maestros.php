<?php

session_start();

if(!$_SESSION["validar"] || !isset($_COOKIE['nivel']) || $_COOKIE['nivel']!="1"){
	header("location:index.php?action=ingresar");
	exit();
}
?>

<h1>MAESTROS</h1>
<td><a href="index.php?action=registro_maestro"><button class="success">Agregar Nuevo Maestro</button></a></td>
	<table id="table" border="0">
		<thead>
			<tr>
				<th>Num. Empleado</th>
				<th>Nombre</th>
				<th>Email</th>
				<th>Carrera</th>
				<th>Nivel</th>
				<th>¿Editar?</th>
				<th>¿Eliminar?</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$vistaMaestro = new MvcController();
			$vistaMaestro -> vistaMaestrosController();
			$vistaMaestro -> borrarMaestroController();

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


