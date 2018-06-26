<?php 

class Paginas{
	
	public function enlacesPaginasModel($enlaces){


		if($enlaces == "ingresar" || $enlaces == "salir" || $enlaces == "alumnas" || $enlaces == "registro_alumna" || $enlaces == "editar_alumna" || $enlaces=="grupos" || $enlaces == "registro_grupo" || $enlaces == "editar_grupo"  || $enlaces=="pagos"  || $enlaces == "editar_pago" || $enlaces=="p_agregar_pago" ||$enlaces=="dashboard" || $enlaces == "p_lugares"){
			$module =  "views/modules/".$enlaces.".php";
		}
		else if($enlaces == "index"){
			$module =  "views/modules/p_agregar_pago.php";
		}
		else if($enlaces == "fallo"){
			$module =  "views/modules/ingresar.php";
		}
		else if($enlaces == "ok_alumna" || $enlaces == "cambio_alumna"){
			$module =  "views/modules/alumnas.php";
		}
		else if($enlaces == "ok_grupo" || $enlaces == "cambio_grupo"){
			$module =  "views/modules/grupos.php";
		}
		else if($enlaces == "ok_pago" || $enlaces == "cambio_pago"){
			$module =  "views/modules/pagos.php";
		}
		else{
			$module =  "views/modules/redirect.php";
		}
		
		return $module;

	}

}

?>