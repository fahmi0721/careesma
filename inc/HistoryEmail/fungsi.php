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
            $sql = "SELECT a.*, YEAR(CURDATE()) - YEAR(a.TglLahir) as Usia,b.Pesan,b.TglCreate  FROM careesma_data_diri a INNER JOIN careesma_pesan_email b ON a.Id = b.IdUser WHERE b.IdLowongan = '$data[IdLowongan]' $FilterSearch";
            $query = $db->query($sql);
            $JumRow = $query->rowCount();
            $total_page = ceil($JumRow / $RowPage);
            $result['total_page'] = $total_page;
            $result['total_data'] = $JumRow;
            $sql = $sql." ORDER BY b.Id DESC LIMIT ".$offset.",".$RowPage;
            $query = $db->query($sql);

            if($JumRow > 0){
                $result['data_new'] = $no;
                while ($res = $query->fetch(PDO::FETCH_ASSOC)) { 
                   
                    $res['No'] = $no;
                    $res['Tgl'] = tgl_indo($res['TglCreate']);
                    $res['JK'] = $res['JK'] == "L" ? "Laki-Laki" : "Perempuan";
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

   

?>