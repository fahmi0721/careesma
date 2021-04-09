<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" id="Title">Title</h3>
        <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <button onclick='Crud()' class='btn btn-sm btn-primary' title='Tambah Data' data-toggle='tooltip'><i class='fa fa-plus'></i> Tambah</button>
                <button class='btn btn-sm btn-warning btn-flat' onclick="location.reload();" title='Reload' data-toggle='tooltip'><i class='fa fa-refresh'></i></button>
            </div>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <form  id='FormData' class='form-horizontal'>
            <input type='hidden' id='aksi' name='aksi' />
            <input type='hidden' id='Id' name='Id' />
            <div class='col-md-4 col-sm-3'>

            </div>
            <div class='col-md-8 col-sm-9'>
                <div class='row'>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Kategori Job <span class='text-danger'>*</span></label>
                            <select class='form-control select-category' name='IdKategori' id='IdKategori'></select>
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Judul Lowongan <span class='text-danger'>*</span></label>
                            <input class='form-control FormInput' autocomplete='off' placeholder='Judul Lowongan' name='Judul' id='Judul' />
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Kuota <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input class='form-control FormInput' autocomplete='off' onkeyup='angka(this)' placeholder='Kuota' name='Kuota' id='Kuota' />
                                <span class='input-group-addon'><i class='fa fa-user'></i></span>
                            </div>
                        </div>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Batas Berlaku <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input class='form-control FormInput' autocomplete='off' placeholder='Batas Berlaku' name='TglBerlaku' id='TglBerlaku' />
                                <span class='input-group-addon'><i class='fa fa-calendar'></i></span>
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for='DeskripsiPekerjaan'>
                            <label class='control-label'>Deskripsi Pekerjaan  <span class='text-danger'>*</span></label>
                            <textarea id='DeskripsiPekerjaan' name='DeskripsiPekerjaan'  autocomplete=off rows='5'  class='form-control FormInput' placeholder='Deskripsi Pekerjaan'></textarea> 
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for='Persyaratan'>
                            <label class='control-label'>Persyaratan <span class='text-danger'>*</span></label>
                            <textarea id='Persyaratan' name='Persyaratan' autocomplete=off rows='5'  class='form-control FormInput wysihtml5' placeholder='Persyaratan'></textarea> 
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Flayer (.jpeg or .jpg) <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input class='form-control' type='file' name='Flayer' id='Flayer' />
                                <span class='input-group-addon'><i class='fa fa-image'></i></span>
                            </div>
                        </div>

                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Flag <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <span class='input-group-addon'><input type="radio" name='Flag' id='Flag1' value='1' checked></span>
                                <input type="text" value='Aktif' class='form-control' readonly>
                                <span class='input-group-addon'><input type="radio" name='Flag' id='Flag0' value='0'></span>
                                <input type="text" value='Tidak Aktif' class='form-control' readonly>
                            </div>
                        </div>
                    </div>
                    <legend>Persyaratan Khusus</legend>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Batas Usia <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <input class='form-control' type='text' name='BatasUsia' id='BatasUsia' />
                                <span class='input-group-addon'>Tahun</span>
                            </div>
                        </div>

                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Dokumen Khusus (SIM B2 Umum,SIO,KTA) <span class='text-danger'>*</span></label>
                            <div class='input-group'>
                                <span class='input-group-addon'><input type="radio" name='DokumenKhusus' id='DokumenKhususYa' value='Ya' checked></span>
                                <input type="text" value='Ya' class='form-control' readonly>
                                <span class='input-group-addon'><input type="radio" name='DokumenKhusus' id='DokumenKhususTidak' value='Tidak'></span>
                                <input type="text" value='Tidak' class='form-control' readonly>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Submit</button>
                                <button onclick='Clear()' type='button'  class='btn btn-sm btn-danger btn-flat'><i class='fa fa-mail-reply'></i> Batal</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </form>

         <div id="DetailData">
            <div class="col-sm-1">
                <select class='form-control' id='RowPage' onchange='LoadData()'>
                    <option value='10'>10</option>
                    <option value='25'>25</option>
                    <option value='50'>50</option>
                    <option value='75'>75</option>
                    <option value='100'>100</option>
                </select>
            </div>
            <div class="col-sm-3 col-sm-offset-8">
                <div class='input-group'>
                    <input type='text' id='Search' onkeyup='LoadData()' data-toggle='tooltip' title='Masukkan Nama' class='form-control' placeholder='Cari Nama...'> 
                    <span class='input-group-addon'><i class='fa fa-search'></i></span>
                </div>
            </div>
            <div class="col-sm-12" style='margin-top:10px'>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5px"><center>No</center></th>
                            <th>Judul Lowongan</th>
                            <th>Kuota</th>
                            <th>Batas Berlaku</th>
                            <th width='15%'>Flayer</th>
                            <th width="10%"><center>Aksi</center></th>
                        </tr>
                    </thead>
                    <tbody id='ShowData'></tbody>
                </table>
            </div>
            <div>
                <span class='pull-left' id='PagingInfo'></span>
                <span class='pull-right' id='Paging'></span>
                <span class='clearfix'></span>
            </div>
            </div>
            
        </div> 
    </div>

    <div class="overlay LoadingState" >
        <i class="fa fa-refresh fa-spin"></i>
    </div>

</div>


<div class='modal fade in' id='modal' data-keyboard="false" data-backdrop="static" tabindex='0' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
<div class='modal-dialog'>
<div class='modal-content'>
<div class="modal-header">
    <button type="button" class="close" id="close_modal" data-dismiss="modal">&times;</button>
    <h5 class="modal-title">Konfirmasi Delete</h5>
</div>
<div class='modal-body'>

    <div id="proses_del"></div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" onclick="SubmitData()"><i class="fa fa-check-square"></i> &nbsp;Hapus</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="Clear()"><i class="fa fa-mail-reply"></i> &nbsp;Batal</button>
    </div>

</div>
</div>
</div>
</div>