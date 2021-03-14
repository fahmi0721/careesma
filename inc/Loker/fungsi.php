<?php
    function LoadLowongan(){
        $TglNow = date("Y-m-d");
        $sql = "SELECT a.*, b.Nama FROM careesma_job_vacansy a  INNER JOIN careesma_kategori_job b ON a.IdKategori = b.Id WHERE a.TglBerlaku >= '$TglNow' ORDER BY a.Id DESC";
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
        $Email = $_SESSION['Username'];
        $koneksi = $GLOBALS['db'];
        $query = $koneksi->prepare("SELECT * FROM careesma_data_diri WHERE Email = :Email");
        $query->bindParam("Email", $Email,PDO::PARAM_STR);
        $query->execute();
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    function ValidasiLamaran($Id,$IdUser){
        $sql = "SELECT COUNT(Id) as tot FROM careesma_daftar WHERE IdJobVacancy = '$Id' AND IdUser = '$IdUser'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);;
        return $r['tot'];
    }

    
    function Lamar($data){
        $cekLamaran = ValidasiLamaran($data['Id'],$data['IdUser']);
        if($cekLamaran > 0){
            $result['status'] = "gagal";
            $result['pesan'] = "Anda telah mendaftar di lowongan ini.";
            return $result;
        }else{
            $TglCreate = date("Y-m-d H:i:s");
            $sql = "INSERT INTO careesma_daftar SET IdJobVacancy = :IdJobVacancy, IdUser = :IdUser, Alasan = :Alasan, TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("IdJobVacancy",$data['Id']);
            $query->bindParam("IdUser",$data['IdUser']);
            $query->bindParam("Alasan",$data['Alasan']);
            $query->bindParam("TglCreate",$data['TglCreate']);
            $query->execute();
            $result['status'] = "gagal";
            $result['pesan'] = "terima kasih telah mendaftar di lowongan ini. semoga anda lulus ya";
            return $result;
        }
    }

    

    

?>