<input type='hidden' id='IdJ' name='Id' value='<?= $_GET['Id'] ?>'>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" id="Title">Title</h3>
        <div class='pull-right box-tools'>
            <div class='btn-group' id='BtnControl'>
                <button onclick='Export()' class='btn btn-sm btn-success' title='Export Data' data-toggle='tooltip'><i class='fa fa-file-excel-o'></i> Export Data</button>
            </div>
        </div> 
    </div>
</div>

<div class='paging'></div>
<div id='DetailData'></div>

<div class='paging'></div>

