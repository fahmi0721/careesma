<?php

   

    function Filter($str){
        if(!empty($str)){
            $result = "WHERE (Nama LIKE '%".$str."%')";
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
            $sql = "SELECT * FROM careesma_kategori_job $FilterSearch";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $total_page = ceil($JumRow / $RowPage);
            $result['total_page'] = $total_page;
            $result['total_data'] = $JumRow;
            $sql = $sql." ORDER BY Id DESC LIMIT ".$offset.",".$RowPage;
            $query = $db->query($sql);

            if($JumRow > 0){
                $result['data_new'] = $no;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                    $aksi = "<a class='btn btn-xs btn-primary' data-toggle='tooltip' title='Edit Data' onclick=\"Crud('".$res['Id']."','ubah')\"><i class='fa fa-edit'></i></a> <a class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick=\"Crud('".$res['Id']."','hapus')\"><i class='fa fa-trash-o'></i></a>";
                    $res['No'] = $no;
                    $res['Nama'] = $res['Nama'];
                    $res['Deskripsi'] = $res['Deskripsi'];
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

    
     function TambahData($data){
        try {
            $TglCreate = date("Y-m-d");
            $sql = "INSERT INTO careesma_kategori_job SET  Nama = :Nama, Deskripsi = :Deskripsi, TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Nama", $data['Nama']);
            $query->bindParam("Deskripsi", $data['Deskripsi']);
            $query->bindParam("TglCreate", $TglCreate);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil menambah data Kategori Job!";
            return $msg;
        } catch (PDOException $e) {
            $msg['status'] = "gagal";
            $msg['pesan'] = $e->getMessage();
            return $msg;
        }
         
     }

     function UbahData($data){
          try {
            $sql = "UPDATE careesma_kategori_job SET  Nama = :Nama, Deskripsi = :Deskripsi WHERE Id = :Id";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Nama", $data['Nama']);
            $query->bindParam("Deskripsi", $data['Deskripsi']);
            $query->bindParam("Id", $data['Id']);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil mengubah data Kategori Job!";
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
            $sql = "DELETE FROM careesma_kategori_job WHERE Id = :Id";
            $exc = $koneksi->prepare($sql);
            $exc->bindParam('Id', $data['Id'], PDO::PARAM_INT);
            $exc->execute();
            if($exc){
                $result['status'] = "sukses";
                $result['pesan'] = "Berhasil menghapus data Kategori Job!";
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
        $sql = "SELECT * FROM careesma_kategori_job WHERE Id = :Id";
        $exc = $koneksi->prepare($sql);
        $exc->bindParam("Id", $Id, PDO::PARAM_INT);
        $exc->execute();
        $dt = $exc->fetch(PDO::FETCH_ASSOC);
        return $dt;
    }


    

    

?>