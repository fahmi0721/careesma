<?php 
    function CekNoKtp($NoKtp){
        try {
            $koneksi = $GLOBALS['db'];
            $sql = "SELECT COUNT(Id) as tot FROM careesma_data_diri WHERE NoKtp = :NoKtp";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("NoKtp", $NoKtp, PDO::PARAM_STR);
            $query->execute();
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $res['status'] = "sukses";
            $res['pesan'] = $r['tot'];
            return $res;
        } catch (PDOException $e) {
            $res['status'] = "gagal";
            $res['pesan'] = $e->getMessage();
            return $res;
        }
    }

    function CekEmail($Email){
        try {
            $koneksi = $GLOBALS['db'];
            $sql = "SELECT COUNT(Id) as tot FROM careesma_login WHERE Username = :Email";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Email", $Email, PDO::PARAM_STR);
            $query->execute();
            $r = $query->fetch(PDO::FETCH_ASSOC);
            $res['status'] = "sukses";
            $res['pesan'] = $r['tot'];
            return $res;
        } catch (PDOException $e) {
            $res['status'] = "gagal";
            $res['pesan'] = $e->getMessage();
            return $res;
        }
    }

    function Validasi($data){
        $CekNoKtp = CekNoKtp($data['NoKtp']);
        if($CekNoKtp['status'] == "sukses"){
            if($CekNoKtp['pesan'] > 0){
                $res['status'] = "gagal";
                $res['pesan'] = "ada";
                return $res;
            }
        }else{
            $res['status'] = "gagal";
            $res['pesan'] = $CekNoKtp['Pesan']; 
            return $res;
        }

        $CekEmail = CekEmail($data['Email']);
        if($CekEmail['status'] == "sukses"){
            if(intval($CekEmail['pesan']) > 0){
                $res['status'] = "gagal";
                $res['pesan'] = "ada";
                return $res;
                exit;
            }
        }else{
            $res['status'] = "gagal";
            $res['pesan'] = $CekEmail['Pesan']."ss"; 
            return $res;
        }
        $res['status'] = "sukses";
        $res['pesan'] = "OK"; 
        return $CekEmail;

        
    }   

    function TambahDataLogin($data){
        try {
            $koneksi = $GLOBALS['db'];
            $sql = "INSERT INTO careesma_data_diri SET Nama = :Nama, NoKtp = :NoKtp, `Email` = :Email,  TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Nama", $data['Nama'],PDO::PARAM_STR);
            $query->bindParam("NoKtp", $data['NoKtp'],PDO::PARAM_STR);
            $query->bindParam("Email", $data['Email'],PDO::PARAM_STR);
            $query->bindParam("TglCreate", $data['TglCreate'],PDO::PARAM_STR);
            $query->execute();
            $res['status'] = "sukses";
            $res['pesan'] = "berhasil register ke data diri";
            return $res;
        } catch (PDOException $e) {
            $res['status'] = "gagal";
            $res['pesan'] = $e->getMessage();
            return $res;
        }
    }

    function TambahDataDiri($data){
        try {
            $koneksi = $GLOBALS['db'];
            $Level = 1;
            $Password = md5("careesma".$data['Password']);
            $sql = "INSERT INTO careesma_login SET Nama = :Nama, Username = :Username, `Password` = :Passwords, `Level` = :Levels, TglCreate = :TglCreate";
            $query = $GLOBALS['db']->prepare($sql);
            $query->bindParam("Nama", $data['Nama'],PDO::PARAM_STR);
            $query->bindParam("Username", $data['Email'],PDO::PARAM_STR);
            $query->bindParam("Passwords", $Password,PDO::PARAM_STR);
            $query->bindParam("Levels", $Level,PDO::PARAM_STR);
            $query->bindParam("TglCreate", $data['TglCreate'],PDO::PARAM_STR);
            $query->execute();
            $res['status'] = "sukses";
            $res['pesan'] = "berhasil register ke login";
            return $res;
        } catch (PDOException $e) {
            $res['status'] = "gagal";
            $res['pesan'] = "gagal register ke login";
            return $res;
        }
    }
    function RegisterMember($data){
       $Validasi = Validasi($data);
       if($Validasi['status'] == "sukses"){
            $Login = TambahDataLogin($data);
            $DataDiri = TambahDataDiri($data);
            $res['status'] = "sukses";
            $res['pesan'] = "Registrasi berhasil. silahkan login menggunakan email :".$data['Email'];
            $res['data'][] = $Login;
            $res['data'][] = $DataDiri;
            return $res;
       }else{
           return $Validasi;
       }
    }

    function LoadImage(){
        $email = $_SESSION['Careesma_Username'];
        $r = $GLOBALS['db']->query("SELECT Foto FROM careesma_data_diri WHERE Email = '$email'")->fetch(PDO::FETCH_ASSOC);
        $img = "img/Foto/".$r['Foto'];
        if(file_exists($img) && $r['Foto'] != ""){
            return $img;
        }else{
            return "img/avatar04.png";
        }
    }

    function CekBiodata($Email){
        $koneksi = $GLOBALS['db'];
        $sql = "SELECT * FROM careesma_data_diri WHERE Email = :Email";
        $query = $GLOBALS['db']->prepare($sql);
        $query->bindParam("Email",$Email);
        $query->execute();
        $r = $query->fetch(PDO::FETCH_ASSOC);
        $JumTerisi =0;
        if(!empty($r['Nama'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['NoKtp'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['TptLahir'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['TglLahir'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['JK'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['Pendidikan'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['NoHp'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['Email'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['Agama'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['Alamat'])) { $JumTerisi = $JumTerisi+1; }
        if(!empty($r['Foto'])) { $JumTerisi = $JumTerisi+1; }
        
        $Kelengkapan = ($JumTerisi / 11) * 100;
        return round($Kelengkapan,0);

    }

    function LoadLowonganNew(){
        $TglNow = date("Y-m-d");
        $sql = "SELECT a.*, b.Nama FROM careesma_job_vacansy a  INNER JOIN careesma_kategori_job b ON a.IdKategori = b.Id WHERE a.TglBerlaku > '$TglNow' ORDER BY a.Id DESC ";
        $query = $GLOBALS['db']->query($sql);
        $res=array();
        $Row = $query->rowCount();
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
            $res['data'][] = $r;
        }
        $res['Jum'] = $Row;
        return $res;
    }
    function LoadDataDiriP(){
        $Email = $_SESSION['Careesma_Username'];
        $koneksi = $GLOBALS['db'];
        $query = $koneksi->prepare("SELECT * FROM careesma_data_diri WHERE Email = :Email");
        $query->bindParam("Email", $Email,PDO::PARAM_STR);
        $query->execute();
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    function JumSertifikat(){
        $IdUser = LoadDataDiriP();
        $IdUser = !empty($IdUser['Id']) ? $IdUser['Id'] : "";
        $sql = "SELECT COUNT(Id) as tot FROM careesma_sertifikasi WHERE IdUser = '$IdUser'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return empty($r['tot']) ? 0 : $r['tot'];
    }

    function JumPk(){
        $IdUser = LoadDataDiriP();
        $IdUser = !empty($IdUser['Id']) ? $IdUser['Id'] : "";
        $sql = "SELECT COUNT(Id) as tot FROM careesma_pengalaman_kerja WHERE IdUser = '$IdUser'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return empty($r['tot']) ? 0 : $r['tot'];
    }

    function JumLmr(){
        $IdUser = LoadDataDiriP();
        $IdUser = !empty($IdUser['Id']) ? $IdUser['Id'] : "";
        $sql = "SELECT COUNT(Id) as tot FROM careesma_daftar WHERE IdUser = '$IdUser'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return empty($r['tot']) ? 0 : $r['tot'];
    }

    function LoadDataDas(){
        $res = array();
        $res['JumSertifikat'] = JumSertifikat();
        $res['JumPk'] = JumPk();
        $res['JumLmr'] = JumLmr();
        return $res;
    }

    function TotalLamar($Id){
        $sql = "SELECT COUNT(Id) as tot FROM careesma_daftar  WHERE IdJobVacancy = '$Id' GROUP BY IdJobVacancy";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

    function LoadDataJobVa(){
        $sql = "SELECT Id, Judul FROM careesma_job_vacansy ORDER BY Id DESC";
        $query = $GLOBALS['db']->query($sql);
        $r = array();
        while($rs = $query->fetch(PDO::FETCH_ASSOC)){
            $rs['Judul'] = $rs['Judul'];
            $rs['Id'] = $rs['Id'];
            $rs['Tot'] = TotalLamar($rs['Id']);
            $r[] = $rs;
        }
        return $r;
    }

    function getIdData(){
        $email = $_SESSION['Careesma_Username'];
        $sql = "SELECT * FROM careesma_data_diri WHERE Email = '$email'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r;
    }

    function CekDaftar($IdJ){
        $dt = getIdData();
        $sql = "SELECT COUNT(Id) as tot FROM careesma_daftar WHERE IdUser = '$dt[Id]' AND IdJobVacancy = '$IdJ' GROUP BY IdUser";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

    function LowonganTerdaftar($IdJ){
        $IdUser = getIdData();
        $sql = "SELECT COUNT(Id) as tot FROM careesma_daftar WHERE IdJobVacancy = '$IdJ' AND IdUser = '$IdUser[Id]'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

    function getColor(){
        $warna = ""; // membuat variabel untuk warna
        $nilai = "1234567890abcdef"; // membuat variabel yang memiliki nilai dari 1234567890abcdef
        for($i = 0;$i <6;$i++){ // melakukan perulangan
            $warna .= $nilai[rand(0,strlen($nilai) - 1)]; // mendapatkan nilai string sebanyak dengan panjang 6 secara random atau acak
        }
        return "#".$warna;
    }

    function Jp(){
        $sql = "SELECT COUNT(Pendidikan) as tot,Pendidikan FROM careesma_data_diri WHERE Pendidikan != '' GROUP BY Pendidikan";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        $pieData = array();
        if($row > 0){
            $dt = array();
            $poc = 0;
            while($r = $query->fetch(PDO::FETCH_ASSOC)){
                $color = getColor();
                $dt['value'] = intval($r['tot']);
                $dt['color'] = $color;
                $dt['highlight'] = $color;
                $dt['label'] = strtoupper($r['Pendidikan']);
                $pieData[] = $dt;
                $poc++;
            }
        }else{
            $pieData[0]['value'] = -1;
            $pieData[0]['color'] = "#f56954";
            $pieData[0]['highlight'] = "#f56954";
            $pieData[0]['label'] = "Data Belum ada";
        }
        
        return $pieData;
    }

    function Jk(){
        $sql = "SELECT COUNT(JK) as tot, JK FROM careesma_data_diri WHERE JK != '' GROUP BY JK";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        $pieData = array();
        if($row > 0){
            
            $dt = array();
            $poc = 0;
            while($r = $query->fetch(PDO::FETCH_ASSOC)){
                $color = $color = getColor();
                $JK = $r['JK'] == "L" ? "Laki-Laki" : "Perempuan";
                $dt['value'] = intval($r['tot']);
                $dt['color'] = $color;
                $dt['highlight'] = $color;
                $dt['label'] = strtoupper($JK);
                $pieData[] = $dt;
                $poc++;
            }
        }else{
            $pieData[0]['value'] = -1;
            $pieData[0]['color'] = "#f56954";
            $pieData[0]['highlight'] = "#f56954";
            $pieData[0]['label'] = "Data Belum ada";
        }
        
        return $pieData;
    }

    function Sertifikasi(){
        $sql = "SELECT COUNT(NamaSertifikasi) as tot, NamaSertifikasi FROM careesma_sertifikasi  GROUP BY NamaSertifikasi";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        $pieData = array();
        if($row > 0){
            
            $dt = array();
            $poc = 0;
            while($r = $query->fetch(PDO::FETCH_ASSOC)){
                $color = $color = getColor();
                $dt['value'] = intval($r['tot']);
                $dt['color'] = $color;
                $dt['highlight'] = $color;
                $dt['label'] = strtoupper($r['NamaSertifikasi']);
                $pieData[] = $dt;
                $poc++;
            }
        }else{
            $pieData[0]['value'] = -1;
            $pieData[0]['color'] = "#f56954";
            $pieData[0]['highlight'] = "#f56954";
            $pieData[0]['label'] = "Data Belum ada";
        }
        
        return $pieData;
    }

    function LoadDataCart(){
        $r = array();
        $r['Jp'] = Jp();
        $r['Sert'] = Sertifikasi();
        $r['Jk'] =Jk(); 
        return $r;
        
    }

    function JumlahSoal(){
        $sql = "SELECT COUNT(Id) as tot FROM careesma_soal";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

    function JumlahPelamar(){
        $sql = "SELECT COUNT(Id) as tot FROM careesma_data_diri";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

    function JumlahLowongan(){
        $sql = "SELECT COUNT(Id) as tot FROM careesma_job_vacansy";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

    function cekLowongan(){
        $now = date("Y-m-d");
        $sql = "SELECT COUNT(Id) as tot FROM careesma_job_vacansy";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['tot'];
    }

    function LiveUjian(){
        $now = date("Y-m-d");
        $sql = "SELECT  a.WaktuMulai, a.UserId, a.IdJobVacancy FROM careesma_tkdb a INNER JOIN careesma_job_vacansy b ON a.IdJobVacancy = b.Id WHERE  (WaktuSelesai is null  )";
        $query = $GLOBALS['db']->query($sql);
        $r = array();
        $row = $query->rowCount();
        if($row > 0){
            while($res = $query->fetch(PDO::FETCH_ASSOC)){
                $r['data'][] = $res;
            }
            $r['row'] = $row;
        }else{
            $r['data'] = array();
            $r['row'] = $row;
        }
        return $r;
    }

    function LiveNilai(){
        $now = date("Y-m-d");
        $sql = "SELECT a.WaktuMulai, a.UserId, a.IdJobVacancy FROM careesma_tkdb a INNER JOIN careesma_job_vacansy b ON a.IdJobVacancy = b.Id  WHERE b.TglBerlaku = '2021-02-28' AND a.WaktuSelesai IS NOT NULL";
        $query = $GLOBALS['db']->query($sql);
        $r = array();
        $row = $query->rowCount();
        if($row > 0){
            while($res = $query->fetch(PDO::FETCH_ASSOC)){
                $r['data'][] = $res;
            }
            $r['row'] = $row;
        }else{
            $r['data'] = array();
            $r['row'] = $row;
        }
        return $r;
    }

    function getPelamarUser($Id){
        $sql = "SELECT Nama FROM careesma_data_diri WHERE Id = '$Id'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['Nama'];
    }

    function getLokerUser($Id){
        $sql = "SELECT Judul FROM careesma_job_vacansy WHERE Id = '$Id'";
        $query = $GLOBALS['db']->query($sql);
        $r = $query->fetch(PDO::FETCH_ASSOC);
        return $r['Judul'];
    }

    function LoadDataUjianLIve($awal){
        $result = array();
        $LiveUjian = LiveUjian(); 
        if($LiveUjian['row'] > 0){
            $r =array();
            for($i=$awal; $i < count($LiveUjian['data']); $i++){
                $iData = $LiveUjian['data'][$i];
                $Sisa = SisahWaktu($iData['WaktuMulai'],60);
                $Sisah = $Sisa['Waktu'] <= 0 ? "<i class='fa fa-clock-o'></i> ".$Sisa['jam'].":".$Sisa['menit'].":".$Sisa['detik'] : "<i class='fa fa-clock-o'></i> 00-00-00";
                if($Sisa['Waktu'] > 0){
                    $Sisah = "<center><label class='label label-danger'>".$Sisah."</label></center>";
                }else{
                    if($Sisa['menit'] > 30){
                        $Sisah = "<center><label class='label label-success'>".$Sisah."</label></center>";
                    }elseif($Sisa['menit'] <= 30 && $Sisa['menit'] >= 15){
                        $Sisah = "<center><label class='label label-warning'>".$Sisah."</label></center>";
                    }else{
                        $Sisah = "<center><label class='label label-danger'>".$Sisah."</label></center>";
                    }
                }
                $r['Nama'] = getPelamarUser($iData['UserId']);
                $r['Loker'] = getLokerUser($iData['IdJobVacancy']);
                $r['SisaWaktu'] = $Sisah;
                $result[] = $r;
            }
            return $result;
        }else{
            
            return array();
        }
    }

    function getNilaiPelamar($IdUser, $IdJ){
        $sql = "SELECT Nilai FROM careesma_nilai WHERE UserId = '$IdUser' AND IdJobVacancy = '$IdJ'";
        $r = $GLOBALS['db']->query($sql)->fetch(PDO::FETCH_ASSOC);
        return $r['Nilai'];
    }

    function LoadDataNilaiLIve($awal){
        $result = array();
        $LiveUjian = LiveNilai(); 
        if($LiveUjian['row'] > 0){
            $r =array();
            for($i=$awal; $i < count($LiveUjian['data']); $i++){
                $iData = $LiveUjian['data'][$i];
                $Nilai = getNilaiPelamar($iData['UserId'],$iData['IdJobVacancy']);
                if($Nilai > 90){
                    $ss = "<label class='label label-success' data-toggle='tooltip' title='".$Nilai."'>Disarankan</label>";
                }elseif($Nilai >= 45 && $Nilai <= 89){
                    $ss = "<label class='label label-info' data-toggle='tooltip' title='".$Nilai."'>Dipertimbangkan</label>";
                }else{
                    $ss = "<label class='label label-danger' data-toggle='tooltip' title='".$Nilai."'>Tidak Disarankan</label>";
                }
                $r['Nama'] = getPelamarUser($iData['UserId']);
                $r['Loker'] = getLokerUser($iData['IdJobVacancy']);
                $r['Nilai'] = $ss;
                $result[] = $r;
            }
            return $result;
        }else{
            
            return array();
        }
    }

    function LoadRealTiimeTkdb(){
        $result = array();
        $cekLowongan = cekLowongan();
        if($cekLowongan > 0){
            $res = LoadDataUjianLIve(0);
            $result['status'] = "sukses";
            $result['data'] = $res;
            return $result;
        }else{
            $result['status'] = "empty";
            $result['data'] = array();
            return $result;
        }
    }

    function RealTimeNilaiTkdb(){
        $result = array();
        $cekLowongan = cekLowongan();
        if($cekLowongan > 0){
            $res = LoadDataNilaiLIve(0);
            $result['status'] = "sukses";
            $result['data'] = $res;
            return $result;
        }else{
            $result['status'] = "empty";
            $result['data'] = array();
            return $result;
        }
    }


    function SisahWaktu($WaktuMulai,$JumWaktu){
        $DateLast = date("Y-m-d H:i:s", strtotime('+'.$JumWaktu.' minutes', strtotime($WaktuMulai)));
        $DateNow = date("Y-m-d H:i:s");
        $Selisih = SelisihWaktu($DateNow,$DateLast);
        return $Selisih;
    }
    // 13
    function SelisihWaktu($date1,$date2){
        $res = array();
        $diff = abs(strtotime($date1) - strtotime($date2)); 
        $cek = strtotime($date1) - strtotime($date2); 
        $res['Waktu']   = $cek; 
        $res['tahun']   = floor($diff / (365*60*60*24)); 
        $res['bulan']  = floor(($diff - $res['tahun'] * 365*60*60*24) / (30*60*60*24)); 
        $res['hari']    = floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24)/ (60*60*24));
        $res['jams']   = floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24)/ (60*60)); 
        $res['jam']   = sprintf("%02d",floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24)/ (60*60))); 
        $res['menit']  = sprintf("%02d",floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24 - $res['jam']*60*60)/ 60)); 
        $res['detik'] = sprintf("%02d",floor(($diff - $res['tahun'] * 365*60*60*24 - $res['bulan']*30*60*60*24 - $res['hari']*60*60*24 - $res['jam']*60*60 - $res['menit']*60))); 
        return $res;
    }
    


?>