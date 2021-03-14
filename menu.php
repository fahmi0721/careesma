<?php 
$pages = isset($_GET['page']) ? $_GET['page'] : null;
//DataPendukung 
$JobVacancy = array("Administrasi"=>"Administrasi","Operator"=>"Operator","Security" => "Security", "Cs" => "Cs");
$keysJobVacancy = array_keys($JobVacancy);
$cekAktifJobVacancy = in_array($pages,$keysJobVacancy) ? "active" : "";

$MasterData = array("JobCategory"=>"Kategori Pekerjaan","JobVacancy"=>"Lowongan Pekerjaan", "Text"=>"Text", "Soal"=>"Soal", "FormulaTkdb"=>"Formula TKDB","Gambar" => "Gambar");
$keysMasterData = array_keys($MasterData);
$cekAktifMasterData = in_array($pages,$keysMasterData) ? "active" : "";



echo "<ul class='sidebar-menu' data-widget='tree'>";
    echo "<li class='header'>MAIN NAVIGATION</li>";
    $cekAktif = $pages == null ? "class='active'" : "";
    echo "<li $cekAktif><a href='index.php'><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>";
    if($_SESSION['Careesma_Level'] == "1"){
        $cekAktif = $pages == "Profil" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=Profil'><i class='fa fa-user'></i> <span>Profil</span></a></li>";
        $cekAktif = $pages == "Loker" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=Loker'><i class='fa fa-paper-plane-o'></i> <span>Loker</span></a></li>";
        $cekAktif = $pages == "Lamaranku" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=Lamaranku'><i class='fa fa-paper-plane'></i> <span>Lamaranku</span></a></li>";
        $cekAktif = $pages == "ListTkdb" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=ListTkdb'><i class='fa fa-book'></i> <span>TKDB</span></a></li>";
        // $cekAktif = $pages == "UjianTkdb" ? "class='active'" : "";
        // echo "<li $cekAktif><a href='index.php?page=UjianTkdb'><i class='fa fa-book'></i> <span>Ujian Tkdb</span></a></li>";
    }
    if($_SESSION['Careesma_Level'] == "0"){
        echo "<li class='treeview $cekAktifMasterData'>";
        echo "<a href='#'>
                <i class='fa fa-archive'></i>Master Data<span></span>
                <span class='pull-right-container'>
                <i class='fa fa-angle-left pull-right'></i>
                </span>
            </a>";
            echo "<ul class='treeview-menu'>";
                    foreach($MasterData as $key => $data){
                        $cekAktif = $pages == $key ? "class='active'" : "";
                        echo "<li $cekAktif><a href='index.php?page=".$key."'><i class='fa fa-angle-double-right'></i> <span>".$data."</span></a></li>";
                    }
                    
            echo "</ul>";
        echo "</li>";
        // echo "<li class='treeview $cekAktifJobVacancy'>";
        // echo "<a href='#'>
        //         <i class='fa fa-tags'></i>Job Vacancy<span></span>
        //         <span class='pull-right-container'>
        //         <i class='fa fa-angle-left pull-right'></i>
        //         </span>
        //     </a>";
        //     echo "<ul class='treeview-menu'>";
        //             foreach($JobVacancy as $key => $data){
        //                 $cekAktif = $pages == $key ? "class='active'" : "";
        //                 echo "<li $cekAktif><a href='index.php?page=".$key."'><i class='fa fa-angle-double-right'></i> <span>".$data."</span></a></li>";
        //             }
                    
        //     echo "</ul>";
        // echo "</li>";
        $cekAktif = $pages == "Applicant" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=Applicant'><i class='fa fa-users'></i> <span>Pelamar</span></a></li>";
        $cekAktif = $pages == "RekapData" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=RekapData'><i class='fa fa-book'></i> <span>Rekap Data Hasil TKDB</span></a></li>";
        $cekAktif = $pages == "SeleksiBerkas" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=SeleksiBerkas'><i class='fa fa-tag'></i> <span>Seleksi Berkas</span></a></li>";
        $cekAktif = $pages == "KirimEmail" ? "class='active'" : "";
        echo "<li $cekAktif><a href='index.php?page=KirimEmail'><i class='fa fa-paper-plane'></i> <span>Kirim Email</span></a></li>";
        $cekAktif = $pages == "HistoryEmail" ? "class='active'" : "";
    echo "<li $cekAktif><a href='index.php?page=HistoryEmail'><i class='fa fa-envelope-open'></i> <span>Histori Pengiriman Email</span></a></li>";
    }
        
   
echo "</ul>";

?>