<!--Es la plantilla que vera el usuario al ejecutar la aplicación -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Template</title>

	<link rel="stylesheet" href="./views/css/foundation.css" />
	<link href="./views/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="./views/css/datatables.min.css"/>

	
	
	<script src="./views/js/vendor/jquery.js"></script>
    <script src="./views/js/vendor/modernizr.js"></script>
	<script src="./views/js/select2.min.js"></script>
	<script type="text/javascript" src="./views/js/datatables/datatables.min.js"></script>


    
	<style>

		nav{
			position:relative;
			margin:auto;
			width:100%;
			height:auto;
			background:black;
		}

		nav ul{
			position:relative;
			margin:auto;
			width:50%;
			text-align: center;
		}

		nav ul li{
			display:inline-block;
			width:24%;
			line-height: 50px;
			list-style: none;
		}

		nav ul li a{
			color:white;
			text-decoration: none;
		}

		section{
			position: center;
			margin: auto;
			width:65%;
		}

		section h1{
			position: relative;
			margin: auto;
			padding:10px;
			text-align: center;
		}

		section form{
			position:relative;
			margin:auto;
			width:100%;
		}

		section form input{
			display:inline-block;
			padding:10px;
			width:95%;
			margin:5px;
		}

		section form input[type="submit"]{
			position:relative;
			margin:20px auto;
			left:4.5%;

		}

		table{
			width:100%;
		}

		td {
		  vertical-align: baseline;
		}

		
	</style>

</head>
<body>

<?php include "modules/navegacion.php"; ?>

<section>
<?php 
	ob_start();
	
	$mvc = new MvcController();
	$mvc -> enlacesPaginasController();
?>

</section>
</body>
<script>
	$(document).ready( function () {
	    $('#table').DataTable();
	} );		
</script>
</html>