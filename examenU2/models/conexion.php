<?php

class Conexion{
	public function conectar(){
		$link = new PDO("mysql:host=localhost;dbname=danzlife","root","");
		return $link;
	}

}

?>
