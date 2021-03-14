<?php
session_start();
if(!isset($_SESSION['Careesma_Username'])){
  header("location:login.php");
  exit();
}else{
include_once 'config/config.php';
include_once 'inc/fungsi.php';
if($_SESSION['Careesma_Level'] == "1"){
    $_SESSION['BiodataLengkap'] = CekBiodata($_SESSION['Careesma_Username']);
 
}
if($_SESSION['Careesma_Level'] == "1"){
  $ImgLoad = LoadImage();
  
}else{
  $ImgLoad = "img/avatar04.png";
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>CAREESMA</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="select2-bootstrap/dist/select2.min.css">
  <link rel="stylesheet" href="select2-bootstrap/dist/select2-bootstrap.min.css">
  <link rel="stylesheet" href="css/datepicker3.css">
  <link rel="stylesheet" href="css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  
  <link rel="stylesheet" href="css/_all-skins.min.css">
  <link rel="stylesheet" href="css/jquery-ui.min.css">
  
  
  <link href="css/timepicker.min.css" rel="stylesheet"/>

  <link rel="stylesheet" href="css/main.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery-ui.min.js"></script>
  <script>
    $(document).ready(function(){
      StopLoad();
    });
    
  </script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->

<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CR</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CAREE</b>SMA</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= $ImgLoad ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['Careesma_Nama']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= $ImgLoad ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['Careesma_Nama']; ?>
                  <small><?php echo $_SESSION['Careesma_Username']; ?></small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-primary btn-flat"><i class="fa fa-cog"></i> Ubah Password</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-danger btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= $ImgLoad ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['Careesma_Nama']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <?php include_once 'menu.php'; ?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content">
    <!-- Main content -->
      <?php if($_SESSION['Careesma_Level'] == 1 && $_SESSION['BiodataLengkap'] < 100){ 
          $color = "danger";
          if($_SESSION['BiodataLengkap'] >= 50 &&  $_SESSION['BiodataLengkap'] < 90){
              $color = "warning";
          }elseif($_SESSION['BiodataLengkap'] >= 90 ){
              $color = "success";
          }
      ?>
      
          <div class="progress" style='height:20px;'>
          <div class="progress-bar progress-bar-animated progress-bar-<?= $color; ?> progress-bar-striped" role="progressbar"
          aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width:<?= $_SESSION['BiodataLengkap'] ?>%">
            Pengisian Biodata telah mencapai <?= $_SESSION['BiodataLengkap'] ?>%
          </div>
          </div>
      
      <?php } ?>
      <?php include_once 'konten.php'; ?>
      

    </section>
  </div>

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; 2020 <a href="#">CAREESMA</a>. </strong> All rights
    reserved.
  </footer>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="select2-bootstrap/dist/select2.full.js"></script>
<script src="js/bootstrap3-wysihtml5.all.min.js"></script>
<script src="js/chart/Chart.min.js" type="text/javascript"></script>
<script src="js/adminlte.min.js"></script>


<script src="js/main.js"></script>


<?php
  if($page != null){
    $page = str_replace("../", "", addslashes($page));
    $files = "inc/".$page."/main.js";
    if(file_exists($files)){
      echo "<script src='".$files."'></script>";
    }
  }else{
    echo "<script src='inc/home.js'></script>";
  }
?>


<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
<?php } ?>