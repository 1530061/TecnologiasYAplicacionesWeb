<?php

session_start();
setcookie("nivel", "", time()-3600);
unset($_COOKIE["nivel"]);
session_destroy();

header("location:index.php");
?>

