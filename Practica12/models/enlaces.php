<?php 

class Paginas{
	
	public function enlacesPaginasModel($enlaces){


		if($enlaces == "usuarios" || $enlaces == "categorias" || $enlaces == "dashboard" || $enlaces == "inventario" || $enlaces == "editar_producto" || $enlaces == "ingresar" || $enlaces == "registro_producto" || $enlaces == "registro_usuario" || $enlaces == "registro_categoria" || $enlaces == "salir"){

			$module =  "views/modules/".$enlaces.".php";
		}
		else if($enlaces == "index"){
			$module =  "views/modules/ingresar.php";
		}
		else if($enlaces == "ok_producto"){
			$module =  "views/modules/inventario.php";
		}
		else if($enlaces == "fallo"){
			$module =  "views/modules/ingresar.php";
		}
		else if($enlaces == "cambio_producto"){
			$module =  "views/modules/inventario.php";
		}
		else{
			$module =  "views/modules/dashboard.php";
		}
		
		return $module;

	}

}

?>