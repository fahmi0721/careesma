<?php


// 1
function CreateSessionSoal($IdJ){
    $sql = "SELECT Soal FROM careesma_tkdb_soal WHERE IdJobVacancy = '".$IdJ."' LIMIT 1";
    $query = $GLOBALS['db']->query($sql);
    $r = $query->fetch(PDO::FETCH_ASSOC);
    $r = json_decode(base64_decode($r['Soal']),true);
    return $r;
}
// 2
function TextKode($Kode){
    $sql = "SELECT Judul, IsiText FROM careesma_text WHERE Kode = '$Kode'";
    $query = $GLOBALS['db']->query($sql);
    $row = $query->rowCount();
    $res = array();
    if($row > 0){
        $r = $query->fetch(PDO::FETCH_ASSOC);
        $res['Row'] = $row;
        $res['Judul'] = $r['Judul'];
        $res['IsiText'] = $r['IsiText'];
        return $res;
    }else{
        $res['Row'] = $row;
        $res['Judul'] = "";
        $res['IsiText'] = "";
        return $res;
    }
}
// 3
function getWaktuMulai($IdJ){
    $Ses = "SD".$IdJ.$_SESSION['Careesma_Id'];
    $IdData = $GLOBALS['db']->query("SELECT Id FROM careesma_data_diri WHERE Email = '".$_SESSION['Careesma_Username']."'")->fetch(PDO::FETCH_ASSOC);
    $getWaktuMulai = "SELECT WaktuMulai FROM careesma_tkdb WHERE IdJobVacancy = '$IdJ' AND UserId = '".$IdData['Id']."'";
    $query = $GLOBALS['db']->query($getWaktuMulai);
    $row = $query->rowCount();
    $res=array();
    if($row > 0){   
        $r = $query->fetch(PDO::FETCH_ASSOC);
        $_SESSION[$Ses]['Waktu'] = $r['WaktuMulai'];
        return $_SESSION[$Ses]['Waktu'];
    }else{
        $Now = date("Y-m-d H:i:s");
        $sql = "INSERT INTO careesma_tkdb SET WaktuMulai = '$Now', UserId = '$IdData[Id]', IdJobVacancy = '$IdJ'";
        $query = $GLOBALS['db']->query($sql);
        $_SESSION[$Ses]['Waktu'] = $Now;
        return $_SESSION[$Ses]['Waktu'];
    }
    return $_SESSION[$Ses]['Waktu'];
}
// 4
function getIdUser(){
    $email = $_SESSION['Careesma_Username'];
    $sql = "SELECT * FROM careesma_data_diri WHERE Email = '$email'";
    $query = $GLOBALS['db']->query($sql);
    $r = $query->fetch(PDO::FETCH_ASSOC);
    return $r;
}
// 5
function CekJawaban($IdJ,$KodeSoal,$IdUser){
    $sql = "SELECT COUNT(Id) as tot FROM careesma_jawaban_tkdb WHERE KodeSoal = '$KodeSoal' AND IdJobVacancy = '$IdJ' AND UserId = '$IdUser'";
    $r = $GLOBALS['db']->query($sql)->fetch(PDO::FETCH_ASSOC);
    return $r['tot'];
    
}
// 6
function TambahJawaban($IdJ,$KodeSoal){
    $IdUser = getIdUser();
    $cekJawaban = CekJawaban($IdJ,$KodeSoal,$IdUser['Id']);
    if($cekJawaban <= 0){
        $sql = "INSERT INTO careesma_jawaban_tkdb SET UserId = '".$IdUser['Id']."', KodeSoal = '".$KodeSoal."', IdJobVacancy = '".$IdJ."', 	TglCreate = Now()";
        $query = $GLOBALS['db']->query($sql);
        return true;
    }else{
        return true;
    }
}
// 7
function getNomorSoal($IdJ){
    $Ses = "SD".$IdJ.$_SESSION['Careesma_Id'];
    $r = array();
    foreach($_SESSION[$Ses]['TempSoal'] as $key => $data){
        $r[$data['Kode']] = $data['NoSoal'];
    }
    return $r;
}
// 8
function AllRagu($IdJ){
    $DataNomorSoal = getNomorSoal($IdJ);
    $IdUser = getIdUser();
    $sql = "SELECT KodeSoal FROM careesma_jawaban_tkdb WHERE IdJobVacancy = '$IdJ' AND UserId = '$IdUser[Id]' AND `Status` = '2'";
    $query = $GLOBALS['db']->query($sql);
    $res = array();
    $res['Data'] = array();
    while($r = $query->fetch(PDO::FETCH_ASSOC)){
        if(array_key_exists($r['KodeSoal'],$DataNomorSoal)){
            $res['Data'][] = $DataNomorSoal[$r['KodeSoal']]; 
        }
    }
    $res['Row'] = count($res['Data']);
    return $res;
}
// 9
function AllTerjawab($IdJ){
    $DataNomorSoal = getNomorSoal($IdJ);
    $IdUser = getIdUser();
    $sql = "SELECT KodeSoal FROM careesma_jawaban_tkdb WHERE IdJobVacancy = '$IdJ' AND UserId = '$IdUser[Id]' AND `Status` = '1'";
    $query = $GLOBALS['db']->query($sql);
    $res = array();
    $res['Data'] = array();
    while($r = $query->fetch(PDO::FETCH_ASSOC)){
        if(array_key_exists($r['KodeSoal'],$DataNomorSoal)){
            $res['Data'][] = $DataNomorSoal[$r['KodeSoal']]; 
        }
    }
    $res['Row'] = count($res['Data']);
    return $res;
}
// 10
function LoadSoal($IdJ,$posisi=null){
    $Ses = "SD".$IdJ.$_SESSION['Careesma_Id'];
    $SoalTkdb = $_SESSION[$Ses]['TempSoal'][$posisi];
    $r = array();
    $r['JumlahSoal'] = count($_SESSION[$Ses]['TempSoal']);
    $r['Soal'] = base64_decode($SoalTkdb['Soal']);
    $r['KodeText'] = TextKode($SoalTkdb['KodeText']);
    $r['NoSoal'] = sprintf("%02d",$SoalTkdb['NoSoal']);
    $r['Temp'] = $SoalTkdb;
    $r['Kode'] = $SoalTkdb['Kode'];
    $r['PilihanJawaban'] = json_decode(base64_decode($SoalTkdb['PilihanJawaban']),true);
    TambahJawaban($IdJ,$SoalTkdb['Kode']);
    $r['Jawaban'] = All($IdJ,$SoalTkdb['Kode']);
    $r['JawabanRagu'] = AllRagu($IdJ);
    $r['JawabanTerjawab'] = AllTerjawab($IdJ);
    return $r;
}
// 11
function All($IdJ,$KodeSoal){
    $IdUser = getIdUser();
    $sql = "SELECT Jawaban FROM careesma_jawaban_tkdb WHERE KodeSoal = '$KodeSoal' AND 	IdJobVacancy = '$IdJ' AND UserId = '".$IdUser['Id']."'";
    $query = $GLOBALS['db']->query($sql);
    $r = $query->fetch(PDO::FETCH_ASSOC);
    $Jawaban = !empty($r['Jawaban']) ? base64_decode($r['Jawaban']) : "";
    return $Jawaban;
}
// 12
function SisahWaktu($WaktuMulai,$JumWaktu){
    $DateLast = date("Y-m-d H:i:s", strtotime('+'.$JumWaktu.' minutes', strtotime($WaktuMulai)));
    $DateNow = date("Y-m-d H:i:s");
    $Selisih = SelisihWaktu($DateNow,$DateLast);
    return $Selisih;
}
// 13
function SelisihWaktu($date1,$date2){
    $res = array();
    $diff = abs(strtotime($date1) - strtotime($date2)); 
    $cek = strtotime($date1) - strtotime($date2); 
    $res['Waktu']   = $cek; 
    $res['tahun']   = floor($diff / (365*60*60*24)); 
    $res['bulan']  = floor(($diff - $res['tahun'] * 365*60*60*24) / (30*60*60*24)); 
    $res['hari']    = floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24)/ (60*60*24));
    $res['jams']   = floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24)/ (60*60)); 
    $res['jam']   = sprintf("%02d",floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24)/ (60*60))); 
    $res['menit']  = sprintf("%02d",floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24 - $res['jam']*60*60)/ 60)); 
    $res['detik'] = sprintf("%02d",floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24 - $res['jam']*60*60 - $res['menit']*60))); 
    return $res;
}
// 14
function UpdateJwaban($data,$st){
    $r = array();
    try {
        $IdUser = getIdUser();
        $Jawaban =  base64_encode($data['Jawaban']);
        $Status = "1";
        $sql = "UPDATE careesma_jawaban_tkdb SET Jawaban = :Jawaban, `Status` = :Statuss WHERE KodeSoal = :KodeSoal AND IdJobVacancy = :IdJobVacancy AND UserId = :UserId";
        $query = $GLOBALS['db']->prepare($sql);
        $query->bindParam("Jawaban", $Jawaban);
        $query->bindParam("Statuss", $Status);
        $query->bindParam("KodeSoal", $data['KodeSoal']);
        $query->bindParam("IdJobVacancy", $data['IdJ']);
        $query->bindParam("UserId", $IdUser['Id']);
        $query->execute();
        $r['status'] = "sukses";
        $r['message'] = "berhasil mengupdate jawaban";
        return $r;
    } catch (PDOException $e) {
        $r['status'] = "gagal";
        $r['message'] = $e->getMessage();
        return $r;
    }
    
    
}
// 15
function GenerateSoalJawaban($Soal){
    $res = array();
    $res['data'] = array();
    foreach($Soal as $key => $data){
        $res['data'][$data['Kode']] = $data['NoSoal'];
    }
    $res['Row'] = COUNT($res['data']);
    return $res;
}
// 16
function GenerateJawaban($IdJ){
    $IdUser =getIdUser();
    $res = array();
    $res['data'] = array();
    $sql = "SELECT KodeSoal, Jawaban FROM careesma_jawaban_tkdb WHERE IdJobVacancy = '$IdJ' AND UserId = '$IdUser[Id]'";
    $query = $GLOBALS['db']->query($sql);
    while($r = $query->fetch(PDO::FETCH_ASSOC)){
        $res['data'][$r['KodeSoal']] = $r['Jawaban'];
    }
    $res['Row'] = COUNT($res['data']);
    return $res;
}
// 17
function LoadDataJawaban($data){
    $res = array();
    $r['No'] = array();
    $r['Jawaban'] = array();
    $IdJ = $data['IdJ'];
    $Ses = "SD".$IdJ.$_SESSION['Careesma_Id'];
    $AllSoal = GenerateSoalJawaban($_SESSION[$Ses]['TempSoal']);
    $AllJawaban = GenerateJawaban($IdJ);
    $JumTerjawab = 0;
    $JumBelum = 0;
    foreach($AllSoal['data'] as $key => $NoSoal ){
        $iData = $AllJawaban['data'];
        if(array_key_exists($key,$iData) AND $iData[$key] != ""){
            $r['No'] = $NoSoal;
            $r['Jawaban'] = base64_decode($iData[$key]);
            $res['data'][] = $r;
            $JumTerjawab++;
        }else{
            $r['No'] = $NoSoal;
            $r['Jawaban'] = "belum dijawab";
            $res['data'][] = $r;
            $JumBelum++;
        }
    }
    $res['Terjawab'] = $JumTerjawab;
    $res['Belum'] = $JumBelum;
    $res['JumlahSoal'] = COUNT($AllSoal['data']);
    return $res;
}
// 18
function TombolSelesai($IdJ){
    $Ses = "SD".$IdJ.$_SESSION['Careesma_Id'];
    $SoalTkdb = $_SESSION[$Ses]['TempSoal'];
    $JumlahSoal = COUNT($SoalTkdb);
    $IdUser = getIdUser();
    $sql = "SELECT COUNT(Id) as tot FROM careesma_jawaban_tkdb WHERE UserId = '$IdUser[Id]' AND IdJobVacancy = '$IdJ' AND `Status` = '1'";
    $query = $GLOBALS['db']->query($sql);
    $r = $query->fetch(PDO::FETCH_ASSOC);
    $res = array();
    if($r['tot'] == $JumlahSoal){
        $res['status'] = "OK";
    }else{
        $res['status'] = "";
    }
    return $res;
}
// 19
function GenerateHasil($IdJ){
    $IdUser = getIdUser();
    $LoadJawaban = getJawabanAll($IdJ,$IdUser['Id']);
    $res = array();
    $JumlahNilai =0;
    foreach($LoadJawaban as $key => $Jawaban){
        $Nilai = 0;
        $sql = "SELECT Bobot FROM careesma_soal WHERE Kode = '$key' AND FROM_BASE64(KunciJawaban) = '$Jawaban'";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        if($row > 0){
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $res['data'][$key] = $r['Bobot'];
        }else{
            $res['data'][$key] = 0;
        }
        $JumlahNilai = $JumlahNilai + $res['data'][$key];
    }
    $res['Nilai'] = $JumlahNilai;
    $res['IdJ'] = $IdJ;
    $res['UserId'] = $IdUser['Id'];
    UpdateWaktuSelesai($res['UserId'], $res['IdJ']);
    $iRes = TambahNilai($res);
    return $iRes;
}
// 20
function getJawabanAll($IdJ,$IdUser){
    $sql = "SELECT KodeSoal , FROM_BASE64(Jawaban) as Jwb FROM careesma_jawaban_tkdb WHERE IdJobVacancy = '$IdJ' AND UserId = '$IdUser'";
    $query = $GLOBALS['db']->query($sql);
    $res = array();
    while($r = $query->fetch(PDO::FETCH_ASSOC)){
        $res[$r['KodeSoal']] = $r['Jwb'];;
    }
    return $res;
}
// 21

function CekNilaiData($IdJ, $IdUser){
    $sql = "SELECT COUNT(Id) as tot FROM careesma_nilai WHERE IdJobVacancy = '$IdJ' AND UserId = '$IdUser'";
    $query = $GLOBALS['db']->query($sql);
    $r = $query->fetch(PDO::FETCH_ASSOC);
    return $r['tot'];
}
// 22
function TambahNilai($data){
    $res = array();
    try {
        $cek = CekNilaiData($data['IdJ'],$data['UserId']);
            if($cek <= 0){
            $TglCreate = date("Y-m-d H:i:s");
            $DetailPenilaian = base64_encode(json_encode($data['data']));
            $sql = "INSERT INTO careesma_nilai SET 	DetailPenilaian = :DetailPenilaian, IdJobVacancy = :IdJobVacancy, Nilai = :Nilai, UserId = :UserId , TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("DetailPenilaian", $DetailPenilaian);
            $query->bindParam("IdJobVacancy", $data['IdJ']);
            $query->bindParam("Nilai", $data['Nilai']);
            $query->bindParam("UserId", $data['UserId']);
            $query->bindParam("TglCreate", $TglCreate);
            $query->execute();
            $res['status'] = "sukses";
            $res['message'] = "berhasil";
            return $res;
        }else{
            $res['status'] = "error";
            $res['message'] = "data sudah di nilai";
            return $res;
        }
    } catch (PDOException $er) {
        $res['status'] = "error";
        $res['message'] = "Server Error : ".$er->getMessage();
        return $res;
    }
    
    
}

function UpdateWaktuSelesai($IdUser, $IdJ){
    $WaktuSelesai = date("Y-m-d H:i:s");
    $sql = "UPDATE careesma_tkdb SET WaktuSelesai = :WaktuSelesai WHERE UserId = :UserId AND IdJobVacancy = :IdJobVacancy";
    $query = $GLOBALS['db']->prepare($sql);
    $query->bindParam("WaktuSelesai",$WaktuSelesai);
    $query->bindParam("UserId",$IdUser);
    $query->bindParam("IdJobVacancy",$IdJ);
    $query->execute();
    if($query){
        return true;
    }else{
        return false;
    }
}
?>