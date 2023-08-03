<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $pageTitle }}</title>
  
  <!-- Icon -->
  <link rel="icon" href="<?php echo base_url(); ?>/public/assets/img/arkonorllc-logo-edited.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Sweet alert -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toaster -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/AdminLTE/dist/css/adminlte.min.css">

  <style type="text/css">
    body{
      background-image: url('public/assets/img/login-background.png');
      background-size: cover;
      background-position: center; /* Center the image */
      background-repeat: no-repeat; /* Do not repeat the image */
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo mb-0">
      <center>
        <img src="public/assets/img/arkcrmlogo.png" height="100%" class="img img-round">
      </center>
    </div>
    <!-- /.login-logo -->
    <div class="card card-outline card-primary" style="background: rgba(0, 0, 0, 0.7);">
      <div class="card-body">
        <p class="login-box-msg text-white">Sign in to start your session</p>

        <form id="form_login">
          <div class="input-group mb-3">
            <input type="text" class="form-control form-control-sm text-white" style="background: rgba(0, 0, 0, 0.5);" id="txt_userEmail" name="txt_userEmail" placeholder="Email or User Name" required>
            <div class="input-group-append">
              <div class="input-group-text" style="background: rgba(0, 0, 0, 0.5);">
                <span class="fas fa-user text-white"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control form-control-sm text-white" style="background: rgba(0, 0, 0, 0.5);" id="txt_userPassword" name="txt_userPassword" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text" style="background: rgba(0, 0, 0, 0.5);">
                <span class="fas fa-lock text-white"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <a href="<?php echo base_url(); ?>/forgot-password" class="text-muted">Forgot password?</a>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" id="btn_signIn" class="btn btn-sm btn-block btn-outline-primary">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <input type="hidden" id="txt_baseUrl" value="<?php echo base_url(); ?>">

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Sweet Alert -->
  <script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toaster -->
  <script src="<?php echo base_url(); ?>/public/assets/AdminLTE/plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo base_url(); ?>/public/assets/AdminLTE/dist/js/adminlte.min.js"></script>
  <!-- Custom Script -->
  <script src="<?php echo base_url(); ?>/public/assets/js/index.js"></script>
  <!-- Events -->
  <script type="text/javascript">
    $(document).ready(function(){
      $('#form_login').on('submit',function(e){
        e.preventDefault();
        INDEX.login(this);
      });
    });
  </script>
  
</body>
</html>
