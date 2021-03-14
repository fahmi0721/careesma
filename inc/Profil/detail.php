<?php 
    include_once "fungsi.php"; 
    $DataDiri = LoadDataDiri();
    $Foto = "img/avatar04.png";
        if(!empty($DataDiri['Foto']) && file_exists("img/Foto/".$DataDiri['Foto'])){
            $Foto = "img/Foto/".$DataDiri['Foto'];
        }
    $_SESSION['IdUser'] = $DataDiri['Id'];
    $DataSerifikasi = LoadSertifikasi();
    $DataKerja = LoadKerja();
    
    
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
                <b>Sertifikasi</b> <label class="pull-right" id='SertifikasiJum'>0</label>
            </li>
            <li class="list-group-item">
                <b>Pengalaman Kerja</b> <label class="pull-right" id='PkJum'>0</label>
            </li>
            </ul>
            
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <div class="box box-primary">
        <div class="box-body box-profile">
            <div id="ProsesFoto"></div>
            <div class='col-sm-12'>
            <form class='form-horizontal' id='FormUpdateFoto'>
                <input type='hidden' name='Id' value='<?= $DataDiri['Id'] ?>'>
                <div class='form-group'>
                    <label class='control-label'>Ubah Foto (*.jpeg, *.jpg)</label>
                    <input type='file' name='Foto' id='Foto' accept='.jpeg, .jpg' class='form-control FormInput' />
                </div>
                <div class='form-group'>
                    <button class='btn btn-sm btn-success' type='submit'><i class='fa fa-check-square'></i> Update</button>
                </div>
            </form>
            </div>
           
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
                            <input type='text'  autocomplete='off' class='form-control' name='Pendidikan' id='Pendidikan' value='<?= $DataDiri['Pendidikan'] ?>' placeholder='Pendidikan' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>No HP <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-mobile'></i></span>
                                <input type='text' onkeyup='angka(this)' autocomplete='off' class='form-control' value='<?= $DataDiri['NoHp'] ?>' name='NoHp' id='NoHp' placeholder='No HP' />
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
                            <label class='control-label'>File Ijazah Terkahir <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='file' data-toggle='tooltip' name='FileIjazah' id='FileIjazah' title='maximal file 2mb dan hanya file pdf' class='form-control' accept='.pdf'  name='File' id='File'  />
                                <span class='input-group-addon'><i class='fa fa-file'></i></span>
                            </div>

                            <label class='control-label'>Foto Ktp <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='file' data-toggle='tooltip' name='FileKtp' id='FileKtp' title='maximal file 2mb dan hanya file gambar *(jpg,jpeg,png)' class='form-control' accept='.jpg,jpeg,png'  name='File' id='File'  />
                                <span class='input-group-addon'><i class='fa fa-file'></i></span>
                            </div>
                            
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Alamat <span class='text-danger'>*</span></label>
                            <textarea  autocomplete='off' class='form-control' rows='5' name='Alamat' id='Alamat' placeholder='Alamat'><?= $DataDiri['Alamat']; ?></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <span class='pull-right'>
                                <button class='btn btn-primary'><i class='fa fa-check-square'></i> Simpan</button>
                            </span>
                        </div>
                    </div>
                </form>
                
            </div>
            <!-- /.tab-pane -->
            <div <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "Sertifikasi"){ echo "class='active tab-pane'"; }else{ echo "class='tab-pane'"; } ?> id="Sertifikasi">
                <div id='proses_sertifikasi'></div>
                <form class='form-horizontal' id='FormDataSertifikasi'>
                    <input type='hidden' name='Id' value='<?= $DataDiri['Id'] ?>'>
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label class='control-label'>Nama Sertifikasi/Lisensi<span class='text-danger'>*</span></label>
                            <input type='text' name='NamaSertifikasi' id='NamaSertifikasi' autocomplete='off' id='NoKtp' class='form-control FormInput' placeholder='NamaSertifikasi' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Tanggal Perolehan <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='text' name='TglPerolehan'  autocomplete='off' id='TglPerolehan' class='form-control FormInput' placeholder='Tanggal Perolehan' />
                                <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Tanggal Expired <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='text' name='TglExpire'  autocomplete='off' id='TglExpire' class='form-control FormInput' placeholder='Tanggal Expired' />
                                <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label class='control-label'>Keterangan </label>
                            <textarea class='form-control FormInput' name='Keterangan' id='Keterangan' placeholder='Keterangan' rows='5'></textarea>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>File Sertifikasi <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='file' class='form-control' accept='.jpg,.jpeg,.pdf'  name='File' id='File'  />
                                <span class='input-group-addon'><i class='fa fa-file'></i></span>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <span class='pull-right'>
                                <button class='btn btn-primary'><i class='fa fa-check-square'></i> Simpan</button>
                                <button type='button' onclick='Clear()' class='btn btn-danger'><i class='fa fa-mail-reply'></i> Kembali</button>
                            </span>
                        </div>
                    </div>
                </form>
                <div id='DetailSertifikasi'>
                    <button class='btn  btn-primary' onclick='Crud("Sertifikasi")' style='margin-bottom:10px;'><i class='fa fa-plus'></i> Tambah</button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5px"><center>No</center></th>
                                    <th>Nama Sertifikasi/Lisensi</th>
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
                <form class='form-horizontal' id='FormDataKerja'>
                    <input type='hidden' name='Id' value='<?= $DataDiri['Id'] ?>'>
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label class='control-label'>Instansi/Perusahaan <span class='text-danger'>*</span></label>
                            <input type='text' name='Instansi' id='Instansi' autocomplete='off'  class='form-control FormInput' placeholder='Instansi/Perusahaan' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Tanggal Masuk <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='text' name='TglMasuk'  autocomplete='off' id='TglMasuk' class='form-control FormInput' placeholder='Tanggal Masuk' />
                                <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Tanggal Keluar <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='text' name='TglKeluar'  autocomplete='off' id='TglKeluar' class='form-control FormInput' placeholder='Tanggal Keluar' />
                                <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Upah <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <span class='input-group-addon'>Rp. </span>
                                <input type='text' name='Upah' onkeyup='rupiah(this)' autocomplete='off' id='Upah' class='form-control FormInput' placeholder='Upah' />
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>SK <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='file' class='form-control' accept='.jpg,.jpeg,.pdf'  name='File' id='Files'  />
                                <span class='input-group-addon'><i class='fa fa-file'></i></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <span class='pull-right'>
                                <button class='btn btn-primary'><i class='fa fa-check-square'></i> Simpan</button>
                                <button type='button' onclick='Clear()' class='btn btn-danger'><i class='fa fa-mail-reply'></i> Kembali</button>
                            </span>
                        </div>
                    </div>
                </form>
                <div id='DetailKerja'>
                    <button class='btn  btn-primary' onclick='Crud("Kerja")' style='margin-bottom:10px;'><i class='fa fa-plus'></i> Tambah</button>
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
             <!-- <!-- <div <?php if(isset($_GET['aksi']) && $_GET['aksi'] == "Dokumen"){ echo "class='active tab-pane'"; }else{ echo "class='tab-pane'"; } ?> id="Dokumen">
             <div id='proses_dokumen'></div>
                <div>
                    <p>Masukkan Dokumen Pendukung Anda jika ada, seperti</p>
                    <ul>
                        <li>SKCK</li>
                    </ul>
                </div>
                <form class='form-horizontal' id='FormDataDokumen'>
                    <input type='hidden' name='Id' value='<?= $DataDiri['Id'] ?>'>
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label class='control-label'>Nama Dokumen <span class='text-danger'>*</span></label>
                            <input type='text' name='NamaDokumen' id='NamaDokumen' autocomplete='off'  class='form-control FormInput' placeholder='Nama Dokumen' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>FILE <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input type='file' class='form-control' accept='.jpg,.jpeg,.pdf'  name='File' id='Files'  />
                                <span class='input-group-addon'><i class='fa fa-file'></i></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <span class='pull-right'>
                                <button class='btn btn-primary'><i class='fa fa-check-square'></i> Simpan</button>
                                <button type='button' onclick='Clear()' class='btn btn-danger'><i class='fa fa-mail-reply'></i> Kembali</button>
                            </span>
                        </div>
                    </div>
                </form>
                <div id='DataDokumen'>
                <button class='btn  btn-primary btn-sm' onclick='Crud("Dokumen")' style='margin-bottom:10px;'><i class='fa fa-plus'></i> Tambah</button>
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