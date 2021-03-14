<?php 
    include_once "fungsi.php"; 
    if(isset($_GET['Idx']) && isset($_GET['IdL'])){
    $NoKtp = base64_decode($_GET['Idx']);
    $IdLowongan = base64_decode($_GET['IdL']);
    $DataDiri = LoadDataDiri($NoKtp);
    $Foto = "img/avatar04.png";
        if(!empty($DataDiri['Foto']) && file_exists("img/Foto/".$DataDiri['Foto'])){
            $Foto = "img/Foto/".$DataDiri['Foto'];
        }
    $_SESSION['IdUser'] = $DataDiri['Id'];
    $DataSerifikasi = LoadSertifikasi();
    $DataKerja = LoadKerja();
    $CekLulus = CekTabelLulus($DataDiri['Id'],$IdLowongan);
    
    
    
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
                <b>Sertifikasi/Lisensi</b> <label class="pull-right" id='SertifikasiJum'>0</label>
            </li>
            <li class="list-group-item">
                <b>Pengalaman Kerja</b> <label class="pull-right" id='PkJum'>0</label>
            </li>
            </ul>
            <center>
            <?php if($CekLulus['tot'] <= 0){ ?>
                <a href='#' onclick="UpdateDataLulus('<?= $DataDiri['Id'] ?>','<?= $IdLowongan ?>','TIDAK LULUS')" class='btn  btn-sm btn-danger' ><i class='fa fa-times'></i> Tidak Lulus</a> 
                <a href='#' onclick="UpdateDataLulus('<?= $DataDiri['Id'] ?>','<?= $IdLowongan ?>','LULUS')" class='btn  btn-sm btn-success' ><i class='fa fa-check'></i> Lulus</a>
            <?php }else{ ?>
                <label><?= $CekLulus['Keterangan'] ?></label><br>
                <a href='#' onclick="HapusDataLulus('<?= $DataDiri['Id'] ?>','<?= $IdLowongan ?>')" class='btn  btn-sm btn-danger btn-block' ><i class='fa fa-times'></i> Batal</a>
            <?php } ?>
            </center>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->

        
        
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li <?php if(!isset($_GET['aksi'])){ echo "class='active'"; } ?>><a href="#DataPribadi" data-toggle="tab">Data Diri</a></li>
            <li <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "Sertifikasi"){ echo "class='active'"; } ?>><a href="#Sertifikasi" data-toggle="tab">Sertifikasi/Lisensi</a></li>
            <li <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "PengalamanKerja"){ echo "class='active'"; } ?>><a href="#PengalamanKerja" data-toggle="tab">Pengalaman Kerja</a></li>
            <!-- <li <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "Dokumen"){ echo "class='active'"; } ?>><a href="#Dokumen" data-toggle="tab">Dokumen</a></li> -->
        </ul>
        <div class="tab-content">
            <div <?php if(!isset($_GET['aksi'])){ echo "class='active tab-pane'"; }else{ echo "class='tab-pane'"; } ?> id="DataPribadi">
                <div id='proses_data_diri'></div>
                <form class='form-horizontal' id='FormDataPribadi'>
                    <input type='hidden' name='Id' value='<?= $DataDiri['Id'] ?>'>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>No KTP <span class='text-danger'>*</span></label>
                            <input type='text' name='NoKtp' readonly value='<?= $DataDiri['NoKtp'] ?>' autocomplete='off' id='NoKtp' class='form-control FormInput' placeholder='No KTP' />
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Nama <span class='text-danger'>*</span></label>
                            <input type='text' name='Nama' readonly value='<?= $DataDiri['Nama'] ?>' id='Nama' autocomplete='off' class='form-control FormInput' placeholder='Nama' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Tempat Lahir <span class='text-danger'>*</span></label>
                            <input type='text' name='TptLahir' value='<?= $DataDiri['TptLahir'] ?>' autocomplete='off' id='TptLahir' class='form-control FormInput' placeholder='Tempat Lahir' />
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Tanggal Lahir <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='text' name='TglLahir' value='<?= $DataDiri['TglLahir'] ?>' autocomplete='off' id='TglLahir' class='form-control FormInput' placeholder='Tanggal Lahir' />
                                <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Jenis Kelamin <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <span class='input-group-addon'><input type='radio' checked name='JK' id='JKL' value="L"<?php if($DataDiri['JK'] == "L"){ echo "checked"; } ?>></span>
                                <input type='text'  autocomplete='off'class='form-control' value='Laki-Laki' readonly />
                                <span class='input-group-addon'><input type='radio' name='JK' id='JKP' value="P" <?php if($DataDiri['JK'] == "P"){ echo "checked"; } ?>></span>
                                <input type='text'  autocomplete='off'class='form-control' value='Perempuan' readonly />
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Pendidikan Terakhir <span class='text-danger'>*</span></label>
                            <input type='text'  autocomplete='off' class='form-control FormInput' name='Pendidikan' id='Pendidikan' value='<?= $DataDiri['Pendidikan'] ?>' placeholder='Pendidikan' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>No HP <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-mobile'></i></span>
                                <input type='text' onkeyup='angka(this)' autocomplete='off' class='form-control FormInput' value='<?= $DataDiri['NoHp'] ?>' name='NoHp' id='NoHp' placeholder='No HP' />
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Email <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='text' autocomplete='off' class='form-control' readonly value='<?= $DataDiri['Email'] ?>' name='Email' id='Email' placeholder='Email' />
                                <span class='input-group-addon'><i class='fa fa-envelope'></i></span>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Agama <span class='text-danger'>*</span></label>
                            <select class='form-control FormInput' name='Agama' id='Agama'>
                                <option value=''>..:: Pilih Agama ::..</option>
                                <option value='ISLAM' <?php if($DataDiri['Agama'] == "ISLAM"){ echo "selected"; } ?>>ISLAM</option>
                                <option value='KRISTEN KHATOLIK' <?php if($DataDiri['Agama'] == "KRISTEN KHATOLIK"){ echo "selected"; } ?>>KRISTEN KHATOLIK</option>
                                <option value='KRISTEN PROTESTAN' <?php if($DataDiri['Agama'] == "KRISTEN PROTESTAN"){ echo "selected"; } ?>>KRISTEN PROTESTAN</option>
                                <option value='HINDU' <?php if($DataDiri['Agama'] == "HINDU"){ echo "selected"; } ?>>HINDU</option>
                                <option value='BUDHA' <?php if($DataDiri['Agama'] == "BUDHA"){ echo "selected"; } ?>>BUDHA</option>
                                <option value='KONGHUCU' <?php if($DataDiri['Agama'] == "KONGHUCU"){ echo "selected"; } ?>>KONGHUCU</option>
                            </select>
                            
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Alamat <span class='text-danger'>*</span></label>
                            <textarea  autocomplete='off' class='form-control FormInput' rows='5' name='Alamat' id='Alamat' placeholder='Alamat'><?= $DataDiri['Alamat']; ?></textarea>
                        </div>
                    </div>
                    
                </form>
                
            </div>
            <!-- /.tab-pane -->
            <div <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "Sertifikasi"){ echo "class='active tab-pane'"; }else{ echo "class='tab-pane'"; } ?> id="Sertifikasi">
                <div id='proses_sertifikasi'></div>
                <div id='DetailSertifikasi'>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5px"><center>No</center></th>
                                    <th>Nama Sertifikasi</th>
                                    <th>Periode Waktu</th>
                                    <th>Keterangan</th>
                                    <th width="10%">File</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $No=1; 
                                    foreach($DataSerifikasi as $result){ 
                                        $ext = getExtensi($result['File']);
                                        $File = $ext == "pdf" ? "<a data-toogle='tooltip' title='".$result['File']."' href='img/Sertifikasi/".$result['File']."' target='_blank' class='btn btn-xs btn-default'><i class='fa fa-file-pdf-o'></i></a>" : "<a href='img/Sertifikasi/".$result['File']."' target='_blank' data-toogle='tooltip' title='".$result['File']."' class='btn btn-xs btn-default'><i class='fa fa-picture-o'></i></a>";
                                    ?>
                                    <tr>
                                        <td widtd="5px"><center><?= $No ?></center></td>
                                        <td><?= $result['NamaSertifikasi'] ?></td>
                                        <td><?= tgl_indo($result['TglPerolehan'])." s/d ".tgl_indo($result['TglExpire']) ?></td>
                                        <td><?= $result['Keterangan'] ?></td>
                                        <td widtd="10%"><?= $File ?></td>
                                    </tr>
                                <?php $No++;   }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.tab-pane -->

            <div <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "PengalamanKerja"){ echo "class='active tab-pane'"; }else{ echo "class='tab-pane'"; } ?> id="PengalamanKerja">
                <div id='proses_kerja'></div>
                <div id='DetailKerja'>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5px"><center>No</center></th>
                                    <th>Nama Instansi / Perusahaan</th>
                                    <th>Periode Waktu</th>
                                    <th>Upah</th>
                                    <th width='10%'>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php 
                                    $No=1; 
                                    foreach($DataKerja as $result){ 
                                        $ext = getExtensi($result['File']);
                                        $File = $ext == "pdf" ? "<a data-toogle='tooltip' title='".$result['File']."' href='img/PengalamanKerja/".$result['File']."' target='_blank' class='btn btn-xs btn-default'><i class='fa fa-file-pdf-o'></i></a>" : "<a href='img/PengalamanKerja/".$result['File']."' target='_blank' data-toogle='tooltip' title='".$result['File']."' class='btn btn-xs btn-default'><i class='fa fa-picture-o'></i></a>";
                                    ?>
                                    <tr>
                                        <td widtd="5px"><center><?= $No ?></center></td>
                                        <td><?= $result['Instansi'] ?></td>
                                        <td><?= tgl_indo($result['TglMasuk'])." s/d ".tgl_indo($result['TglKeluar']) ?></td>
                                        <td>Rp. <?= rupiah1($result['Upah']) ?></td>
                                        <td widtd="10%"><?= $File ?></td>
                                    </tr>
                                <?php $No++;   }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "Dokumen"){ echo "class='active tab-pane'"; }else{ echo "class='tab-pane'"; } ?> id="Dokumen">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5px"><center>No</center></th>
                                <th>Nama Dokumen</th>
                                <th width='10%'>File</th>
                            </tr>
                        </thead>
                        <tbody id='ShowData'></tbody>
                    </table>
                </div>
            </div> -->
            <!-- /.tab-pane -->
            
        </div>
        <!-- /.tab-content -->
        </div>
        
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>

<?php }else{
    header("location:index.php");
}
?>