<?php 

class Paginas{
	
	public function enlacesPaginasModel($enlaces){


		if($enlaces == "productos" || $enlaces == "editar_producto" || $enlaces == "productos_inventario" || $enlaces =="editar_inventario" || $enlaces == "inventarios" || $enlaces == "registro_inventario" || $enlaces == "ingresar" ||$enlaces == "registro_producto" || $enlaces == "salir"){

			$module =  "views/modules/".$enlaces.".php";
		}
		else if($enlaces == "index"){
			$module =  "views/modules/ingresar.php";
		}
		else if($enlaces == "ok_inventario"){
			$module =  "views/modules/inventarios.php";
		}
		else if($enlaces == "ok_producto"){
			$module =  "views/modules/productos.php";
		}
		else if($enlaces == "fallo"){
			$module =  "views/modules/ingresar.php";
		}
		else if($enlaces == "cambio_inventario"){
			$module =  "views/modules/maestros.php";
		}
		else if($enlaces == "cambio_producto"){
			$module =  "views/modules/productos.php";
		}
		else{
			$module =  "views/modules/inventarios.php";
		}
		
		return $module;

	}

}

?>