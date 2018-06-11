
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link bg-info ">
      <img src="views/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Inventario</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="views/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php 
            
            if(isset($_SESSION['name']))
              echo($_SESSION['name']);
            if(isset($_SESSION['sa']))
              if($_SESSION['sa']=='1'){
                echo("<br><br> Nivel:  SuperAdmin");
              }else{
                echo("<br><br> User");
              }
            
            if(isset($_SESSION['nombre_tienda']))
              echo("<br>Tienda: ".$_SESSION['nombre_tienda']);
            ?>
          </a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview menu-open">
            <li class="nav-item">
              <?php
                if(isset($_SESSION['id_tienda']))
                  if($_SESSION['id_tienda']=='1'){
              ?>

                    <li>
                      <a href="?action=tiendas" class="nav-link">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>
                          Tiendas
                        </p>
                      </a>
                    </li>
              <?php
                  }else{
              ?>
              <li>
                <a href="?action=dashboard" class="nav-link">
                  <i class="nav-icon fa fa-dashboard"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li>
                <a href="?action=inventario" class="nav-link">
                  <i class="nav-icon fa fa-tv"></i>
                  <p>
                    Inventario
                  </p>
                </a>
              </li>
              <li>
                <a href="?action=usuarios" class="nav-link">
                  <i class="nav-icon fa fa-users"></i>
                  <p>
                    Usuarios
                  </p>
                </a>
              </li>
              <li>
                <a href="?action=categorias" class="nav-link">
                  <i class="nav-icon fa fa-tags"></i>
                  <p>
                    Categorias
                  </p>
                </a>
              </li>
              <li>
                <a href="?action=venta" class="nav-link">
                  <i class="nav-icon fa fa-tags"></i>
                  <p>
                    Venta
                  </p>
                </a>
              </li>
              <?php
                }
              ?>
              <li>
                <a href="?action=salir" class="nav-link">
                  <i class="nav-icon fa fa-sign-out"></i>
                  <p>
                    Log Out
                  </p>
                </a>
              </li>
              
          </li>
         </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
 
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2018 <a href="#">Erick Elizondo Rodríguez</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

</div>
<!-- ./wrapper -->


</body>
</html>