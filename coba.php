<?php
    include "config/config.php";
    $r = $db->query("SELECT Soal FROM careesma_tkdb_soal WHERE IdJobVacancy = 6 LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    $dt = json_decode(base64_decode($r['Soal']),true);
    echo "<pre>";
    print_r($dt);
    echo "<pre>";
?>