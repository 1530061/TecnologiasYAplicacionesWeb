<?php

session_start();

if(!$_SESSION["validar"]){

	header("location:index.php?action=ingresar");

	exit();

}

?>

<h1>USUARIOS</h1>

	<table border="1">
		
		<thead>
			
			<tr>
				<th>Nombre Producto</th>
				<th>Descripcion Producto</th>
				<th>Precio de Compra</th>
				<th>Precio de Venta</th>
				<th>Precio</th>
				<th>Editar?</th>
				<th>Eliminar?</th>

			</tr>

		</thead>

		<tbody>
			
			<?php

			$vistaProducto = new MvcController();
			$vistaProducto -> vistaProductoController();
			$vistaProducto -> borrarProductoController();

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