<?php
include_once 'config/config.php';

$Proses = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : "";
switch($Proses){
    case "getDataPendidikan":
        try {
            $res = array();
            $Row = array();
            $sql = "SELECT Pendidikan FROM careesma_data_diri GROUP BY Pendidikan ORDER BY Pendidikan ASC";
            $query = $db->query($sql);
            while($r = $query->fetch(PDO::FETCH_ASSOC)){
                $res['label'] = $r['Pendidikan'];
                if($res['label'] != null){
                    $Row[] = $res;
                }
            }
            echo json_encode($Row);
        } catch (PDOException $e) {
            $r['label'] = $e->getMessage();
            echo json_encode($r);
        }

        break;
}


?>