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
			$data = array(
				"Page" => $_POST['Page'],
				"Search" => $_POST['Search'],
				"RowPage" => $_POST['RowPage']
			);
			$result = DetailData($data);
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
					unset($_POST['aksi']);
					$data = $_POST;
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
					unset($_POST['aksi']);
					$data = $_POST;
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
					unset($_POST['aksi']);
					$data = $_POST;
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
			case 'NoSoal':
				unset($_POST['rule']);
				$LoadData = NoSoal($_POST);
				echo json_encode($LoadData);
				break;
			case 'getText':
				unset($_POST['rule']);
				$LoadData = getTextd($_POST);
				echo json_encode($LoadData);
				break;
			
			
		}
		break;
}

?>