<?php
session_start();
include_once '../../config/config.php';
include_once 'fungsi.php';
$date = date("Y-m-d H:i:s");
$proses = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : "";
switch ($proses) {
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