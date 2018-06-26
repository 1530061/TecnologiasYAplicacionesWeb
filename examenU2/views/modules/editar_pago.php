<?php
if(!isset($_SESSION)) 
    session_start(); 
 
if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}
?>

<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="index.php?action=pagos">Pagos</a></li>
      <li class="breadcrumb-item active">Editar Pago</a></li>
    </ol>
  </div><!-- /.col -->
  <br><br>
</div>
<div class="card card-info mx-auto" style="width:50%;">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Editar Pago</h3>
		</div>
	</div>
	  	<center>
			<section class="content" style="width:90%">
		   
		        	<form method="post" enctype="multipart/form-data">
				          <div class="card-body" align="left">
				          	<br>
				          	
							<?php

							$editarPago = new MvcController();
							$editarPago -> editarPagoController();
							$editarPago -> actualizarPagoController();

							?>
							
							
				          </div><!-- /.card-body -->
				         </form>
		      
		    </section>
		</center>
	

	<script>
		

	</script>



			
	
</div>



