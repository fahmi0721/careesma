<?php 
session_start();
include "../config/config.php";
include "fungsi.php";
$proses=isset($_GET['proses'])?$_GET['proses']:null;

switch($proses){
    case 'LoadDataCart':
		$res = LoadDataCart();
		echo json_encode($res);
		break;
	case 'LoadRealTiimeTkdb':
		$res = LoadRealTiimeTkdb();
		echo json_encode($res);
		break;
	case 'RealTimeNilaiTkdb':
		$res = RealTimeNilaiTkdb();
		echo json_encode($res);
		break;
	case "ExecuteDataLama":
		$res = ExecuteDataLama();
		echo json_encode($res);
		break;

}

?>


