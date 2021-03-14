<?php

    function DataLowongan(){
        $sql = "SELECT Id, Judul FROM careesma_job_vacansy ORDER BY Id ASC";
        $query = $GLOBALS['db']->query($sql);
        $r= array();
        while($res = $query->fetch(PDO::FETCH_ASSOC)){
            $r['data'][] = $res;
        }
        return $r;
    }

    

    function Filter($str){
        if(!empty($str)){
            $result = "AND (a.Nama LIKE '%".$str."%')";
        }else{
            $result = "";
        }

        return $result;
    }

    function CekTabelLulus($IdUser,$IdLowongan){
        $sql = "SELECT COUNT(Id) as tot,Keterangan FROM careesma_lulus WHERE IdUser = '$IdUser' AND IdJobVacancy = '$IdLowongan'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r;
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
            $sql = "SELECT a.*, YEAR(CURDATE()) - YEAR(a.TglLahir) as Usia  FROM careesma_data_diri a INNER JOIN careesma_daftar b ON a.Id = b.IdUser WHERE b.IdJobVacancy = '$data[IdLowongan]'";
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
                    $cek = CekTabelLulus($res['Id'],$data['IdLowongan']);
                    if($cek['tot'] > 0){
                        $tb = $cek['Keterangan'] == "LULUS" ? "<label data-toggle='tooltip' title='Lulus' class='label label-success'><i class='fa fa-check'></i></label>" : "<label class='label label-danger' data-toggle='tooltip' title='Tidak Lulus'><i class='fa fa-times'></i></label>"; 
                        $aksi = $tb." <a class='btn btn-xs btn-primary' target='_blank' href='index.php?page=ProfilDataSeleksi&Idx=".base64_encode($res['NoKtp'])."&IdL=".base64_encode($data['IdLowongan'])."' data-toggle='tooltip' title='Detail Data'><i class='fa fa-eye'></i></a>";
                    }else{
                        $aksi = "<a class='btn btn-xs btn-primary' target='_blank' href='index.php?page=ProfilDataSeleksi&Idx=".base64_encode($res['NoKtp'])."&IdL=".base64_encode($data['IdLowongan'])."' data-toggle='tooltip' title='Verifikasi Data'><i class='fa fa-search'></i> Verifikasi</a>";
                    }
                    $res['No'] = $no;
                    $res['TglLahir'] = tgl_indo($res['TglLahir']);
                    $res['TptLahir'] = strtoupper($res['TptLahir']);
                    $res['JK'] = $res['JK'] == "L" ? "Laki-Laki" : "Perempuan";
                    $res['Aksi'] = $aksi;
                    $result['data'][] = $res;
                    $no++;
                }
                $result['data_last'] = $no -1;
            }else{
                $result['data']='';
            }
            return $result; 
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