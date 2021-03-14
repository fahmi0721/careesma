<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" id="Title">Kirim Email</h3>
        <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <button class='btn btn-sm btn-warning btn-flat' onclick="location.reload();" title='Reload' data-toggle='tooltip'><i class='fa fa-refresh'></i></button>
            </div>
        </div>
    </div>
    
    <div class="box-body">
        <div class="col-sm-12"><div class="row"><div id="proses"></div></div></div>
        <form  id='FormData' class='form-horizontal'>
            <input type='hidden' id='aksi' name='aksi' value='insert' />
            <input type='hidden' id='Id' name='Id' />
            <div class='col-md-4 col-sm-3'>

            </div>
            <div class='col-md-8 col-sm-9'>
                <div class='row'>
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Lowongan Pekerjaan <span class='text-danger'>*</span></label>
                            <select class='form-control select-category' name='IdLowongan' id='IdLowongan'></select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Hasil Seleksi <span class='text-danger'>*</span></label>
                            <select class='form-control select-category1' name='Ket' id='Ket'>
                                <option value=''></option>
                                <option value='LULUS'>LULUS</option>
                                <option value='TIDAK LULUS'>TIDAK LULUS</option>
                            </select>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <label class='control-label'>Subjek <span class='text-danger'>*</span></label>
                            <input class='form-control FormInput' name='Subjek' autocomplete=off id='Subjek'>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-sm-12 col-md-12'>
                            <label class='control-label' for='Pesan'>Pesan <span class='text-danger'>*</span></label>
                            <textarea class='form-control FormInput' name='Pesan' autocomplete=off id='Pesan' rows='10'></textarea>
                        </div>
                    </div>

                    
                    <div class='form-group'>
                        <div class='col-sm-6 col-md-6'>
                            <div class='btn-group'>
                                <button  class='btn btn-sm btn-primary btn-flat'><i class='fa fa-check-square'></i> Get Data</button>
                                <button type='button' id='BtnSubmit' class='btn btn-sm btn-flat btn-success'><i class='fa fa-check-square'></i> Kirim Pesan</button>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

         <div id="DetailData">
            <div class="col-sm-12" style='margin-top:10px'>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5px"><center>No</center></th>
                            <th>Pelamar</th>
                            <th>Jenis Kelamin</th>
                            <th>TTL</th>
                            <th>No Hp</th>
                            <th>Pendidikan Terakhir</th>
                            <th>Usia</th>
                            <th width="10%" class='text-center'><input type='checkbox' id='ChekAll'></th>
                        </tr>
                    </thead>
                    <tbody id='ShowData'></tbody>
                </table>
            </div>
            
            </div>
            
        </div> 
        </form>

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