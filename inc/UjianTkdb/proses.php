<?php
session_start();
include_once '../../config/config.php';
include_once 'fungsi.php';
$_SESSION['Id'] = 1;
$UserUpdate = $_SESSION['Id'];
$date = date("Y-m-d H:i:s");
$proses = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : "";
switch ($proses) {
	case 'LoadSoal':
		$IdJ = $_POST['IdJ'];
		$Posisi = $_POST['Posisi'];
		$Ses = "SD".$IdJ.$_SESSION['Careesma_Id'];
		if(!isset($_SESSION[$IdJ]['TempSoal'])){
			$_SESSION[$Ses]['TempSoal'] = CreateSessionSoal($IdJ);
		}
		
		$LoadSoal = LoadSoal($IdJ,$Posisi);
		echo json_encode($LoadSoal);
		break;
	case 'LoadWaktu':
		date_default_timezone_set('Asia/Makassar');
		
		$IdJ = $_POST['IdJ'];
		$Ses = "SD".$IdJ.$_SESSION['Careesma_Id'];
		unset($_SESSION[$Ses]['Waktu']);
		if(isset($_SESSION[$Ses]['Waktu'])){
			$Waktu = $_SESSION[$Ses]['Waktu'];
		}else{
			$Waktu = getWaktuMulai($IdJ);
		}
		$SisahWaktu = SisahWaktu($Waktu,60);
		 	
		echo json_encode($SisahWaktu);
		break;
	case 'JawabPertanyaan':
		date_default_timezone_set('Asia/Makassar');
		$iData = UpdateJwaban($_POST,"Jawab");
		echo json_encode($iData);
		break;
	case 'TombolSelesai':
		$IdJ = $_POST['IdJ'];
		$iData = TombolSelesai($IdJ);
		echo json_encode($iData);
		break;
	case 'LoadDataJawaban':
		$loadData = LoadDataJawaban($_POST);
		echo json_encode($loadData);
		break;
	case 'GenerateHasil':
		$IdJ = $_POST['IdJ'];
		$LoadData = GenerateHasil($IdJ);
		echo json_encode($LoadData);
		break;
	case 'coba':
		$tes = GenerateHasil(6);
		echo "<pre>";
		print_r($tes);
		break;
}

?>