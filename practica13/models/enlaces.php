<?php 

class Paginas{
	
	public function enlacesPaginasModel($enlaces){


		if($enlaces == "usuarios" || $enlaces == "categorias" || $enlaces == "dashboard" || $enlaces == "inventario" || $enlaces == "editar_producto" || $enlaces == "editar_usuario" || $enlaces == "editar_categoria" || $enlaces == "editar_tienda" ||$enlaces == "ingresar" || $enlaces == "registro_producto" || $enlaces == "registro_tienda" || $enlaces == "registro_usuario" || $enlaces == "registro_categoria" || $enlaces == "salir" || $enlaces == "producto_detalles" || $enlaces == "tiendas"  || $enlaces == "redirect" || $enlaces == "venta" ){

			$module =  "views/modules/".$enlaces.".php";
		}
		else if($enlaces == "index"){
			$module =  "views/modules/dashboard.php";
		}
		else if($enlaces == "ok_producto"){
			$module =  "views/modules/inventario.php";
		}
		else if($enlaces == "ok_usuario"){
			$module =  "views/modules/usuarios.php";
		}
		else if($enlaces == "ok_categoria"){
			$module =  "views/modules/categorias.php";
		}
		else if($enlaces == "ok_tienda"){
			$module =  "views/modules/tiendas.php";
		}
		else if($enlaces == "fallo"){
			$module =  "views/modules/ingresar.php";
		}
		else if($enlaces == "cambio_producto"){
			$module =  "views/modules/inventario.php";
		}
		else if($enlaces == "cambio_usuario"){
			$module =  "views/modules/usuarios.php";
		}
		else if($enlaces == "cambio_categoria"){
			$module =  "views/modules/categorias.php";
		}
		else if($enlaces == "cambio_tienda"){
			$module =  "views/modules/tiendas.php";
		}
		else{
			$module =  "views/modules/dashboard.php";
		}
		
		return $module;

	}

}

?>