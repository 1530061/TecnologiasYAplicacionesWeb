<?php

if(!isset($_SESSION)) 
    session_start(); 
 
unset($_SESSION["validar"]);
session_destroy();

header("location:index.php");

?>

