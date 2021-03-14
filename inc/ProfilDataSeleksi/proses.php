<?php
session_start();
include_once '../../config/config.php';
include_once 'fungsi.php';
$date = date("Y-m-d H:i:s");
$proses = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : "";
switch ($proses) {
	case "UpdateLulus":
		$data['IdLowongan'] = $_POST['IdLowongan'];
		$data['IdUser'] = $_POST['IdUser'];
		$data['Ket'] = $_POST['Ket'];
		$res = UpdateLulus($data);
		echo json_encode($res);

		break;
	case "HapusLulus":
		$data['IdLowongan'] = $_POST['IdLowongan'];
		$data['IdUser'] = $_POST['IdUser'];
		$res = HapusLulus($data);
		echo json_encode($res);

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