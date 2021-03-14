<?php
    function Filter($data){
        $result = array();
        unset($data['Page']);
        if(!is_array($data)){
            return "";
        }else{
            foreach($data as $key => $val){
                if($val != ""){
                    $result[] = $key." = '".$val."'";
                }
            }
            return COUNT($result) > 0 ? "WHERE ".implode(" AND ",$result) : "";
        }
        
    }

    function DetailData($data){
        $db = $GLOBALS['db'];
        $result = array();
        $row = array(); 
        if(is_array($data)){
            $Page = $data['Page'];
            $RowPage = 12;
            $offset=($Page - 1) * $RowPage;
            $no=$offset+1;
            $sql = "SELECT a.Foto, a.NoKtp, a.Nama, a.Pendidikan, a.Id FROM careesma_data_diri a INNER JOIN  careesma_daftar b ON a.Id = b.IdUser WHERE b.IdJobVacancy = '".$data['Id']."'";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $total_page = ceil($JumRow / $RowPage);
            $result['total_page'] = $total_page;
            $result['total_data'] = $JumRow;
            $sql = $sql." ORDER BY Nama ASC";
            $query = $db->query($sql);

            if($JumRow > 0){
                $result['data_new'] = $no;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                    if(empty($res['Foto'])){
                        $res['Foto'] = "img/avatar04.png";
                    }else{
                        $dir = "../../img/Foto/".$res['Foto'];
                        if(file_exists($dir)){
                            $res['Foto'] = "img/Foto/".$res['Foto'];
                        }else{
                            $res['Foto'] = "img/avatar04.png";
                        }
                    }
                    $res['Nama'] = $res['Nama'];
                    $res['NoKtp'] = $res['NoKtp'];
                    $res['NoKtps'] = base64_encode($res['NoKtp']);
                    $res['Pendidikan'] = empty($res['Pendidikan']) ? "Belum lengkap" : $res['Pendidikan'];
                    $res['Tkdb'] = CekNilaiTkDb($data['Id'],$res['Id']);
                    $result['data'][] = $res;
                    $no++;
                }
                $result['data_last'] = $no -1;
            }else{
                $result['data']="";
            }
            return $result; 
        }else{

        }
        
    }

    function CekNilaiTkDb($IdJ,$Id){
        $sql = "SELECT Nilai FROM careesma_nilai WHERE IdJobVacancy = '$IdJ' AND UserId = '$Id'";
        $query = $GLOBALS['db']->query($sql);
        $row = $query->rowCount();
        $r = $query->fetch(PDO::FETCH_ASSOC);
        if($row > 0){
            if($r['Nilai'] >= 90){
                return "<br><label class='label label-success' data-toggle='tooltip' title='".$r['Nilai']."'>Disarankan</label>";
            }elseif($r['Nilai'] >= 45 && $Nilai <= 89){
                return "<br><label class='label label-info' data-toggle='tooltip' title='".$r['Nilai']."'>Dipertimbangkan</label>";
            }else{
                return "<br><label class='label label-danger' data-toggle='tooltip' title='".$r['Nilai']."'>Tidak Disarankan</label>";
            }
        }else{
            return "<br>-";
        }
    }

    function Pendidikan(){
        $sql = "SELECT Pendidikan FROM careesma_data_diri GROUP BY Pendidikan ORDER BY Pendidikan";
        $query = $GLOBALS['db']->query($sql);
        $r = array();
        if($query->rowCount() > 0){
            $tot = 0;
            while($res = $query->fetch(PDO::FETCH_ASSOC)){
                if($res['Pendidikan'] != null){
                    $r['data'][] = $res;
                    $tot++;
                }
            }
            $r['tot'] = $tot;
            
        }else{
            $r['tot'] = 0;
            $r['data'] = array();
        }
        return $r;
    }

    function Ktp(){
        $sql = "SELECT Nama,NoKtp FROM careesma_data_diri ORDER BY Nama ASC";
        $query = $GLOBALS['db']->query($sql);
        $r = array();
        if($query->rowCount() > 0){
            $tot = 0;
            while($res = $query->fetch(PDO::FETCH_ASSOC)){
                $r['data'][] = $res;
                $tot++;
            }
            $r['tot'] = $tot;
            
        }else{
            $r['tot'] = 0;
            $r['data'] = array();
        }
        return $r;
    }

    

    

?>