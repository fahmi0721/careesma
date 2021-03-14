<?php

    function NoSoal($rs){
        if($rs['aksi'] == "insert"){
            $sql = "SELECT MAX(NoSoal) as NoSoal FROM careesma_soal ORDER BY NoSoal DESC";
            $query = $GLOBALS['db']->query($sql);
            $r = $query->fetch(PDO::FETCH_ASSOC);
            if(!empty($r['NoSoal'])){
                $rsd['No'] = intval($r['NoSoal'])+1;
                $rsd['Nos'] = Terbilang(intval($r['NoSoal'])+1);
            }else{
                $rsd['No'] = 1;
                $rsd['Nos'] = Terbilang(1);
            }
            return $rsd;
        }else{
            $rsd = array();
            $sql = "SELECT NoSoal FROM careesma_soal ORDER BY NoSoal ASC";
            $query = $GLOBALS['db']->query($sql);
            while($r = $query->fetch(PDO::FETCH_ASSOC)){
                $r['Nos'] = Terbilang($r['NoSoal']);
                $r['No'] = $r['NoSoal'];
                $rsd[] = $r;
            }
            return $rsd;
        }
    }

    function getTextd(){
        $sql = "SELECT Kode, Judul FROM careesma_text ORDER BY Id ASC";
        $query = $GLOBALS['db']->query($sql);
        $rs = array();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $rs[] = $r;
        }
        
        return $rs;
    }

    function Filter($str){
        if(!empty($str)){
            $result = "WHERE (Judul LIKE '%".$str."%' || Kode LIKE '%".$str."%')";
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
            $sql = "SELECT NoSoal, Id, Kode, KodeText, Soal,PilihanJawaban,KunciJawaban,Bobot FROM careesma_soal $FilterSearch";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $total_page = ceil($JumRow / $RowPage);
            $result['total_page'] = $total_page;
            $result['total_data'] = $JumRow;
            $sql = $sql." ORDER BY NoSoal ASC LIMIT ".$offset.",".$RowPage;
            $query = $db->query($sql);

            if($JumRow > 0){
                $result['data_new'] = $no;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                    $Isi = $res['PilihanJawaban'];
                    $PilihanJawaban = "<center><a class='btn btn-xs btn-success' data-toggle='tooltip' title='Lihat Pilihan Jawaban' onclick=\"Crud('".$Isi."','PilihanJawaban')\"><i class='fa fa-eye'></i></a></center>";
                    $aksi = "<a class='btn btn-xs btn-primary' data-toggle='tooltip' title='Edit Data' onclick=\"Crud('".$res['Id']."','ubah')\"><i class='fa fa-edit'></i></a> <a class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick=\"Crud('".$res['Id']."','hapus')\"><i class='fa fa-trash-o'></i></a>";
                    $res['No'] = $no;
                    $res['NoSoal'] = $res['NoSoal'];
                    $res['Kode'] = $res['Kode'];
                    $res['KodeText'] = empty($res['KodeText']) ? "Tidak memiliki text" : $res['KodeText'];
                    $res['Bobot'] = $res['Bobot'];
                    $res['Soal'] = base64_decode($res['Soal']);
                    $res['KunciJawaban'] = base64_decode($res['KunciJawaban']);
                    $res['PilihanJawaban'] = $PilihanJawaban;
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
        $sql = "SELECT MAX(RIGHT(Kode,3)) as Kode FROM careesma_soal ORDER BY Id DESC";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        if($row <= 0){
            return "SL001";
        }else{
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $Kode = intval($r['Kode'])+1;
            return "SL".sprintf("%03d",$Kode);
        }
    }

    function BuatPilihan($data){
        $rd = array("A","B","C","D");
        $Key = array_keys($data);
        foreach($Key as $k => $vl){
            if(!in_array($vl,$rd)){
                unset($data[$vl]);
            }
        }
        $res = json_encode($data);
        return base64_encode($res);


    }

    function TambahData($data){
        try {
            $data['TglCreate'] = date("Y-m-d H:i:s");
            $Kode = getKode();
            $KunciJawaban = base64_encode($data['KunciJawaban']);
            $Soal = base64_encode($data['Soal']);
            $PilihanJawaban = BuatPilihan($data);
            $sql = "INSERT INTO careesma_soal SET NoSoal = :NoSoal,  Kode = :Kode, KodeText = :KodeText, Soal = :Soal, PilihanJawaban = :PilihanJawaban, KunciJawaban = :KunciJawaban, Bobot = :Bobot,  TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("NoSoal", $data['NoSoal']);
            $query->bindParam("Kode", $Kode);
            $query->bindParam("KodeText", $data['KodeText']);
            $query->bindParam("Soal", $Soal);
            $query->bindParam("PilihanJawaban", $PilihanJawaban);
            $query->bindParam("KunciJawaban", $KunciJawaban);
            $query->bindParam("Bobot", $data['Bobot']);
            $query->bindParam("TglCreate", $data['TglCreate']);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil menambah data Soal!";
            return $msg;
        } catch (PDOException $e) {
            $msg['status'] = "gagal";
            $msg['pesan'] = $e->getMessage();
            return $msg;
        }
         
     }

    function UpdateNoSoal($NoSoal,$NoSoalBaru){
        $sql = "UPDATE careesma_soal SET NoSoal = '$NoSoalBaru' WHERE NoSoal = '$NoSoal'";
        $query = $GLOBALS['db']->query($sql);
        if($query){
            return $NoSoal;
        }else{
            return $NoSoal;
        }
    }

    function UbahData($data){
          try {
            $dtLama = ShowData($data['Id']);
            $data['TglUpdate'] = date("Y-m-d H:i:s");
            $KunciJawaban = base64_encode($data['KunciJawaban']);
            $Soal = base64_encode($data['Soal']);
            $PilihanJawaban = BuatPilihan($data);
            $NoSoal = $data['NoSoal'] == $dtLama['NoSoal'] ? $data['NoSoal'] : UpdateNoSoal($data['NoSoal'],$dtLama['NoSoal']);

            $sql = "UPDATE careesma_soal SET NoSoal = :NoSoal,  KodeText = :KodeText, Soal = :Soal, PilihanJawaban = :PilihanJawaban, KunciJawaban = :KunciJawaban, Bobot = :Bobot,  TglUpdate = :TglUpdate WHERE Id = :Id";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("NoSoal", $data['NoSoal']);
            $query->bindParam("KodeText", $data['KodeText']);
            $query->bindParam("Soal", $Soal);
            $query->bindParam("PilihanJawaban", $PilihanJawaban);
            $query->bindParam("KunciJawaban", $KunciJawaban);
            $query->bindParam("Bobot", $data['Bobot']);
            $query->bindParam("TglUpdate", $data['TglUpdate']);
            $query->bindParam("Id", $data['Id']);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil mengubah data Soal!";
            return $msg;
        } catch (PDOException $e) {
            $msg['status'] = "gagal";
            $msg['pesan'] = $e->getMessage();
            return $msg;
        }
     }
   
    
    function HapusData($data){
        $koneksi = $GLOBALS['db'];
        if(is_array($data)){
            $sql = "DELETE FROM careesma_soal WHERE Id = :Id";
            $exc = $koneksi->prepare($sql);
            $exc->bindParam('Id', $data['Id'], PDO::PARAM_INT);
            $exc->execute();
            if($exc){
                $result['status'] = "sukses";
                $result['pesan'] = "Berhasil menghapus data Text!";
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
        $sql = "SELECT * FROM careesma_soal WHERE Id = :Id";
        $exc = $koneksi->prepare($sql);
        $exc->bindParam("Id", $Id, PDO::PARAM_INT);
        $exc->execute();
        $dt = $exc->fetch(PDO::FETCH_ASSOC);
        $dt['Soal'] = base64_decode($dt['Soal']);
        $dt['KunciJawaban'] = base64_decode($dt['KunciJawaban']);
        $rss = json_decode(base64_decode($dt['PilihanJawaban']),true);
        $dt['A'] = $rss['A'];
        $dt['B'] = $rss['B'];
        $dt['C'] = $rss['C'];
        $dt['D'] = $rss['D'];
        return $dt;
    }



    

?>