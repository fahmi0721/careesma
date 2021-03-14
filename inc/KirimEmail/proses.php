<?php
session_start();
include_once '../../config/config.php';
include_once 'fungsi.php';


$_SESSION['Id'] = 1;
$UserUpdate = $_SESSION['Id'];
$date = date("Y-m-d H:i:s");
$proses = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : "";
switch ($proses) {
	case 'DetailData':
		try {
			$result = DetailData($_POST);
		} catch (PDOException $e) {
			$result = $e->getMessage();
		}


		echo json_encode($result);
		break;
	
	case 'Crud':
		$aksi = $_POST['aksi'];
		switch ($aksi) {
			case 'insert':
				try {
					$data = array(
						"IdLowongan" => $_POST['IdLowongan'],
						"IdUser" => $_POST['IdUser'],
						"Pesan" => $_POST['Pesan'],
						"Subjek" => $_POST['Subjek'],
					);
					$pushdata = SaveData($data);
					echo json_encode($pushdata);
				} catch (PDOException $e) {
					$msg['status'] = "gagal";
					$msg['pesan'] = $e->getMessage();
					echo json_encode($msg);
				}
				break;
			case 'update':
				try {
					$data = array(
						"Id" => $_POST['Id'],
						"IdKategori" => $_POST['IdKategori'],
						"Judul" => $_POST['Judul'],
						"Kuota" => $_POST['Kuota'],
						"TglBerlaku" => $_POST['TglBerlaku'],
						"DeskripsiPekerjaan" => $_POST['DeskripsiPekerjaan'],
						"Persyaratan" => $_POST['Persyaratan'],
						"File" => $_FILES['Flayer'],
						"Dir" => "../../img/Flayer/"
					);
					$pushdata = UbahData($data);
					echo json_encode($pushdata);
				} catch (PDOException $e) {
					$msg['status'] = "gagal";
					$msg['pesan'] = $e->getMessage();
					echo json_encode($msg);
				}
				
				break;
			case 'delete':
				try {
					$data['Id'] = $_POST['Id'];
					$data['Dir'] = "../../img/Flayer/";
					$pushdata = HapusData($data);
					echo json_encode($pushdata);
				} catch (PDOException $e) {
					$msg['status'] = "gagal";
					$msg['pesan'] = $e->getMessage();
					echo json_encode($msg);
				}
				
				break;
			
		}
		break;

	case 'ShowData':
		$Id = $_POST['Id'];
		$res = ShowData($Id);
		echo json_encode($res);
		break;
	case 'LoadData':
		$rule = $_POST['rule'];
		switch ($rule) {
			case 'getLowongan':
				$result = DataLowongan();
				echo json_encode($result);
				break;
			
			
		}
		break;
}

?>