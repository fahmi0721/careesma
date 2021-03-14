
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LOG IN - CAREESMA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  
</head>
<body class="hold-transition login-page" style="background-image: url('img/kantor.jpg'); background-repeat: no-repeat; background-size: 100% 100%">
<div class="login-box">
  <div class="login-logo">
    <a href="#">CAREE<b>SMA</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Masukkan Email & Password Anda!</p>

    <form action="cek_login.php" method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="Email" placeholder="Email" required>
        <span class="fa fa-user form-control-feedback" ></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group">
        <span class="pull-left">
            <a href="#">saya lupa password</a><br>
            <a href="register.php" class="text-center">Daftar sebgaai member baru</a>
          </span>
        <span class="pull-right"><button class="btn btn-success btn-flat" type='submit'  name="login"><i class="fa fa-sign-in"></i> Login</button></span>
        <span class="clearfix"></span>
      </div>


    </form>
    <?php if(isset($_GET['status']) AND isset($_GET['error'])){ ?>
    <div class="callout callout-danger">
      <h4>Error Status : <?php echo $_GET['status']; ?></h4>
      <p><?php echo $_GET['error']; ?></p>
    </div>
  <?php }elseif(isset($_GET['status']) AND isset($_GET['success'])){ ?>
    <div class="callout callout-success">
      <h4>Pesan Status : <?php echo $_GET['status']; ?></h4>
      <p><?php echo $_GET['success']; ?></p>
    </div>
  <?php } ?>
  
  
    

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.min.js"></script>

</body>
</html>
