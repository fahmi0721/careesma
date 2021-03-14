<?php

    

    function Filter($str){
        if(!empty($str)){
            $result = "WHERE (Judul LIKE '%".$str."%')";
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
            $sql = "SELECT Id, Kode, Judul, IsiText FROM careesma_text $FilterSearch";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $total_page = ceil($JumRow / $RowPage);
            $result['total_page'] = $total_page;
            $result['total_data'] = $JumRow;
            $sql = $sql." ORDER BY Id ASC LIMIT ".$offset.",".$RowPage;
            $query = $db->query($sql);

            if($JumRow > 0){
                $result['data_new'] = $no;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                    $Isi = base64_encode($res['IsiText']);
                    $IsiText = "<center><a class='btn btn-xs btn-success' data-toggle='tooltip' title='Lihat Isi Text' onclick=\"Crud('".$Isi."','IsiText')\"><i class='fa fa-eye'></i></a></center>";
                    $aksi = "<a class='btn btn-xs btn-primary' data-toggle='tooltip' title='Edit Data' onclick=\"Crud('".$res['Id']."','ubah')\"><i class='fa fa-edit'></i></a> <a class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick=\"Crud('".$res['Id']."','hapus')\"><i class='fa fa-trash-o'></i></a>";
                    $res['No'] = $no;
                    $res['Judul'] = $res['Judul'];
                    $res['Kode'] = $res['Kode'];
                    $res['IsiText'] = $IsiText;
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
        $sql = "SELECT MAX(RIGHT(Kode,3)) as Kode FROM careesma_text ORDER BY Id DESC";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        if($row <= 0){
            return "TX001";
        }else{
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $Kode = intval($r['Kode'])+1;
            return "TX".sprintf("%03d",$Kode);
        }
    }


    function TambahData($data){
        try {
            $data['TglCreate'] = date("Y-m-d H:i:s");
            $Kode = getKode();
            $sql = "INSERT INTO careesma_text SET  Kode = :Kode, Judul = :Judul, IsiText = :IsiText, TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Kode", $Kode);
            $query->bindParam("Judul", $data['Judul']);
            $query->bindParam("IsiText", $data['IsiText']);
            $query->bindParam("TglCreate", $data['TglCreate']);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil menambah data Text!";
            return $msg;
        } catch (PDOException $e) {
            $msg['status'] = "gagal";
            $msg['pesan'] = $e->getMessage();
            return $msg;
        }
         
     }

    function UbahData($data){
          try {
           $data['TglUpdate'] = date("Y-m-d H:i:s");
            $Kode = getKode();
            $sql = "UPDATE careesma_text SET Judul = :Judul, IsiText = :IsiText, TglUpdate = :TglUpdate WHERE Id = :Id";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Judul", $data['Judul']);
            $query->bindParam("IsiText", $data['IsiText']);
            $query->bindParam("TglUpdate", $data['TglUpdate']);
            $query->bindParam("Id", $data['Id']);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil mengubah data Text!";
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
            $sql = "DELETE FROM careesma_text WHERE Id = :Id";
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
        $sql = "SELECT * FROM careesma_text WHERE Id = :Id";
        $exc = $koneksi->prepare($sql);
        $exc->bindParam("Id", $Id, PDO::PARAM_INT);
        $exc->execute();
        $dt = $exc->fetch(PDO::FETCH_ASSOC);
        return $dt;
    }



    

?>