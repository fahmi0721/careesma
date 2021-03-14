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
            $sql = "SELECT Id,Judul, Gambar FROM careesma_gambar $FilterSearch";
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
                    $Isi = "http://".$_SERVER['HTTP_HOST']."/kantor/rekrut/img/Gambar/".$res['Gambar'];
                    $gbr = "img/Gambar/".$res['Gambar'];
                    $Gambar = "<a class='btn btn-xs btn-success' data-toggle='tooltip' title='Lihat Gambar' onclick=\"Crud('".$gbr."','DetailGambar')\"><i class='fa fa-picture-o'></i></a> ";
                    $aksi = "<a class='btn btn-xs btn-primary' data-toggle='tooltip' title='Edit Data' onclick=\"Crud('".$res['Id']."','ubah')\"><i class='fa fa-edit'></i></a> <a class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick=\"Crud('".$res['Id']."','hapus')\"><i class='fa fa-trash-o'></i></a>";
                    $res['No'] = $no;
                    $res['Judul'] = $res['Judul'];
                    $res['Alamat'] = $Isi;
                    $res['Aksi'] = $Gambar.$aksi;
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

    function getExtensi($gambar){
        $r = explode(".",$gambar);
        $exte = end($r);
        return $exte;
    }    

    function TambahData($data){
        try {
            $data['TglCreate'] = date("Y-m-d H:i:s");
            $randName = rand(0,999);
            $extensi = getExtensi($data['Gambar']['name']);
            $name = $randName.".".$extensi;
            move_uploaded_file($data['Gambar']['tmp_name'],"../../img/Gambar/".$name);
            $sql = "INSERT INTO careesma_gambar SET  Judul = :Judul, Gambar = :Gambar";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Judul", $data['Judul']);
            $query->bindParam("Gambar", $name);
            $query->execute();
            $msg['status'] = "sukses";
            $msg['pesan'] = "Berhasil menambah data Gambar!";
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
            if(empty($data['Gambar']['name'])){
                $sql = "UPDATE careesma_gambar SET Judul = :Judul WHERE Id = :Id";
                $query = $GLOBALS['db']->prepare($sql);
                $query->bindParam("Judul", $data['Judul']);
                $query->bindParam("Id", $data['Id']);
                $query->execute();
                $msg['status'] = "sukses";
                $msg['pesan'] = "Berhasil mengubah data Gambar!";
            }else{
                $File = ShowData($data['Id']);
                HapusFile("../../img/Gambar/",$File['Gambar']);
                $randName = rand(0,999);
                $extensi = getExtensi($data['Gambar']['name']);
                $name = $randName.".".$extensi;
                move_uploaded_file($data['Gambar']['tmp_name'],"../../img/Gambar/".$name);
                $sql = "UPDATE careesma_gambar SET  Judul = :Judul, Gambar = :Gambar WHERE Id = :Id";
                $query = $GLOBALS['db']->prepare($sql);
                $query->bindParam("Judul", $data['Judul']);
                $query->bindParam("Gambar", $name);
                $query->bindParam("Id", $data['Id']);
                $query->execute();
                $msg['status'] = "sukses";
                $msg['pesan'] = "Berhasil mengubah data Gambar!";
            }
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
            $File = ShowData($data['Id']);
            HapusFile("../../img/Gambar/",$File['Gambar']);
            $sql = "DELETE FROM careesma_gambar WHERE Id = :Id";
            $exc = $koneksi->prepare($sql);
            $exc->bindParam('Id', $data['Id'], PDO::PARAM_INT);
            $exc->execute();
            if($exc){
                $result['status'] = "sukses";
                $result['pesan'] = "Berhasil menghapus Gambar!";
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
    
    function HapusFile($Dir,$File){
        $files = $Dir.$File;
        if(file_exists($files) && $files != ""){
            unlink($files);
        }
        return true;

    }

    function ShowData($Id){
        $koneksi = $GLOBALS['db'];
        $sql = "SELECT * FROM careesma_gambar WHERE Id = :Id";
        $exc = $koneksi->prepare($sql);
        $exc->bindParam("Id", $Id, PDO::PARAM_INT);
        $exc->execute();
        $dt = $exc->fetch(PDO::FETCH_ASSOC);
        return $dt;
    }



    

?>