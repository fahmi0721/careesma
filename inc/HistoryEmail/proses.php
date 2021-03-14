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
				"RowPage" => $_POST['RowPage'],
				"IdLowongan" => $_POST['IdLowongan'],
			);
			$result = DetailData($data);
		} catch (PDOException $e) {
			$result = $e->getMessage();
		}


		echo json_encode($result);
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