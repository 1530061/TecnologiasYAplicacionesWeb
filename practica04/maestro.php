<?php
	//Clase que representa a un maestro en el sistema
	class maestro{
		private $num_empleado;	//Numero de empleado
		private $carrera;		//Carrera del empleado
		private $nombre;		//Nombre del empleado
		private $telefono;		//Telefono del empleado

		//Constructor
		function __construct($num_empleado="",$carrera="",$nombre="",$telefono=""){
			$this->num_empleado=$num_empleado;
			$this->carrera=$carrera;
			$this->nombre=$nombre;
			$this->telefono=$telefono;
		}

		//Funcion que permite guardar los atributos del objeto en el archivo "maestros.txt"
		function save(){
			$txt="$this->num_empleado,$this->carrera,$this->nombre,$this->telefono".PHP_EOL;
			$file = fopen("maestros.txt", "a") or die("No se pudo abrir archivo");
			fwrite($file, $txt);
			fclose($file);
		}
	}

?>