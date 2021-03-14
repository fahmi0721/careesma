<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="img/avatar04.png" alt="User profile picture">

            <h3 class="profile-username text-center">Nina Mcintire</h3>

            <p class="text-muted text-center">S1 Teknik Informatika</p>

            <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
                <b>Sertifikasi</b> <a class="pull-right">1,322</a>
            </li>
            <li class="list-group-item">
                <b>Pengalaman Kerja</b> <a class="pull-right">543</a>
            </li>
            </ul>

        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
        
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#DataPribadi" data-toggle="tab">Data Diri</a></li>
            <li><a href="#Sertifikasi" data-toggle="tab">Sertifikasi</a></li>
            <li><a href="#PengalamanKerja" data-toggle="tab">Pengalaman Kerja</a></li>
            <li><a href="#Dokumen" data-toggle="tab">Dokumen</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="DataPribadi">
                <form class='form-horizontal' id='FormDataPribadi'>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>No KTP</label>
                            <input type='text' name='NoKtp' readonly autocomplete='off' id='NoKtp' class='form-control FormInput' placeholder='No KTP' />
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Nama</label>
                            <input type='text' name='Nama' readonly id='Nama' autocomplete='off' class='form-control FormInput' placeholder='Nama' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Tempat Lahir</label>
                            <input type='text' name='TptLahir' readonly autocomplete='off' id='TptLahir' class='form-control FormInput' placeholder='Tempat Lahir' />
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Tanggal Lahir</label>
                            <div class='input-group'>
                                <input type='text' name='TglLahir' readonly autocomplete='off' id='TglLahir' class='form-control FormInput' placeholder='Tanggal Lahir' />
                                <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Jenis Kelamin</label>
                            <input type='text'  id='JK' autocomplete='off' readonly class='form-control FormInput' placeholder='Nama' />
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Pendidikan Terakhir</label>
                            <input type='text'  autocomplete='off' readonly class='form-control' name='Pendidikan' id='Pendidikan' placeholder='Pendidikan' />
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>No HP</label>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-mobile'></i></span>
                                <input type='text' autocomplete='off' readonly class='form-control' name='NoHp' id='NoHp' placeholder='No HP' />
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Email</label>
                            <div class='input-group'>
                                <input type='text' autocomplete='off' readonly class='form-control' name='Email' id='Email' placeholder='Email' />
                                <span class='input-group-addon'><i class='fa fa-envelope'></i></span>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <label class='control-label'>Agama</label>
                            <input type='text'  id='Agama' readonly autocomplete='off' class='form-control FormInput' placeholder='Nama' />
                            
                        </div>
                        <div class='col-md-6'>
                            <label class='control-label'>Alamat</label>
                            <textarea  autocomplete='off' readonly class='form-control' rows='5' name='Alamat' id='Alamat' placeholder='Alamat'></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="Sertifikasi">
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
                        <tbody id='ShowData'></tbody>
                    </table>
                </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="PengalamanKerja">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5px"><center>No</center></th>
                                <th>Nama Instansi / Perusahaan</th>
                                <th>Periode Waktu</th>
                                <th>Upah</th>
                                <th>Keterangan</th>
                                <th width='10%'>File</th>
                            </tr>
                        </thead>
                        <tbody id='ShowData'></tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="Dokumen">
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
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>