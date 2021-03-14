<?php

    function DataKategori(){
        $sql = "SELECT Id, Nama FROM careesma_kategori_job ORDER BY Nama ASC";
        $query = $GLOBALS['db']->query($sql);
        $r= array();
        while($res = $query->fetch(PDO::FETCH_ASSOC)){
            $r['data'][] = $res;
        }
        return $r;
    }

    

    function Filter($str){
        if(!empty($str)){
            $result = "WHERE (a.Judul LIKE '%".$str."%')";
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
            $sql = "SELECT a.*, b.Nama FROM careesma_job_vacansy a INNER JOIN careesma_kategori_job b ON a.IdKategori = b.Id";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $total_page = ceil($JumRow / $RowPage);
            $result['total_page'] = $total_page;
            $result['total_data'] = $JumRow;
            $sql = $sql." ORDER BY a.Id DESC LIMIT ".$offset.",".$RowPage;
            $query = $db->query($sql);

            if($JumRow > 0){
                $result['data_new'] = $no;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                    if(!empty($res['Flayer']) || file_exists("img/Flayer/".$res['Flayer'])){ $Flayer = "<img src='img/Flayer/".$res['Flayer']."' class='img-responsive' />"; }else{ $Flayer = "-"; }
                    $aksi = "<a class='btn btn-xs btn-primary' data-toggle='tooltip' title='Edit Data' onclick=\"Crud('".$res['Id']."','ubah')\"><i class='fa fa-edit'></i></a> <a class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick=\"Crud('".$res['Id']."','hapus')\"><i class='fa fa-trash-o'></i></a>";
                    $res['No'] = $no;
                    $res['Judul'] = $res['Judul']."<br><small>Kategori Job : ".$res['Nama']."</small>";
                    $res['Kuota'] = $res['Kuota']." Orang";
                    $res['TglBerlaku'] = tgl_indo($res['TglBerlaku']);
                    $res['Flayer'] = $Flayer;
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

    function getExtensi($str){
        $str = strtolower($str);
        $str = explode(".", $str);
        $str = end($str);
        return $str;
    }

    function ValidasiFile($File,$Dir){
        
        $ArrExtensi = array("jpg","png","jpeg");
        $nama = $File['name'];
        $size = $File['size'];
        $size = round($size/1024,0);
        $tmp_name = $File['tmp_name'];
        $extensi = getExtensi($nama);
        if(in_array($extensi, $ArrExtensi)){
            if($size <= 2048){
                $NewName = rand(0,9999).time().".".$extensi;
                if(move_uploaded_file($tmp_name,$Dir.$NewName)){
                    $r['msg'] = "sukses";
                    $r['pesan'] = $NewName;
                    return $r;
                }else{
                    $r['msg'] = "gagal";
                    $r['pesan'] = "Terjadi kesalahan ketika mengupload file";
                    return $r;
                }
            }else{
                $r['msg'] = "gagal";
                $r['pesan'] = "Size file yang dimasukkan terlalu besar. Masukkan file dengan ukuran 2 mb";
                return $r;
            }
        }else{
            $r['msg'] = "gagal";
            $r['pesan'] = "Tipe file yang dimasukkan salah masukan file gambar";
            return $r;
        }

    }

     function TambahData($data){
        $koneksi = $GLOBALS['db'];
        if(is_array($data)){
            try {
                $data['TglCreate'] = date("Y-m-d H:i:s");
                $data['UserId'] = $_SESSION['Id'];
                $Validasi = ValidasiFile($data['File'],$data['Dir']);
                if( $Validasi['msg'] == "sukses"){
                    $File = $Validasi['pesan'];
                    $sql = "INSERT INTO careesma_job_vacansy SET IdKategori = :IdKategori, Judul = :Judul,DeskripsiPekerjaan = :DeskripsiPekerjaan, `Flayer` = :Flayer, Kuota = :Kuota, TglBerlaku = :TglBerlaku,  TglCreate = :TglCreate,  Persyaratan = :Persyaratan";
                    $exc = $koneksi->prepare($sql);
                    $exc->bindParam('IdKategori', $data['IdKategori'], PDO::PARAM_STR);
                    $exc->bindParam('Judul', $data['Judul'], PDO::PARAM_STR);
                    $exc->bindParam('DeskripsiPekerjaan', $data['DeskripsiPekerjaan'], PDO::PARAM_STR);
                    $exc->bindParam('Flayer', $File, PDO::PARAM_STR);
                    $exc->bindParam('Kuota', $data['Kuota'], PDO::PARAM_STR);
                    $exc->bindParam('TglBerlaku', $data['TglBerlaku'], PDO::PARAM_STR);
                    $exc->bindParam('TglCreate', $data['TglCreate'], PDO::PARAM_STR);
                    $exc->bindParam('Persyaratan', $data['Persyaratan'], PDO::PARAM_STR);
                    $exc->execute();
                    $msg['pesan'] = "Berhasil menambah data ";
                    $msg['status'] = "sukses";
                    return $msg;
                }else{
                    return $Validasi;
                }
            } catch (PDOException $e) {
                $msg['pesan'] = $e->getMessage();
                $msg['status'] = "error";
                return $msg;
            }
            
        }else{
            $msg['pesan'] = "Pengiriman data ke server gagal";
            $msg['status'] = "gagal";
            InsertLogs($msg['pesan']);
            return $msg;
        }
    }

     function UbahData($data){
         $koneksi = $GLOBALS['db'];
          try {
            if(empty($data['File']['name'])){
                $sql = "UPDATE careesma_job_vacansy SET IdKategori = :IdKategori, Judul = :Judul,DeskripsiPekerjaan = :DeskripsiPekerjaan, Kuota = :Kuota, TglBerlaku = :TglBerlaku,    Persyaratan = :Persyaratan WHERE Id = :Id";
                $exc = $koneksi->prepare($sql);
                $exc->bindParam('IdKategori', $data['IdKategori'], PDO::PARAM_STR);
                $exc->bindParam('Judul', $data['Judul'], PDO::PARAM_STR);
                $exc->bindParam('DeskripsiPekerjaan', $data['DeskripsiPekerjaan'], PDO::PARAM_STR);
                $exc->bindParam('Kuota', $data['Kuota'], PDO::PARAM_STR);
                $exc->bindParam('TglBerlaku', $data['TglBerlaku'], PDO::PARAM_STR);
                $exc->bindParam('Persyaratan', $data['Persyaratan'], PDO::PARAM_STR);
                $exc->bindParam('Id', $data['Id'], PDO::PARAM_STR);
                $exc->execute();
                $msg['pesan'] = "Berhasil mengubah data ";
                $msg['status'] = "sukses";
                return $msg;
            }else{
                $ImgTemp = ShowData($data['Id']);
                $Validasi = ValidasiFile($data['File'],$data['Dir']);
                if( $Validasi['msg'] == "sukses"){
                    $File = $Validasi['pesan'];
                    $sql = "UPDATE careesma_job_vacansy SET IdKategori = :IdKategori, Judul = :Judul,DeskripsiPekerjaan = :DeskripsiPekerjaan, `Flayer` = :Flayer, Kuota = :Kuota, TglBerlaku = :TglBerlaku,   Persyaratan = :Persyaratan WHERE Id = :Id";
                    $exc = $koneksi->prepare($sql);
                    $exc->bindParam('IdKategori', $data['IdKategori'], PDO::PARAM_STR);
                    $exc->bindParam('Judul', $data['Judul'], PDO::PARAM_STR);
                    $exc->bindParam('DeskripsiPekerjaan', $data['DeskripsiPekerjaan'], PDO::PARAM_STR);
                    $exc->bindParam('Flayer', $File, PDO::PARAM_STR);
                    $exc->bindParam('Kuota', $data['Kuota'], PDO::PARAM_STR);
                    $exc->bindParam('TglBerlaku', $data['TglBerlaku'], PDO::PARAM_STR);
                    $exc->bindParam('Persyaratan', $data['Persyaratan'], PDO::PARAM_STR);
                    $exc->bindParam('Id', $data['Id'], PDO::PARAM_STR);
                    $exc->execute();
                    HapusFile($ImgTemp['Flayer'],$data['Dir']);
                    $msg['pesan'] = "Berhasil mengubah data ";
                    $msg['status'] = "sukses";
                    return $msg;
                }else{
                    return $Validasi;
                }
            }
        } catch (PDOException $e) {
            $msg['status'] = "gagal";
            $msg['pesan'] = $e->getMessage();
            return $msg;
        }
     }

    function HapusFile($File,$Dir){
        if(file_exists($Dir.$File) && $File != ""){
            unlink($Dir.$File);
            return true;
        }else{
            return true;
        }
    }
   
    
    function HapusData($data){
        $koneksi = $GLOBALS['db'];
        if(is_array($data)){
            $ImgTemp = ShowData($data['Id']);
            $sql = "DELETE FROM careesma_job_vacansy WHERE Id = :Id";
            $exc = $koneksi->prepare($sql);
            $exc->bindParam('Id', $data['Id'], PDO::PARAM_INT);
            $exc->execute();
            if($exc){
                HapusFile($ImgTemp['Flayer'],$data['Dir']);
                $result['status'] = "sukses";
                $result['pesan'] = "Berhasil menghapus data Lowongan Pekerjaan!";
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
        $sql = "SELECT * FROM careesma_job_vacansy WHERE Id = :Id";
        $exc = $koneksi->prepare($sql);
        $exc->bindParam("Id", $Id, PDO::PARAM_INT);
        $exc->execute();
        $dt = $exc->fetch(PDO::FETCH_ASSOC);
        return $dt;
    }


    

?>