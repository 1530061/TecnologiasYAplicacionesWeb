
<div class="login-box">
  <div class="login-logo">
    <a href="./index.php"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Ingresar para iniciar sesion</p>

      <form method="post">
        <div class="form-group has-feedback">
          <input type="text" class="form-control" name="user" placeholder="Usuario">
          <span class="fa fa-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" name="pass" placeholder="Password">
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              <label>
                <input type="checkbox"> Recordarme
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
      <?php

      $ingreso = new MvcController();
      $ingreso -> ingresoUsuarioController();

      if(isset($_GET["action"])){
        if($_GET["action"] == "fallo"){
          echo'
            <p class="mb-1">Error al ingresar</p>
          ';
        }
      }
      ?>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>


