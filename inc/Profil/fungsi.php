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

    function LoadSertifikasi(){
        $IdUser = $_SESSION['IdUser'];
        $koneksi = $GLOBALS['db'];
        $query = $koneksi->prepare("SELECT * FROM careesma_sertifikasi WHERE IdUser = :IdUser");
        $query->bindParam("IdUser", $IdUser,PDO::PARAM_STR);
        $query->execute();
        $rs = array();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $rs[] = $r;
        }
        return $rs;
    }
    

    function LoadKerja(){
        $IdUser = $_SESSION['IdUser'];
        $koneksi = $GLOBALS['db'];
        $query = $koneksi->prepare("SELECT * FROM careesma_pengalaman_kerja WHERE IdUser = :IdUser");
        $query->bindParam("IdUser", $IdUser,PDO::PARAM_STR);
        $query->execute();
        $rs = array();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $rs[] = $r;
        }
        return $rs;
    }

    

    function ShowData($Id){
        $koneksi = $GLOBALS['db'];
        $query = $koneksi->prepare("SELECT * FROM careesma_data_diri WHERE Id = :Id");
        $query->bindParam("Id", $Id,PDO::PARAM_STR);
        $query->execute();
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    function UpdateDataDiri($data,$files){
        try {
            $koneksi = $GLOBALS['db'];
            $dirIjazah = "../../img/Ijazah/";
            $dirKtp = "../../img/Ktp/";
            $ValidasiIjazah = ValidasiFile($files['FileIjazah'],$dirIjazah);
            $ValidasiKtp = ValidasiFile($files['FileKtp'],$dirKtp);
            if( $ValidasiKtp['msg'] == "sukses" && $ValidasiIjazah['msg'] == "sukses"){
                $FileIjazah = $ValidasiIjazah['pesan'];
                $FileKtp = $ValidasiKtp['pesan'];
                $pend = strtoupper($data['Pendidikan']);
                $sql = "UPDATE careesma_data_diri SET TptLahir = :TptLahir, TglLahir = :TglLahir, JK = :JK, Pendidikan = :Pendidikan, NoHp = :NoHp, Agama = :Agama, Alamat = :Alamat, FileIjazah = :FileIjazah, FileKtp = :FileKtp WHERE Id = :Id";
                $query = $koneksi->prepare($sql);
                $query->bindParam("TptLahir",$data['TptLahir']);
                $query->bindParam("TglLahir",$data['TglLahir']);
                $query->bindParam("JK",$data['JK']);
                $query->bindParam("Pendidikan",$pend);
                $query->bindParam("NoHp",$data['NoHp']);
                $query->bindParam("Agama",$data['Agama']);
                $query->bindParam("Alamat",$data['Alamat']);
                $query->bindParam("FileIjazah",$FileIjazah);
                $query->bindParam("FileKtp",$FileKtp);
                $query->bindParam("Id",$data['Id']);
                $query->execute();
                $res['status'] = "sukses";
                $res['pesan'] = "berhail";
            }else{
                $sql = "UPDATE careesma_data_diri SET TptLahir = :TptLahir, TglLahir = :TglLahir, JK = :JK, Pendidikan = :Pendidikan, NoHp = :NoHp, Agama = :Agama, Alamat = :Alamat WHERE Id = :Id";
                $query = $koneksi->prepare($sql);
                $query->bindParam("TptLahir",$data['TptLahir']);
                $query->bindParam("TglLahir",$data['TglLahir']);
                $query->bindParam("JK",$data['JK']);
                $query->bindParam("Pendidikan",$pend);
                $query->bindParam("NoHp",$data['NoHp']);
                $query->bindParam("Agama",$data['Agama']);
                $query->bindParam("Alamat",$data['Alamat']);
                $query->bindParam("Id",$data['Id']);
                $query->execute();
                $res['status'] = "sukses";
                $res['pesan'] = "berhail";
            }
        } catch (PDOException $e) {
            $res['status'] = "gagal";
            $res['pesan'] = $e->getMessage();
        }
        return $res;
    }

     function getExtensi($str){
        $str = strtolower($str);
        $str = explode(".", $str);
        $str = end($str);
        return $str;
    }

    function ValidasiFile($File,$Dir){
        
        $ArrExtensi = array("jpg","png","jpeg","pdf");
        $nama = $File['name'];
        $size = $File['size'];
        $size = round($size/1024,0);
        $tmp_name = $File['tmp_name'];
        $extensi = getExtensi($nama);
        if(in_array($extensi, $ArrExtensi)){
            if($size <= 2048){
                $NewName = rand(0,9999).time().".".$extensi;
                if(move_uploaded_file($tmp_name,$Dir.$NewName)){
                    //generateThumbnail($Dir.$NewName,80,80);
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

    function UpdateFoto($data){
        try {
            $ft = ShowData($data['Id']);
            $koneksi = $GLOBALS['db'];
            $data['TglUpdate'] = date("Y-m-d H:i:s");
            $Validasi = ValidasiFile($data['File'],$data['Dir']);
            if( $Validasi['msg'] == "sukses"){
                $File = $Validasi['pesan'];
                $sql = "UPDATE careesma_data_diri SET Foto = :Foto WHERE Id = :Id";
                $exc = $koneksi->prepare($sql);
                $exc->bindParam('Foto', $File, PDO::PARAM_STR);
                $exc->bindParam('Id', $data['Id'], PDO::PARAM_STR);
                $exc->execute();
                $msg['pesan'] = "Berhasil menambah data ";
                $msg['status'] = "sukses";
                HapusFile($ft['Foto'],$data['Dir']);
                return $msg;
            }else{
                return $Validasi;
            }
        } catch (PDOException $e) {
            $msg['pesan'] = $e->getMessage();
            $msg['status'] = "error";
            return $msg;
        }
    }

    function TambahSertifiksai($data){
        try {
            $koneksi = $GLOBALS['db'];
            $data['TglCreate'] = date("Y-m-d H:i:s");
            $Validasi = ValidasiFile($data['File'],$data['Dir']);
            if( $Validasi['msg'] == "sukses"){
                $File = $Validasi['pesan'];
                $sql = "INSERT INTO careesma_sertifikasi SET IdUser = :IdUser, NamaSertifikasi = :NamaSertifikasi, TglPerolehan = :TglPerolehan, TglExpire = :TglExpire, `File` = :Files, Keterangan = :Keterangan, TglCreate = :TglCreate";
                $exc = $koneksi->prepare($sql);
                $exc->bindParam('IdUser', $data['Id'], PDO::PARAM_STR);
                $exc->bindParam('NamaSertifikasi', $data['NamaSertifikasi'], PDO::PARAM_STR);
                $exc->bindParam('TglPerolehan', $data['TglPerolehan'], PDO::PARAM_STR);
                $exc->bindParam('TglExpire', $data['TglExpire'], PDO::PARAM_STR);
                $exc->bindParam('Files', $File, PDO::PARAM_STR);
                $exc->bindParam('Keterangan', $data['Keterangan'], PDO::PARAM_STR);
                $exc->bindParam('TglCreate', $data['TglCreate'], PDO::PARAM_STR);
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
    }

    function TambahKerja($data){
        try {
            $koneksi = $GLOBALS['db'];
            $data['TglCreate'] = date("Y-m-d H:i:s");
            $Validasi = ValidasiFile($data['File'],$data['Dir']);
            if( $Validasi['msg'] == "sukses"){
                $File = $Validasi['pesan'];
                $sql = "INSERT INTO careesma_pengalaman_kerja SET IdUser = :IdUser, Instansi = :Instansi, TglMasuk = :TglMasuk, TglKeluar = :TglKeluar, `File` = :Files, Upah = :Upah, TglCreate = :TglCreate";
                $exc = $koneksi->prepare($sql);
                $exc->bindParam('IdUser', $data['Id'], PDO::PARAM_STR);
                $exc->bindParam('Instansi', $data['Instansi'], PDO::PARAM_STR);
                $exc->bindParam('TglMasuk', $data['TglMasuk'], PDO::PARAM_STR);
                $exc->bindParam('TglKeluar', $data['TglKeluar'], PDO::PARAM_STR);
                $exc->bindParam('Files', $File, PDO::PARAM_STR);
                $exc->bindParam('Upah', $data['Upah'], PDO::PARAM_STR);
                $exc->bindParam('TglCreate', $data['TglCreate'], PDO::PARAM_STR);
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
    }

    function HapusFile($File,$Dir){
        if(file_exists($Dir.$File) && $File != ""){
            unlink($Dir.$File);
            return true;
        }else{
            return true;
        }
    }

    

    function SertifikasiJum(){
        $IdUser = LoadDataDiri();
        $sql = "SELECT COUNT(Id) as tot FROM careesma_sertifikasi WHERE IdUser = '$IdUser[Id]' GROUP BY IdUser";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        $res = empty($r['tot']) ? 0 : $r['tot'];
        return $res;
    }

    function PkJum(){
        $IdUser = LoadDataDiri();
        $sql = "SELECT COUNT(Id) as tot FROM  careesma_pengalaman_kerja WHERE IdUser = '$IdUser[Id]' GROUP BY IdUser";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        $res = empty($r['tot']) ? 0 : $r['tot'];
        return $res;
    }

    function CountData(){
        $r = array();
        try {
            $r['SertifikasiJum'] = SertifikasiJum();
            $r['PkJum'] = PkJum();
            $res['data'] = $r;
            $res['status'] = "OK";
            return $res;
        } catch (PDOExeption $th) {
            $r['SertifikasiJum'] = 0;
            $r['PkJum'] = 0;
            $r['status'] = "NO";
            $r['msg'] = $th->getMessage();
            return $r;
        }
        

        

        
    }

?>