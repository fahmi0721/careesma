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
                            <label class='control-label'>Text</label>
                            <select class='form-control select-kode-text' autocomplete='off' name='KodeText' id='KodeText'></select>
                        </div>

                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>No Soal</label>
                            <select class='form-control select-no-soal' autocomplete='off' name='NoSoal' id='NoSoal' ></select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="Soal">
                            <label class='control-label'>Soal</label>
                            <textarea id='Soal' name='Soal' autocomplete=off rows='10' class='form-control FormInput' placeholder='Soal'></textarea> 
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="A">
                            <label class='control-label'>Pilihan Jawaban (A)</label>
                            <textarea id='A' name='A' autocomplete=off rows='10' class='form-control FormInput' placeholder='A'></textarea> 
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="B">
                            <label class='control-label'>Pilihan Jawaban (B)</label>
                            <textarea id='B' name='B' autocomplete=off rows='10' class='form-control FormInput' placeholder='B'></textarea> 
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="C">
                            <label class='control-label'>Pilihan Jawaban (C)</label>
                            <textarea id='C' name='C' autocomplete=off rows='10' class='form-control FormInput' placeholder='C'></textarea> 
                        </div>
                    </div>
                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12' for="D">
                            <label class='control-label'>Pilihan Jawaban (D)</label>
                            <textarea id='D' name='D' autocomplete=off rows='10' class='form-control FormInput' placeholder='D'></textarea> 
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Kunci Jawaban</label>
                            <select class='form-control select-kunci' autocomplete='off' name='KunciJawaban' id='KunciJawaban'>
                                <option value=''>Pilih Kunci Jawaban</option>
                                <option value='A'>A</option>
                                <option value='B'>B</option>
                                <option value='C'>C</option>
                                <option value='D'>D</option>
                            </select>
                        </div>

                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Bobot</label>
                            <input class='form-control FormInput' onkeyup='angka(this)' autocomplete='off' name='Bobot' id='Bobot' >
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
                            <th>Kode</th>
                            <th>No Soal</th>
                            <th>Kode Text</th>
                            <th>Soal</th>
                            <th>Kunci Jawaban</th>
                            <th>Bobot</th>
                            <th width='8%'>Pilihan Jawaban</th>
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
    <h5 class="modal-title"></h5>
</div>
<div class='modal-body'>

    <div id="proses_modal"></div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" onclick="SubmitData()"><i class="fa fa-check-square"></i> &nbsp;Hapus</button>
        <button type="button" class="btn btn-sm btn-danger" onclick="Clear()"><i class="fa fa-mail-reply"></i> &nbsp;Batal</button>
    </div>

</div>
</div>
</div>
</div>