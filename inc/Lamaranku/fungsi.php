<?php
    function LoadLowongan(){
        $IdUser = LoadDataDiri();
        $IdUser = $IdUser['Id'];
        $sql = "SELECT a.*, b.Nama FROM careesma_job_vacansy a  INNER JOIN careesma_kategori_job b ON a.IdKategori = b.Id INNER JOIN careesma_daftar c ON a.Id = c.IdJobVacancy WHERE c.IdUser = '$IdUser' ORDER BY a.Id DESC";
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

    

    
    function getNilai($data){
        $res['status'] = "gagal";
        $res['data'] = 0;
        $IdUser = LoadDataDiri();
        $sql = "SELECT Nilai FROM careesma_nilai WHERE IdJobVacancy = :IdJobVacancy AND	UserId = :UserId";
        $query = $GLOBALS['db']->prepare($sql);
        $query->bindParam("IdJobVacancy",$data['IdJ']);
        $query->bindParam("UserId",$IdUser['Id']);
        $query->execute();
        if($query){
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $res['status'] = "sukses";
            $res['data'] = $r['Nilai'];
        }
        return $res;
    }

    function LowonganTerdaftarNilai($IdJ){
        $IdUser = LoadDataDiri();
        $sql = "SELECT COUNT(Id) as tot FROM careesma_nilai WHERE IdJobVacancy = '$IdJ' AND UserId = '$IdUser[Id]'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

   
    
    

    

?>