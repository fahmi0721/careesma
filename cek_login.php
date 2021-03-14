<?php
require_once 'config/config.php';
require_once 'inc/fungsi.php';

$username = $_POST['Email'];
$password = md5("careesma".$_POST['password']);
$sql = "SELECT * FROM careesma_login WHERE Username = '$username'";
$query = $db->query($sql);

$row = $query->rowCount();
$data = $query->fetch(PDO::FETCH_ASSOC);
if($row > 0){
	if($data['Password'] == $password){
		session_start();
		$_SESSION['Careesma_Username'] = $data['Username'];
		$_SESSION['Careesma_Nama'] = $data['Nama'];
		$_SESSION['Careesma_Id'] = $data['Id'];
		$_SESSION['Careesma_Level'] = $data['Level'];
		header("location:index.php");
	}else{
		
		header("location:login.php?status=108&error=Password yang anda masukkan salah!.");
	}
}else{
	header("location:login.php?status=108&error=Uaername yang anda masukkan salah!.");
}
//header("location:index.php");
?>