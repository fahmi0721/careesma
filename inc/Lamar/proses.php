<?php
session_start();
include_once '../../config/config.php';
include_once 'fungsi.php';
$_SESSION['Id'] = 1;
$UserUpdate = $_SESSION['Id'];
$date = date("Y-m-d H:i:s");
$proses = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : "";
switch ($proses) {
	case 'Lamar':
		try {
			$result = Lamar($_POST);
		} catch (PDOException $e) {
			$result = $e->getMessage();
		}
		echo json_encode($result);
		break;
	
}

?>