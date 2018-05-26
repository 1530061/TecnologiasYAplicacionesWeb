<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}

?>

<h1>MAESTROS</h1>
<td><a href="index.php?action=registro_maestro"><button>Agregar Nuevo Maestro</button></a></td>
	<table border="1">
		<thead>
			<tr>
				<th>Num. Empleado</th>
				<th>Nombre</th>
				<th>Email</th>
				<th>Carrera</th>
				<th>Editar?</th>
				<th>Eliminar?</th>
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


