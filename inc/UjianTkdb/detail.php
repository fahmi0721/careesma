<?php 
// include "fungsi.php";
if(isset($_GET['SoalId'])){
    $IdJ = filter_var($_GET['SoalId'],FILTER_SANITIZE_STRING);
    ?>
    <input type='hidden' value='<?= $IdJ ?>' id='IdJ' />
    <div class='row'>
        <div class='col-sm-8 col-md-8' style='margin-bottom:10px'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <sapn class='pull-left'>
                        <b>SOAL NO.</b> <label class='btn btn-xs btn-primary btn-flat'><b id='NoSoal'>01</b></label>
                    </sapn>
                    <sapn class='pull-right'>
                        <div class='btn-group'>
                            <label class="btn btn-xs btn-default btn-flat"><b>Sisa Waktu</b></label>
                            <label  class="btn btn-xs btn-primary btn-flat"><b id='SisahWaktu'>00:00:00</b></label>
                        </div>
                    </sapn>
                </div>
                <div class="box-body">
                    <div class="callout callout-info" id='KodeText'></div>
                    <div class="callout callout-default">
                        <div id='Soal'></div>
                    </div>
                    
                    <hr>
                    <div id='Pilihan'></div>
                </div>
                <div class="overlay LoadingState" >
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <div class='row'>
                <div class='col-sm-4 col-xs-4' id="Before"></div>
                <div class='col-sm-4 col-xs-4' id="Ragu"></div>
                <div class='col-sm-4 col-xs-4' id='After'></div>
                <span class='clearfix'></span>
            </div>
            
        </div>
        <div class='col-sm-4 col-md-4'>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Nomor Soal</h3>
                </div>
                <div class="box-body">
                    <div class='row'>
                        <div id='NomorS'></div>
                    </div>
                    <hr>
                    <legend><smaal>Keterangan</small></legend>
                    <ul class="list-group">
                        <li class="list-group-item"><span class='btn btn-success btn-sm'><i class='fa fa-check'></i></span> Telah dijawab</li>
                        <li class="list-group-item"><span class='btn btn-default btn-sm'><i class='fa fa-times'></i></span> Belum dijawab</li>
                    </ul>
                </div>
            </div>
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

        <div id="KetModal"></div>
        <div id="proses_modal" class='table-responsive'></div>
        
        <div class="modal-footer">
            <span id='BtnSubmitSelsesai'></span>
            <button type="button" class="btn btn-sm btn-danger" onclick="ClearModal()"><i class="fa fa-mail-reply"></i> &nbsp;Batal</button>
        </div>

    </div>
    </div>
    </div>
    </div>
<?php }else{
    echo "<script>alert('halaman tidak ditemukan'); window.location='index.php'</script>";

} ?>