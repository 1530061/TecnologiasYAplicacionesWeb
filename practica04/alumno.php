<?php
	//Clase que representa a un alumno en el sistema
	class alumno{
		private $matricula;	//Matricula
		private $nombre;	//Nombre del alumno
		private $carrera;	//Carrera a la que pertenece
		private $email;		//Correo electronico
		private $telefono;	//Telefono

		//Constructor
		function __construct($matricula="",$nombre="",$carrera="",$email="",$telefono=""){
			$this->matricula=$matricula;
			$this->nombre=$nombre;
			$this->carrera=$carrera;
			$this->email=$email;
			$this->telefono=$telefono;
		}

		//Funcion que permite realizar el guardado de los atributos del objeto en el archivo txt de alumnos.txt
		function save(){
			$txt="$this->matricula,$this->nombre,$this->carrera,$this->email,$this->telefono".PHP_EOL;
			$file = fopen("alumnos.txt", "a") or die("No se pudo abrir archivo");
			fwrite($file, $txt);
			fclose($file);
		}
	}

?>