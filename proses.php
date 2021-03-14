<?php
include "config/config.php";
include "inc/fungsi.php";
$proses=isset($_GET['proses'])?$_GET['proses']:null;

switch ($proses) {
    case "register":
        
        $res = RegisterMember($_POST);
        if($res['status'] == "sukses"){
            header("location:login.php?status=".$res['status']."&success=".$res['pesan']);
        }else{
           header("location:login.php?status=".$res['status']."&error=No KTP atau Email anda telah terdaftar");
        }
        break;
     
        
    
}


?>