<?php 
    include_once "fungsi.php"; 
    if($_SESSION['BiodataLengkap'] < 100){
        header("location:index.php?page=Profil");
    }
    if(!isset($_GET['Idx'])){
        header("location:index.php");
    }
    $Idx = base64_decode($_GET['Idx']);
    $res = LoadLowongan($Idx);
    $DataDiri = LoadDataDiri();
    $Foto = "img/avatar04.png";
        if(!empty($DataDiri['Foto']) && file_exists("img/Foto/".$DataDiri['Foto'])){
            $Foto = "img/Foto/".$DataDiri['Foto'];
        }
    $_SESSION['IdUser'] = $DataDiri['Id'];
    
    $cekKualifikasi = cekKualifikasi($Idx);
    
?>
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="<?= $Foto ?>" alt="User profile picture">

            <h3 class="profile-username text-center"><?= $DataDiri['Nama'] ?></h3>

            <p class="text-muted text-center"><?= $DataDiri['Email'] ?></p>

            <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Sertifikasi</b> <a class="pull-right">0</a>
            </li>
            <li class="list-group-item">
                <b>Pengalaman Kerja</b> <a class="pull-right">0</a>
            </li>
            </ul>
            
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->

        
    </div>
    <!-- /.col -->
    <div class="col-md-9">
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
                <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
                <form  id='FormData' class='form-horizontal'>
                    <input type='hidden' id='Id' value="<?= $res['Id'] ?>" name='Id' />
                    <input type='hidden' id='IdUser' value="<?= $DataDiri['Id'] ?>" name='IdUser' />
                    <div class='form-group'>
                        <div class='col-sm-12'>
                            <label class='control-label'>Alasan</label>
                            <textarea class='form-control FormInput' name='Alasan' id='Alasan' rows='5' placeholder='Alasan Melamar Lowongan ini?'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12'>
                            <span class='pull-right'>
                                <?php 
                                    if($cekKualifikasi['pesan'] == "gagal_usia"){
                                ?>
                                    <span class='label label-warning'>Lowongan ini tidak masuk dalam kriteria usia anda</span>
                                <?php }elseif($cekKualifikasi['pesan'] == "gagal_sertifikat"){ ?>
                                        <span class='label label-warning'>anda tidak memkiliki lisensi untuk melamar lowongan ini</span>
                                       
                                <?php }else{ ?>
                                    <button class='btn btn-primary'><i class='fa fa-check-square'></i> Masukkan Lamaran</button>
                                <?php } ?>
                                
                            </span>
                        </div>
                        
                    </div>
                </form>
            </div>
            <div class="overlay LoadingState" >
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
        
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>