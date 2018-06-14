
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Practica 12</title>
  <!-- Tell the browser to be responsive to screen width -->
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-info navbar-light border-bottom">

    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link">Home</a>
        </li>
      </ul>
      <?php
        session_start();
        $notificacion = new MvcController();
        $r = $notificacion->getCantidadNotificacion();


        //echo($_SESSION['id_tienda']);
      ?>
            </ul>
      <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
         <li class="nav-item dropdown d-sm-inline-block">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fa fa-bell-o"></i>
              <span class="badge badge-warning navbar-badge"><?php echo($r);?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header"> <?php echo($r);?> Notifications</span>
              <div class="dropdown-divider"></div>
              <?php
                $notificacion->getNotificacionProducts();
              ?>
              
            
            </div>
          </li>

    </ul>
  </nav>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

            
          </div><!-- /.col -->
          
