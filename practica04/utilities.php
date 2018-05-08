<?php

//Funcion que retorna un array donde se encuentran todos los valores de un archivo txt, "1" de alumnos
//y "2" de maestros, dicha funcion realiza la lectura del archivo y posteriormente lo almacena en el array
//a retornar.
function fill_array($t){
    $user_access=[];  //Se inicializa un array vacio

    //Dependiendo de su tipo se realizan lecturas de diferentes archivos
    if($t==1){
            $file=fopen("alumnos.txt", "r") or die("Unable to open file!");     //Se lee el archivo
            $line = explode(PHP_EOL, fread($file,filesize("alumnos.txt")));     //Se separa el archivo en multiples lineas
           
            //Por cada una de las lineas se recorre un ciclo donde se vuelven a separar cada vez que se encuentre una coma
            foreach($line as $l){
                if(!empty($l[0]) && !empty($l[1]) && !empty($l[2]) && !empty($l[3]) && !empty($l[4])){
                    $user_access[] = [
                        'matricula' => explode(",", $l)[0],
                        'nombre' => explode(",", $l)[1],
                        'carrera' => explode(",", $l)[2],
                        'email' => explode(",", $l)[3],
                        'telefono' => explode(",", $l)[4]  
                    ];
                }
            }
            fclose($file);  //Se cierra el archivo
    }else if($t==2){
      if(filesize("maestros.txt")>16){
            $file=fopen("maestros.txt", "r") or die("Unable to open file!");    //Se lee el archivo
            $line = explode(PHP_EOL, fread($file,filesize("maestros.txt")));    //Se separa el archivo en multiples lineas
           
            //Por cada una de las lineas se recorre un ciclo donde se vuelven a separar cada vez que se encuentre una coma
            foreach($line as $l){
                if(!empty($l[0]) && !empty($l[1]) && !empty($l[2]) && !empty($l[3])){
                    $user_access[] = [
                        'num_empleado' => explode(",", $l)[0],
                        'carrera' => explode(",", $l)[1],
                        'nombre' => explode(",", $l)[2],
                        'telefono' => explode(",", $l)[3]
                    ];
                }
            }
            fclose($file);  //Se cierra el archivo
        }
    }
    return $user_access;
}

?>
