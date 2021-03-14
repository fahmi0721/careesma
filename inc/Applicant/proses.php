<?php
session_start();
include_once '../../config/config.php';
include_once 'fungsi.php';
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
						"Nama" => strtoupper($_POST['Nama']),
						"Deskripsi" => $_POST['Deskripsi'],
					);
					$pushdata = TambahData($data);
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
						"Nama" => strtoupper($_POST['Nama']),
						"Deskripsi" => $_POST['Deskripsi'],
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
		switch($rule){
			case 'Pendidikan':
				$LoadData = Pendidikan();
				echo json_encode($LoadData);
				break;
			case 'Ktp':
				$LoadData = Ktp();
				echo json_encode($LoadData);
				break;
		}

		break;
}

?>