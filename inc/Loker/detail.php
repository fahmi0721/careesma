<?php
include_once "inc/Loker/fungsi.php";
$LowongasNew = LoadLowongan();
if($_SESSION['Careesma_Level'] == "1"){

?>


<?php 
    if($LowongasNew['Jum'] > 0){

?>
<div class='row'>
    <?php
        foreach ($LowongasNew['data'] as $res) {
        $cekDataDaftar = CekDaftar($res['Id']);
        $LowonganTerdaftar = LowonganTerdaftar($res['Id']);    
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
                    <?php if($LowonganTerdaftar > 0) { ?>
                            <label class='label label-info'>Lowongan ini telah terdaftar di akun anda</label>
                    <?php }else{ ?>
                    <?php if($cekDataDaftar > 0) { ?>
                        <!-- <a class='btn btn-primary' href='#'><i class='fa fa-book'></i> Ujian TKDB</a> -->
                    <?php }else{ ?>
                    <?php if($_SESSION['BiodataLengkap'] < 100){ ?>
                        <button class='btn btn-primary' onclick='Information()'><i class='fa fa-paper-plane'></i> Lamar Sekarang</button>
                    <?php }else{ ?>
                        <a href='index.php?page=Lamar&Idx=<?= base64_encode($res['Id']) ?>' class='btn btn-primary'><i class='fa fa-paper-plane'></i> Lamar Sekarang</a>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                    
                </span>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } } ?>



<div class='modal fade in' id='modal' data-keyboard="false" data-backdrop="static" tabindex='0' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h5 class="modal-title">Information</h5>
</div>
<div class='modal-body'>

    <div id="Results"></div>
    
    <div class="modal-footer">
        <a href='index.php?page=Profil' class="btn btn-sm btn-primary"><i class="fa fa-mail-forward"></i> &nbsp;Lengkapi Data Sekarang</a>
    </div>

</div>
</div>
</div>
</div>