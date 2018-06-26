
<div class="login-box">
  <div class="login-logo">
    <a href="./index.php"><b>Danzlife</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Ingresar para iniciar sesion</p>

      <form method="post">
        <div class="form-group has-feedback">
          <div class="row">
            <div class="col-1">
              <span class="fa fa-envelope form-control-feedback"></span>
            </div>
            <div class="col-11">
              <input type="text" class="form-control" name="user" placeholder="Usuario">
            </div>
          </div>
        </div>
        <div class="form-group has-feedback">
          <div class="row">
            <div class="col-1">
              <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="col-11">
              <input type="password" class="form-control" name="pass" placeholder="Password">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="checkbox icheck">
              
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

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


