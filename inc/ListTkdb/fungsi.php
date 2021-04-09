<?php

    function CekSoal($Id){
        $now = date("Y-m-d");
        $sql = "SELECT COUNT(Id) as tot FROM careesma_tkdb_soal WHERE IdJobVacancy = '$Id'";
        $row = $GLOBALS['db']->query($sql);
        $row = $row->fetch(PDO::FETCH_ASSOC);
        if($row['tot'] > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function CekWaktuUjian($IdJ){
        $IdUser = LoadDataDiri();
        $IdUser = empty($IdUser['Id']) ? "" : $IdUser['Id'];
        $Now = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM careesma_tkdb WHERE UserId = '$IdUser' AND IdJobVacancy = '$IdJ'";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        if($row > 0){
            $dt = $query->fetch(PDO::FETCH_ASSOC);
            if(!empty($dt['WaktuSelesai'])){
                return "ujian_selesai";
            }else{
                return "sedang_berlangsung";
            }
        }else{
            return "belum_mulai";
        }

    }

    function LoadData(){
        $IdUser = LoadDataDiri();
        $IdUser = empty($IdUser['Id']) ? "" : $IdUser['Id'];
        $sql = "SELECT a.*, b.Nama FROM careesma_job_vacansy a  INNER JOIN careesma_kategori_job b ON a.IdKategori = b.Id INNER JOIN careesma_lulus c ON a.Id = c.IdJobVacancy WHERE c.IdUser = '$IdUser' ORDER BY a.Id DESC";
        $query = $GLOBALS['db']->query($sql);
        $res=array();
        $Row = $query->rowCount();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $res['data'][] = $r;
        }
        $res['Jum'] = $Row;
        return $res;
    }
    function LoadDataDiri(){
        $Email = $_SESSION['Careesma_Username'];
        $koneksi = $GLOBALS['db'];
        $query = $koneksi->prepare("SELECT * FROM careesma_data_diri WHERE Email = :Email");
        $query->bindParam("Email", $Email,PDO::PARAM_STR);
        $query->execute();
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    function CekBerkas(){
        $User = LoadDataDiri();
        if( (!empty($User['FileIjazah']) && !empty($User['FileKtp'])) || (file_exists("../../img/Ijazah/".$User['FileIjazah']) && file_exists("../../img/Ktp/".$User['FileKtp'])) ){
            return true;
        }else{
            return false;
        }
    }
    

    
    // function getNilai($data){
    //     $res['status'] = "gagal";
    //     $res['data'] = 0;
    //     $IdUser = LoadDataDiri();
    //     $sql = "SELECT Nilai FROM careesma_nilai WHERE IdJobVacancy = :IdJobVacancy AND	UserId = :UserId";
    //     $query = $GLOBALS['db']->prepare($sql);
    //     $query->bindParam("IdJobVacancy",$data['IdJ']);
    //     $query->bindParam("UserId",$IdUser['Id']);
    //     $query->execute();
    //     if($query){
    //         $r = $query->fetch(PDO::FETCH_ASSOC);
    //         $res['status'] = "sukses";
    //         $res['data'] = $r['Nilai'];
    //     }
    //     return $res;
    // }

    function LowonganTerdaftarNilai($IdJ){
        $IdUser = LoadDataDiri();
        $sql = "SELECT COUNT(Id) as tot FROM careesma_nilai WHERE IdJobVacancy = '$IdJ' AND UserId = '$IdUser[Id]'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

   
    
    

    

?>