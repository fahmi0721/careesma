<?php
include_once "inc/ListTkdb/fungsi.php";
$LowongasNew = LoadData();
if($_SESSION['Careesma_Level'] == "1"){

?>


<?php 
    if($LowongasNew['Jum'] > 0){

?>
<div class='row'>
    <?php
        foreach ($LowongasNew['data'] as $res) {
        $cekBerkas = CekBerkas();
        $LowonganTerdaftar = LowonganTerdaftarNilai($res['Id']);  
    ?>
    <div class='col-sm-6 col-xs-12'>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title" id="Title"><?= $res['Judul']  ?></h3>
            </div>
            <div class="box-body box-profile">
                <a href="#" class="thumbnail">
                    <img src="img/Flayer/<?= $res['Flayer'] ?>" alt="<?= $res['Flayer'] ?>">
                </a>
                <hr>
                <h4>Deskripsi Pekerjaan</h4>
                <?= $res['DeskripsiPekerjaan'] ?>
                <hr>
                <h4>Persyaratan</h4>
                <?= $res['Persyaratan'] ?>
                <hr />
            </div>
            <div class="box-footer">
                <span class='pull-right'>
                    <?php 
                        if($cekBerkas){
                            echo "<a class='btn btn-primary' href='index.php?page=UjianTkdb&SoalId=".$res['Id']."'><i class='fa fa-book'></i> Ujian TKDB</a>";
                        }else{
                            echo "<a class='btn btn-primary' href='index.php?page=Profil'><i class='fa fa-user'></i> Lengkapi Berkas</a>";
                        }
                    ?>
                    
                </span>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } else{ ?>
    <div class="callout callout-warning">
        <h4>404 Not Found</h4>

        <p>Anda belum melamar Loker di sistem ini</p>
    </div>
<?php } } ?>



<div class='modal fade in' id='modal' data-keyboard="false" data-backdrop="static" tabindex='0' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
<div class='modal-dialog modal-sm'>
<div class='modal-content'>
<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h5 class="modal-title"><b>SKOR ANDA</b></h5>
</div>
<div class='modal-body'>

    <div id="Results"></div>
    
    

</div>
</div>
</div>
</div>