<?php

    function LoadFormulaTkdb(){
        $sql = "SELECT 	IdJobVacancy FROM careesma_tkdb_soal ORDER BY Id ASC";
        $query = $GLOBALS['db']->query($sql);
        $res = array();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $res[] = $r['IdJobVacancy'];
        }
        return $res;
    }
    function getLoker(){
        $LoadFormulaTkdb = LoadFormulaTkdb();
        $sql = "SELECT Id, Judul FROM careesma_job_vacansy ORDER BY Id ASC";
        $query = $GLOBALS['db']->query($sql);
        $res = array();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            if(!in_array($r['Id'],$LoadFormulaTkdb)){
                $res[] = $r;
            }
        }
        return $res;
    }

    function Filter($str){
        if(!empty($str)){
            $result = "WHERE (b.Judul LIKE '%".$str."%')";
        }else{
            $result = "";
        }

        return $result;
    }


    function DetailData($data){
        $db = $GLOBALS['db'];
        $result = array();
        $row = array(); 
        if(is_array($data)){
            $Search = $data['Search'];
            $Page = $data['Page'];
            $RowPage = $data['RowPage'];
            $offset=($Page - 1) * $RowPage;
            $no=$offset+1;
            $FilterSearch = Filter($Search);
            $sql = "SELECT a.Id, a.Kode, b.Judul,a.Soal FROM  careesma_tkdb_soal a INNER JOIN careesma_job_vacansy b ON a.IdJobVacancy = b.Id $FilterSearch";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $total_page = ceil($JumRow / $RowPage);
            $result['total_page'] = $total_page;
            $result['total_data'] = $JumRow;
            $sql = $sql." ORDER BY a.Id ASC LIMIT ".$offset.",".$RowPage;
            $query = $db->query($sql);

            if($JumRow > 0){
                $result['data_new'] = $no;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                    $Soal = "<center><a class='btn btn-xs btn-success' data-toggle='tooltip' title='Lihat Isi Text' onclick=\"Crud('".$res['Soal']."','IsiText')\"><i class='fa fa-eye'></i></a></center>";
                    $aksi = "<a class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick=\"Crud('".$res['Id']."','hapus')\"><i class='fa fa-trash-o'></i></a>";
                    $res['No'] = $no;
                    $res['Judul'] = $res['Judul'];
                    $res['Kode'] = $res['Kode'];
                    $res['Soal'] = $Soal;
                    $res['Aksi'] = $aksi;
                    $result['data'][] = $res;
                    $no++;
                }
                $result['data_last'] = $no -1;
            }else{
                $result['data']='';
            }
            return $result; 
        }else{

        }
        
    }

    function getKode(){
        $sql = "SELECT MAX(RIGHT(Kode,3)) as Kode FROM careesma_tkdb_soal ORDER BY Id DESC";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        if($row <= 0){
            return "FS001";
        }else{
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $Kode = intval($r['Kode'])+1;
            return "FS".sprintf("%03d",$Kode);
        }
    }

    function Soal(){
        $sql = "SELECT Kode, KodeText, NoSoal, Soal, PilihanJawaban FROM careesma_soal ORDER BY NoSoal ASC";
        $query = $GLOBALS['db']->query($sql);
        $res = array();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $res[] = $r;
        }
        return base64_encode(json_encode($res));
    }

    function TambahData($data){
        try {
            $data['TglCreate'] = date("Y-m-d H:i:s");
            $Kode = getKode();
            $Soal = Soal();
            $sql = "INSERT INTO careesma_tkdb_soal SET Kode = :Kode, IdJobVacancy = :IdJobVacancy, Soal = :Soal, TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Kode", $Kode);
            $query->bindParam("IdJobVacancy", $data['IdJobVacancy']);
            $query->bindParam("Soal", $Soal);
            $query->bindParam("TglCreate", $data['TglCreate']);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil menambah data Formula TKDB!";
            return $msg;
        } catch (PDOException $e) {
            $msg['status'] = "gagal";
            $msg['pesan'] = "sss".$e->getMessage();
            return $msg;
        }
         
     }

   
    
    function HapusData($data){
        $koneksi = $GLOBALS['db'];
        if(is_array($data)){
            $sql = "DELETE FROM careesma_tkdb_soal WHERE Id = :Id";
            $exc = $koneksi->prepare($sql);
            $exc->bindParam('Id', $data['Id'], PDO::PARAM_INT);
            $exc->execute();
            if($exc){
                $result['status'] = "sukses";
                $result['pesan'] = "Berhasil menghapus data Formula TKDB!";
            }else{
                $result['status'] = "gagal";
                $result['pesan'] = "Error : Query Error Kode Error(500)";
            }
            return $result;
        }else{
            $result['status'] = "gagal";
            $result['pesan'] = "Error : Pengriman Data Gagal. Kode : Error(300)";
            return $result;
        }
    }

    function ShowData($Id){
        $koneksi = $GLOBALS['db'];
        $sql = "SELECT * FROM careesma_tkdb_soal WHERE Id = :Id";
        $exc = $koneksi->prepare($sql);
        $exc->bindParam("Id", $Id, PDO::PARAM_INT);
        $exc->execute();
        $dt = $exc->fetch(PDO::FETCH_ASSOC);
        return $dt;
    }



    

?>