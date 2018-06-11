<?php

session_start();

if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}
if(isset($_SESSION['id_tienda']))
    if($_SESSION['id_tienda']=='1'){
    	header("location:index.php?action=tiendas");
    	exit();
    }

?>

<h1>INVENTARIOS</h1>
<td><a href="index.php?action=registro_producto"><button class="success">Agregar Nuevo Producto</button></a></td>
	<table id="table" border="0">
		<thead>
			<tr>
				<th>Id</th>
				<th>Nombre</th>
				<th>Cantidad</th>
				<th>¿Editar?</th>
				<th>¿Eliminar?</th>
			</tr>
		</thead>
		<tbody>
			<?php

			$vistaAlumno = new MvcController();
			$vistaAlumno -> vistaProductoInventarioController();
			$vistaAlumno -> borrarProductoInventarioController();

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


