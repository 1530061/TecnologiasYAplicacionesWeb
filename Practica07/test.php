 <?php
  if(isset($_POST)){
      if(isset($_POST['details'])){
      $songData = $_POST['details'];
      echo(var_dump($songData));
      echo("<script> alert('hola')</script>");
    }
  }

?>