<!-- <div class="callout callout-info">
    <h4>Info!</h4>

    <p>Terima kasih kunjungan anda hari ini. silahkan pilih job vacancy yang ada, mungkin anda berjodoh disalah satunya</p>
</div> -->
<input type="hidden" value='<?= $_SESSION['Careesma_Level'] ?>' id='LvlSes'>
<?php
include_once "inc/fungsi.php";
$LowongasNew = LoadLowonganNew();
$LoadDataDas = LoadDataDas();
if($_SESSION['Careesma_Level'] == "1"){

?>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-file-pdf-o"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Sertifikasi</span>
                <span class="info-box-number"><?php echo $LoadDataDas['JumSertifikat'] ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa fa-file"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Pengalaman Kerja</span>
              <span class="info-box-number"><?php echo $LoadDataDas['JumPk'] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
    </div>
    
    <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box" data-toggle='tooltip' title='Jumlah Lowongan Yang Telah Dilamar'>
            <span class="info-box-icon bg-yellow"><i class="fa fa-file-o"></i></span>
            <div class="info-box-content" >
              <span class="info-box-text">Jumlah Lowongan Yang Telah Dilamar</span>
              <span class="info-box-number"><?php echo $LoadDataDas['JumLmr'] ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
    </div>
</div>

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
                <?= $res['DeskripsiPekerjaan'];  ?>
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
<?php } ?>
<?php }else{ 
    $JumlahSoal = JumlahSoal();
    $JumlahPelamar = JumlahPelamar();
    $JumlahLowongan = JumlahLowongan();
    
?>
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-maroon"><i class="fa fa-book"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Soal TKDB</span>
              <span class="info-box-number"><?= rupiah1($JumlahSoal); ?></span>
            </div>
            <!-- /.info-box-content -->
           </div>
    </div>
   
    <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Pelamar</span>
              <span class="info-box-number"><?= rupiah1($JumlahPelamar); ?></span>
            </div>
            <!-- /.info-box-content -->
           </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Jumlah Lowongan</span>
              <span class="info-box-number"><?= rupiah1($JumlahLowongan); ?></span>
            </div>
            
          </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Pelamar Berdasarkan  Pendidikan</h3>
                
            </div>
            <div class="box-body">
                <center><canvas id="pieJp" style="height:150px"></canvas></center>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Pelamar Berdasarkan Sertifikasi</h3>
                
            </div>
            <div class="box-body">
                <center><canvas id="pieSert" style="height:150px"></canvas></center>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Pelamar Berdasarkan Gender</h3>
                
            </div>
            <div class="box-body">
                <center><canvas id="pieJk" style="height:150px"></canvas></center>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Relatime Ujian TKDB</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th width='5px' class='text-center'>No</th>
                                <th>Nama</th>
                                <th>Loker</th>
                                <th class='center' width='20%'>Sisa Waktu</th>
                            </tr>
                        </thead>
                        <tbody id='RealTimeUjianTkdb'><tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Relatime Hasil TKDB</h3>
                
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th width='5px' class='text-center'>No</th>
                                <th>Nama</th>
                                <th>Loker</th>
                                <th class='center' width='20%'>Hasil</th>
                            </tr>
                        </thead>
                        <tbody id='RealTimeNilaiTkdb'><tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>


<div class='modal fade in' id='modal' data-keyboard="false" data-backdrop="static" tabindex='0' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h5 class="modal-title">KONFIRMASI</h5>
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