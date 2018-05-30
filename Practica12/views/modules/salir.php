<?php

session_start();
setcookie("nivel", "", time()-3600);
unset($_COOKIE["nivel"]);
session_destroy();

?>

<h1>Ha salido de la aplicacion</h1>