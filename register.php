
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
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>CAREE</b>SMA</a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Daftar sebagai member baru</p>
    <div id="proses"></div>
    <form action="proses.php?proses=register" id="FormData" method="post">
    <div class="form-group has-feedback">
        <input type="text" class="form-control" onkeyup='angka(this);Clear("NoKtp")' onblur='Validation("NoKtp")' autocomplete="off" required name='NoKtp'  id='NoKtp'  placeholder="No KTP">
        <span class="fa fa-id-card form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="Nama" id="Nama" onkeyup='Clear("Nama")' onblur='Validation("Nama")' class="form-control" autocomplete="off" required placeholder="Nama Lengkap">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="Email" id="Email" onkeyup='Clear("Email")' onblur='Validation("Email")' class="form-control" autocomplete="off" required placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="Password" id="Password" onkeyup='Clear("Password")' onblur='Validation("Password")' class="form-control" autocomplete="off" required placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="RPassword" id="RPassword" onkeyup='Clear("RPassword")' onblur='Validation("RPassword")' class="form-control" autocomplete="off" required placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <a href="login.php" class="text-center">saya sudah memiliki sebuah member </a>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit"  class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    

    
  </div>
  <!-- /.form-box -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="js/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
<script>
    

    function Validation(str){
        if(str == "NoKtp"){
            CekNoKtp();
        }else if(str == "Nama"){
            var nm = $("#Nama").val();
            if(nm.length == 0){
                Customerror("Registrasi", "001", "Nama belum diisi.", 'proses'); $("#Nama").focus(); return false;
            }
        }else if(str == "Email"){
            var em = $("#Email").val();
            if(em.length == 0){
                Customerror("Registrasi", "001", "Email belum diisi.", 'proses'); $("#Nama").focus(); return false;
            }else{
                validasiEmail();
            }
        }else if(str == "Password"){
            var Pss = $("#Password").val();
            if(Pss.length == 0){
                Customerror("Registrasi", "001", "Password belum diisi.", 'proses'); $("#Password").focus(); return false;
            }
        }else if(str == "RPassword"){
            var Pss = $("#RPassword").val();
            if(Pss.length == 0){
                Customerror("Registrasi", "001", "Password belum diisi.", 'proses'); $("#Password").focus(); return false;
            }else{
                var pass = $("#Password").val();
                if(Pss != pass){
                    Customerror("Registrasi", "001", "Password tidak sama.", 'proses'); $("#RPassword").focus(); return false;
                }
            }
        }
    }

    function Clear(str){
        $("#proses").html("");
    }

    function validasiEmail() {
        var rs = $("#Email").val();
        var atps=rs.indexOf("@");
        var dots=rs.lastIndexOf(".");
        if (atps<1 || dots<atps+2 || dots+2>=rs.length) {
            Customerror("Registrasi", "001", "Email tidak valid", 'proses'); $("#Email").focus(); return false;
            return false;
        } 
    }

    function CekNoKtp(){
        var str = $("#NoKtp").val();
        if(str.length == 0){
            Customerror("Registrasi", "001", "No KTP belum diisi.", 'proses'); $("#NoKtp").focus(); return false;
        }
        if(str.length != 16){
            Customerror("Registrasi", "001", "No KTP tidak valid. Pastikan nomor KTP yang dimasukkan benar.", 'proses');$("#NoKtp").focus(); return false;
        }
    }

    

    
</script>

</body>
</html>
