<?php 
$page = isset($_GET['page']) ? $_GET['page'] : null;
if($page != null){
	$page = str_replace("../", "", addslashes($page));
	$files = "inc/".$page."/detail.php";
	if(file_exists($files)){
		include $files;
	}else{
		echo "<div class='error-page'>
	        <h2 class='headline text-yellow' style='margin-top:-15px;'> 404</h2>

	        <div class='error-content'>
	          <h2><i class='fa fa-warning text-yellow'></i> Oops! Page not found.</h2>
	          <h5>Halaman Yang Anda Pilih Tidak Ditemukan Oleh Sistem. Silahkan Hubungi Administrator.</h5>
	        </div>
	      </div>";
	}
}else{
	include_once 'inc/home.php';
}
?>