<?php
    function LoadDataDiri(){
        $Email = $_SESSION['Careesma_Username'];
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
            $result['pesan'] = "Selamat anda telah terdaftar pada lowongan ini dan kami akan memeriksa berkas anda. Jika memenuhi persyaratan tahapan Seleksi berikutnya akan kami informasikan melalui email yang terdaftar pada akun anda";
            return $result;
        }
    }

    function LoadLowongan($Id){
        $sql = "SELECT a.*, b.Nama FROM careesma_job_vacansy a  INNER JOIN careesma_kategori_job b ON a.IdKategori = b.Id WHERE a.Id = '$Id' ORDER BY a.Id DESC";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    

?>