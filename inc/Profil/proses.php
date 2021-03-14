<?php
session_start();
include_once '../../config/config.php';
include_once 'fungsi.php';
$date = date("Y-m-d H:i:s");
$proses = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : "";
switch ($proses) {
	case 'UpdateDataDiri':
		try {
			$result = UpdateDataDiri($_POST);
		} catch (PDOException $e) {
			$result = $e->getMessage();
		}
		echo json_encode($result);
		break;
	case 'UpdateFoto':
		try {
			$data['Id']  = $_POST['Id'];
			$data['File']  = $_FILES['Foto'];
			$data['Dir']  = "../../img/Foto/";
			$result = UpdateFoto($data);
		} catch (PDOException $e) {
			$result = $e->getMessage();
		}
		echo json_encode($result);
		break;
	case 'TambahSertifiksai':
		try {
			$data['Id']  = $_POST['Id'];
			$data['NamaSertifikasi']  = $_POST['NamaSertifikasi'];
			$data['TglPerolehan']  = $_POST['TglPerolehan'];
			$data['TglExpire']  = $_POST['TglExpire'];
			$data['Keterangan']  = $_POST['Keterangan'];
			$data['File']  = $_FILES['File'];
			$data['Dir']  = "../../img/Sertifikasi/";
			$result = TambahSertifiksai($data);
		} catch (PDOException $e) {
			$result = $e->getMessage();
		}
		echo json_encode($result);
		break;
	case 'TambahKerja':
		try {
			$data['Id']  = $_POST['Id'];
			$data['Instansi']  = $_POST['Instansi'];
			$data['TglMasuk']  = $_POST['TglMasuk'];
			$data['TglKeluar']  = $_POST['TglKeluar'];
			$data['Upah']  = angka($_POST['Upah']);
			$data['File']  = $_FILES['File'];
			$data['Dir']  = "../../img/PengalamanKerja/";
			$result = TambahKerja($data);
		} catch (PDOException $e) {
			$result = $e->getMessage();
		}
		echo json_encode($result);
		break;
	case "LoadData":
		$rule = $_POST['rule'];
		switch ($rule) {
			case 'CountData':
				$LoadData = CountData();
				echo json_encode($LoadData);
				break;
			
			
		}

		break;
	
	
}

?>