<?php

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 


if(!$_SESSION["validar"]){
	header("location:index.php?action=ingresar");
	exit();
}
if(isset($_SESSION['id_tienda']))
    if($_SESSION['id_tienda']=='1'){
    	header("location:index.php?action=tiendas");
    	exit();
    }

?>
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active">Ventas Realizadas</a></li>
    </ol>
  </div><!-- /.col -->
  <br><br>
</div>
<div class="card card-info" style="width:100%">
	<div class="card-header"">
		<div class="d-inline-block">
		  <h3 class="card-title">Ventas Realizadas</h3>
		</div>
	</div>
	<div class="card-body">
		
		<table id="table_pdf_no_ignore" width="100%" border="0">
			<thead>
				<tr>
					<th>Id</th>
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Cantidad</th>
					<th>Importe</th>
				</tr>
			</thead>
			<tbody>
				<?php

				$vistaVentas = new MvcController();
				$vistaVentas -> vistaDetallesVentaController();
				?>

			</tbody>
		</table>
	</div>
</div>
			<?php

if(isset($_GET["action"])){
	if($_GET["action"] == "cambio"){
		echo "Cambio Exitoso";
	}
}


?>
