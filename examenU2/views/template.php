<?php
  ob_start();
?>
<!--Es la plantilla que vera el usuario al ejecutar la aplicación -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Danzlife</title>

	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!-- DataTables -->
  <link rel="stylesheet" href="views/plugins/datatables/dataTables.bootstrap4.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="views/dist/css/adminlte.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="views/plugins/iCheck/flat/blue.css">
	<!-- Morris chart -->
	<link rel="stylesheet" href="views/plugins/morris/morris.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="views/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!-- Date Picker -->
	<link rel="stylesheet" href="views/plugins/datepicker/datepicker3.css">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="views/plugins/daterangepicker/daterangepicker-bs3.css">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="views/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Ionicons -->
  <link rel="stylesheet" href="views/dist/css/ionicons.min.css">

  <link rel="stylesheet" href="views/dist/css/select2.min.css" />
  <script src="views/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- DataTables -->
  <script src="views/plugins/datatables/jquery.dataTables.js"></script>
  <script src="views/plugins/datatables/dataTables.bootstrap4.js"></script>
  <script src="views/plugins/datatables/pdfmake.min.js"></script>
  <script src="views/plugins/datatables/dataTables.buttons.min.js"></script>
  <script src="views/plugins/datatables/buttons.html5.min.js"></script>
  <script src="views/plugins/datatables/jszip.min.js"></script>
  <script src="views/plugins/datatables/vfs_fonts.js"></script>
  
  <!-- Bootstrap 4 -->
  <script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Morris.js charts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="views/plugins/morris/morris.min.js"></script>
  <!-- Sparkline -->
  <script src="views/plugins/sparkline/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="views/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="views/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

  <!-- daterangepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
  <script src="views/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="views/plugins/datepicker/bootstrap-datepicker.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="views/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <!-- Slimscroll -->
  <script src="views/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="views/plugins/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="views/dist/js/adminlte.js"></script>

 
  <script src="views/dist/js/demo.js"></script>
  <script src="views/dist/js/select2.min.js"></script>
  <script src="views/dist/js/sweetalert.min.js"></script>

</head>


<body class="hold-transition sidebar-mini">
<div class="wrapper">
 
<section>
<?php


  if(!isset($_GET['action']))
    header("location:index.php?action=p_agregar_pago");

  if(isset($_GET['action']) )
    if($_GET['action']!='ingresar' && $_GET['action']!='salir' && $_GET['action']!='fallo' && $_GET['action']!="p_agregar_pago" && $_GET['action']!="p_lugares")
      include("modules/navegacion.php");
  
  $mvc = new MvcController();
  $mvc -> enlacesPaginasController();

 if(isset($_GET['action']) && isset($_SESSION['validar']))
   if($_GET['action']!='ingresar' && $_GET['action']!='salir' && $_GET['action']!='fallo' && $_GET['action']!="p_agregar_pago" && $_GET['action']!="p_lugares")
     include("footer.php");

  
  
?>

</div>
</section>
</body>

<script type="text/javascript">
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });
  $(function () {
    $("#table").DataTable();
  });
  $('#dtp').datepicker({
    autoclose: true
  });
  $('#dtp2').datepicker({
    autoclose: true
  });
  
</script>
    




</html>